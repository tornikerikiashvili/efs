@php
    app()->setLocale(session('locale', config('app.locale')));
@endphp
<!DOCTYPE html>
<html lang="{{ html_lang_attribute() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>404 — EFS</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/skin.css?5">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f6fa;
            color: #3c4043;
            font-family: Roboto, Arial, sans-serif;
        }

        .error-page {
            text-align: center;
            padding: 40px 24px;
            max-width: 520px;
        }

        .error-page img {
            width: 180px;
            max-width: 70vw;
            margin-bottom: 32px;
        }

        .error-page h1 {
            margin: 0 0 12px;
            font-size: 72px;
            line-height: 1;
            font-weight: 700;
            color: #3f4a7c;
        }

        .error-page p {
            margin: 0 0 28px;
            font-size: 18px;
            line-height: 1.6;
            color: #5f6368;
        }

        .error-page .btn-home {
            display: inline-block;
            padding: 12px 28px;
            background-color: #3f4a7c;
            border: 1px solid #3f4a7c;
            border-radius: 3px;
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        .error-page .btn-home:hover,
        .error-page .btn-home:focus {
            background-color: #343d69;
            border-color: #343d69;
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="error-page">
        <a href="{{ url('/') }}">
            <img src="/images/Logo-{{ app()->getLocale() }}.png?2" alt="EFS">
        </a>
        <h1>404</h1>
        <p>{{ __('other.error_404_message') }}</p>
        <a class="btn-home" href="{{ url('/') }}">{{ __('other.error_404_home') }}</a>
    </div>
</body>
</html>
