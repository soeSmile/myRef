<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('auth.confirmTitle') }}</title>
</head>
<body>
<div class="wrap">
    <h1 class="confirm">
        <i>&#10003;</i>
        <span>Успешно</span>
    </h1>
    <p class="center">
        Можете перейти на сайт.
        <a href="/login">
            Ссылка
        </a>
    </p>
</div>
</body>

<style>
    body {
        background: #7FBA7A;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .confirm {
        text-align: center;
        font-size: 4em;
        color: white;
        margin-top: 10rem;
    }

    i {
        margin: 0 1rem 0 1rem;
    }

    a {
        text-decoration: none;
        color: #397cf1;
    }

    .center{
        margin-top: 10rem;
        text-align: center;
        font-size: 2em;
        color: white;
    }
</style>
</html>