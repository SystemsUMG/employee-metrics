<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
        rel="stylesheet"
    />

    <!-- Font Awesome Icons -->
    <script
        src="https://kit.fontawesome.com/42d5adcbca.js"
        crossorigin="anonymous"
    ></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
    />

    <script async defer src="https://buttons.github.io/buttons.js"></script>

    @vite('resources/css/app.css')

</head>
<body class="bg-gray-100">
<noscript>
    <strong
    >We're sorry but Vue Argon Dashboard 2 doesn't work properly without
        JavaScript enabled. Please enable it to continue.</strong
    >
</noscript>
<div id="app" class="g-sidenav-show"></div>

@vite('resources/js/app.js')
</body>
</html>
