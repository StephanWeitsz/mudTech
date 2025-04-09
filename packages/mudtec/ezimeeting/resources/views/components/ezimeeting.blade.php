<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="keywords" content="meeting minutes">
		<meta name="description" content="ezi-Meeting : maintain meeting minutes per department ion an orginazation">
		<meta name='copyright' content='2024'>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>eziMeeting</title>

        <!-- Favicon -->
        <link rel="icon" href="{{asset('img/favicon.png')}}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        

        <!-- Custom styles -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">

        <x-menu.load></x-menu.load>

        
        @yield('content')
    

        <x-footer.load></x-footer.load>
        
    </body>
</html>
