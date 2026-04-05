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
    class="bg-[#EEEBD9] font-sans antialiased text-[#282427] min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    {{-- Artistic Background --}}
    <div class="absolute -top-40 -left-40 w-[600px] h-[600px] bg-[#BC6C25]/10 blur-[120px] rounded-full -z-10"></div>
    <div class="absolute -bottom-40 -right-40 w-[600px] h-[600px] bg-[#282427]/5 blur-[120px] rounded-full -z-10"></div>

    <div
        class="flex w-full max-w-lg flex-col gap-8 bg-white/70 backdrop-blur-xl p-10 md:p-14 rounded-[40px] shadow-[0_30px_60px_rgba(40,36,39,0.08)] border border-[#282427]/5 relative z-10">

        {{-- Custom Brand Logo --}}
        {{-- Full reload: avoids Livewire navigate + classic Fortify forms mixing (empty POST fields / CSRF quirks). --}}
        <a href="{{ url('/') }}" class="flex flex-col items-center gap-4 group mx-auto mb-4">
            <x-luja-mark size="xl" class="group-hover:-translate-y-1 transition-transform duration-300" />
            <span class="text-3xl font-black tracking-tight text-[#282427]"><span
                    class="text-[#BC6C25]">Luja</span>Talks.</span>
        </a>

        {{-- Auth Specific Content Injection --}}
        <div class="flex flex-col gap-8">
            <style>
                /* Overriding generic auth headers to match our style */
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

                /* Override buttons inside the form */
                button[type="submit"] {
                    background-color: #BC6C25 !important;
                    color: white !important;
                    border: none !important;
                    border-radius: 9999px !important;
                    padding-top: 1rem !important;
                    padding-bottom: 1rem !important;
                    font-weight: 900 !important;
                    font-size: 16px !important;
                    box-shadow: 0 10px 25px rgba(188, 108, 37, 0.4) !important;
                    transition: all 0.3s ease !important;
                    width: 100% !important;
                }

                button[type="submit"]:hover {
                    background-color: #a65d1f !important;
                    transform: translateY(-2px) !important;
                    box-shadow: 0 15px 35px rgba(188, 108, 37, 0.5) !important;
                }
            </style>
            {{ $slot }}
        </div>
    </div>

    @fluxScripts
</body>

</html>