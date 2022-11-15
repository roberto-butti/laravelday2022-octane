@props([
'links' => [
"home" => "Home",
"static-props" => "Elementi Statici",
"route-get" => "Laravel/Octane Route",
"serial-task" => "Esecuzione seriale Task",
"parallel-task" => "Esecuzione parallela Task",
"set-cache" => "Set Cache",
"get-cache" => "Get Cache",
"get-cache-only" => "Recuperare il valore solo da cache",
"create-table" => "Create Table",
"get-table" => "Get value from Table",

]
])

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
</head>

<body>
    <x-hero />

    <section class="section">
        <div class="columns is-multiline is-mobile is-centered">
            @foreach ($links as $key => $value)
            <div class="column m-2 is-one-quarter {{ Route::currentRouteName() == $key ? 'has-background-primary': 'has-background-primary-light'; }}">
                <a class="{{ Route::currentRouteName() == $key ? 'is_active': '' }}" href={{ route($key) }}>{{ $value }}</a>
            </div>
            @endforeach
        </div>
    </section>

    <div>{{ $slot }}</div>


    <x-footer />


</body>

</html>
