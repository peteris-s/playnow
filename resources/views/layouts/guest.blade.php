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

        <!-- Inline fallback styles so visual changes appear immediately without rebuilding assets -->
        <style>
            /* page background */
            body {
                background: linear-gradient(180deg, #0b1220 0%, #07101a 58%);
                color: #e6eef8;
                font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            }

            /* auth card */
            #auth-card {
                background: rgba(14,20,30,0.55) !important;
                border: 1px solid rgba(255,255,255,0.04) !important;
                border-radius: 14px !important;
                box-shadow: 0 14px 40px rgba(2,6,23,0.55) !important;
                padding: 28px !important;
                max-width: 520px;
            }

            /* inputs */
            #auth-card input[type="email"],
            #auth-card input[type="password"],
            #auth-card input[type="text"] {
                background: rgba(3,8,15,0.5) !important;
                color: #dbeafe !important;
                border: 1px solid rgba(99,102,241,0.14) !important;
                padding: 10px 12px !important;
                border-radius: 8px !important;
                width: 100% !important;
                box-sizing: border-box;
            }

            #auth-card input::placeholder { color: rgba(255,255,255,0.28) !important; }

            /* labels and links inside card */
            #auth-card label, #auth-card .help-text { color: rgba(230,238,248,0.7) !important; }
            #auth-card a { color: rgba(200,210,255,0.85); }

            /* floating CTA */
            .floating-cta {
                width: 56px !important;
                height: 56px !important;
                border-radius: 9999px !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                background: linear-gradient(135deg,#6d28d9,#4f46e5) !important;
                color: #fff !important;
                box-shadow: 0 12px 30px rgba(79,70,229,0.28) !important;
                border: none !important;
            }

            /* position of floating CTA when absolute */
            form.relative .floating-cta { position: absolute !important; right: 22px; bottom: -22px; }

            /* smaller screen tweak */
            @media (max-width: 640px) {
                form.relative .floating-cta { right: 12px; bottom: -18px; }
                #auth-card { margin: 0 18px; }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-gray-900 via-gray-900 to-gray-800">
            <!-- Custom site header with logo -->
            <header class="mb-8 text-center flex flex-col items-center">
                <img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name', 'PlayNow') }} logo" class="w-20 h-20 mb-3" />
                <a href="/" class="text-3xl font-extrabold tracking-tight text-white">{{ config('app.name', 'PlayNow') }}</a>
                <p class="text-sm text-gray-400 mt-1">Play games. Have fun.</p>
            </header>

            <div id="auth-card" class="w-full sm:max-w-md mt-6 px-8 py-8 bg-gray-800 border border-gray-700 shadow-2xl overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
