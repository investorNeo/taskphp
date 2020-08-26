<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 12.07.20
 * Time: 21:41
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Приложение задачник</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
                <a class="navbar-brand nav-item" href="/">Task app</a>
				<?php
				$auth = $_SESSION['auth'] ?? false;
				if ( $auth ):
				?>
                    <a class="nav-item btn btn-outline-success my-2 my-sm-0" href="/login/logout">
                        <img src="/assets/img/arrow-up.svg" alt="arrow-up">
                        &emsp;Выйти из системы
                    </a>
                <?php
                else:
                ?>
                    <a class="nav-item btn btn-outline-success my-2 my-sm-0" href="/login">
                        <img src="/assets/img/arrow-down.svg" alt="arrow-down">
                        &emsp;Авторизоваться
                    </a>
                <?php
                endif;
                ?>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
			<?php
			include __DIR__ . "/{$content_view}";
			?>
        </div>
    </div>
</div>

</body>
</html>
