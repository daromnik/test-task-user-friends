<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dd('Test');
    }
}
