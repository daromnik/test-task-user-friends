<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <title>Hello, world!</title>
    </head>
    <body>
        <div class="container">
            <h1>Список пользователей с друзьями и рекомендациями.</h1>

            <div class="row">

                @foreach ($users as $user)
                    <div class="col-12"><hr></div>

                    <div class="col-12"><h4>{{ $user->id }} | {{ $user->name }}</h4></div>

                    <div class="col-6">
                        <h5>Друзья</h5>
                        <ul>
                            @forelse ($user->friends as $friends)
                               <li>{{ $friends->id }} | {{ $friends->name }}</li>
                            @empty
                                <p>Нет друзей</p>
                            @endforelse
                        </ul>
                    </div>
                    <div class="col-6">
                        <h5>Рекомендованные Друзья</h5>
                        <ul>
                            @forelse ($user->recommends()->orderBy('rate', 'DESC')->get() as $recommends)
                                <li>{{ $recommends->id }} | {{ $recommends->name }}</li>
                            @empty
                                <p>Нет рекомендованных друзей,<br>потому что нет общих друзей у друзей :)</p>
                            @endforelse
                        </ul>
                    </div>
                @endforeach

            </div>
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>