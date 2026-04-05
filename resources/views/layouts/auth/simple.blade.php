<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Luja Talks Auth') }}</title>
    <x-luja-favicon />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body
    class="bg-[#EEEBD9] font-sans antialiased text-[#282427] min-h-screen flex items-center justify-center px-4 py-6 sm:px-6 sm:py-8 relative overflow-x-hidden">

    {{-- Background accents (scaled down on small screens) --}}
    <div class="pointer-events-none absolute -top-32 -left-32 size-[min(100vw,28rem)] bg-[#BC6C25]/10 blur-[80px] rounded-full -z-10 sm:-top-40 sm:-left-40 sm:size-[36rem] sm:blur-[100px]"></div>
    <div class="pointer-events-none absolute -bottom-32 -right-32 size-[min(100vw,28rem)] bg-[#282427]/5 blur-[80px] rounded-full -z-10 sm:-bottom-40 sm:-right-40 sm:size-[36rem] sm:blur-[100px]"></div>

    <div
        class="flex w-full max-w-[22rem] flex-col gap-5 rounded-2xl border border-[#282427]/5 bg-white/80 p-5 shadow-[0_20px_50px_rgba(40,36,39,0.07)] backdrop-blur-xl sm:max-w-md sm:gap-6 sm:rounded-3xl sm:p-7 md:p-8 relative z-10">

        {{-- Brand --}}
        <a href="{{ url('/') }}" class="group mx-auto flex flex-col items-center gap-2 sm:gap-2.5">
            <x-luja-mark size="md" class="group-hover:-translate-y-0.5 transition-transform duration-300" />
            <span class="text-lg font-black tracking-tight text-[#282427] sm:text-xl md:text-2xl"><span
                    class="text-[#BC6C25]">Luja</span>Talks.</span>
        </a>

        <div class="flex flex-col gap-4 sm:gap-5">
            <style>
                .text-zinc-600,
                .text-zinc-500,
                .text-zinc-400 {
                    color: rgba(40, 36, 39, 0.7) !important;
                }

                h1,
                h2,
                h3 {
                    font-weight: 900 !important;
                    color: #282427 !important;
                }

                button[type="submit"] {
                    background-color: #BC6C25 !important;
                    color: white !important;
                    border: none !important;
                    border-radius: 9999px !important;
                    padding-top: 0.625rem !important;
                    padding-bottom: 0.625rem !important;
                    font-weight: 900 !important;
                    font-size: 0.875rem !important;
                    box-shadow: 0 8px 20px rgba(188, 108, 37, 0.35) !important;
                    transition: all 0.2s ease !important;
                    width: 100% !important;
                }

                @media (min-width: 640px) {
                    button[type="submit"] {
                        padding-top: 0.75rem !important;
                        padding-bottom: 0.75rem !important;
                        font-size: 0.9375rem !important;
                    }
                }

                button[type="submit"]:hover {
                    background-color: #a65d1f !important;
                    transform: translateY(-1px) !important;
                    box-shadow: 0 12px 28px rgba(188, 108, 37, 0.45) !important;
                }
            </style>
            {{ $slot }}
        </div>
    </div>

    @fluxScripts
</body>

</html>
