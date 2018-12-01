<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Friend;
use App\Recommendation;

class FillRecommendations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recommendations:fill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Заполняет рекомендации друзей для пользователей';

    /**
     * Если пользователь является общим дргуом это количество раз и меньше,
     * то он не будет рекомендован в друзья первоначальному пользователю
     *
     * пример: 1 - значит в друзья будет рекомендоваться только если
     * пользователь является общим другом у 2 человек минимум
     *
     * @var int
     */
    protected $notRecommendCount = 1;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Команда для запонения таблицы - Рекомендации для друзей.
     *
     * Берутся все записи из связной таблицы друзей.
     * Из них формируется массив, где ключи - это id пользователей,
     * а значения - это массив с id друзей.
     *
     * Рекомендованным другом считается тот пользователь,
     * который встречается в друзьях у всех друзей
     * текущего пользователя [$notRecommendCount + 1] количество раз.
     *
     * Рейтинг - сколько количество раз этот пользователь
     * встречается в друзьях у друзей.
     *
     * @return mixed
     */
    public function handle()
    {
        dump("Начало заполнение друзей.");
        $start = microtime(true);

        $friendsCollection = [];
        Friend::all()->each(function ($item, $key) use (&$friendsCollection) {
            $friendsCollection[$item["user_id"]][] = $item["friend_id"];
        });

        foreach ($friendsCollection as $user => $friends)
        {
            // получаем все массивы с друзьями друзей текущего пользователя
            $friendsFriends = array_intersect_key($friendsCollection, array_flip($friends));

            // добавляем в список друзей id самого пользователя,
            // что бы в дальнейшем убрать все эти id из рекомендованных с помощью array_diff
            $friends[] = $user;

            $applicants = [];
            foreach ($friendsFriends as $ffIds)
            {
                $ffIdsWithoutFirstFrieds = array_diff($ffIds, $friends);

                foreach ($ffIdsWithoutFirstFrieds as $applicant)
                {
                    if (isset($applicants[$applicant]))
                    {
                        $applicants[$applicant]++;
                    }
                    else
                    {
                        $applicants[$applicant] = 1;
                    }
                }
            }

            foreach ($applicants as $recommend_id => $rate)
            {
                // если рейтинг меньше указанного, то в рекомендованые не добавляем
                if ($rate > $this->notRecommendCount)
                {
                    Recommendation::firstOrCreate([
                        'user_id' => $user,
                        'recommend_id' => $recommend_id,
                        'rate' => $rate,
                    ]);
                }

            }
        }

        $end = microtime(true);
        $diff = $end - $start;
        dump("Конец заполнение друзей. Потрачено " . $diff . " сек");
    }
}
