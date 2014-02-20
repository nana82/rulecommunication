<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="utf-8">
        {{ HTML::style('css/bootstrap.min.css') }}
        {{ HTML::style('css/bootstrap-datetimepicker.min.css') }}
        {{ HTML::style('css/layout.css') }}
        {{ HTML::script('js/jquery-1.11.0.min.js') }}
        {{ HTML::script('js/moment.min.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
        {{ HTML::script('js/bootstrap-datetimepicker.min.js') }}
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-default">
                <ul class="nav navbar-nav">
                    <li><a href="{{ URL::to( '/') }}">Single Dispatcher</a></li>
                    <li><a href="{{ URL::to( '/recurringDispatcher') }}">Recurring Dispatcher</a></li>
                    <li><a href="{{ URL::to( '/findDispatchers') }}">Get Dispatchers</a></li>
                </ul>
            </nav>
            {{ $content }}
        </div>
    </body>
</html>