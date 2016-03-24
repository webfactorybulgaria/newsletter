<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

    <head>
        <meta charset="utf-8">
    </head>

    <body>

        <a href="{{ url('/') }}">
            @if (TypiCMS::hasLogo())
                @include('core::public._logo')
            @endif
        </a>

        <h2>@lang('newsletter::global.Thank you for your newsletter request')</h2>

        @include('newsletter::mails._detail', ['model' => $model])

        <hr>

        {!! Blocks::render('signature-mail') !!}

    </body>

</html>
