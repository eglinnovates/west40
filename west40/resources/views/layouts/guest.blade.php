<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full mx-auto sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg bg-[rgb(31,61,123)]">
                <a href="/">
                    <img fetchpriority="high" sizes="174px" srcset="https://static.wixstatic.com/media/871c5a_b0955874382040dd80226fa20be7455e~mv2.png/v1/fill/w_174,h_102,al_c,q_85,usm_0.66_1.00_0.01,enc_avif,quality_auto/w40_logo_White.png 1x, https://static.wixstatic.com/media/871c5a_b0955874382040dd80226fa20be7455e~mv2.png/v1/fill/w_348,h_204,al_c,q_85,usm_0.66_1.00_0.01,enc_avif,quality_auto/w40_logo_White.png 2x" id="img_comp-lnow89ij" src="https://static.wixstatic.com/media/871c5a_b0955874382040dd80226fa20be7455e~mv2.png/v1/fill/w_174,h_102,al_c,q_85,usm_0.66_1.00_0.01,enc_avif,quality_auto/w40_logo_White.png" alt="w40_logo_White.png" style="object-fit:cover" width="174" height="102" class="block mx-auto">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
