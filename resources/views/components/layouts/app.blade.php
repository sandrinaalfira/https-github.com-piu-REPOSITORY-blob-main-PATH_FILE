<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Poliklinik' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Instrument+Serif:ital@0;1&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    {{-- Ini adalah cara yang benar untuk memuat CSS yang sudah dikompilasi --}}
    @vite(['resources/js/app.js','resources/css/app.css'])
</head>

<body class="bg-slate-100 font-sans antialiased">

    {{-- TAMBahkan class flex dan h-screen di sini --}}
    <div class="app-wrapper flex h-screen bg-gray-50">

        {{-- SIDEBAR --}}
        {{-- Pastikan sidebar Anda memiliki lebar tetap, misalnya w-64 --}}
        <div id="appSidebar" class="sidebar-fixed w-64 flex-shrink-0">
            @include('components.partials.sidebar')
        </div>

        {{-- OVERLAY --}}
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        {{-- MAIN --}}
        {{-- INI ADALAH BAGIAN TERPENTING. TAMBAHKAN CLASS FLEX DI SINI --}}
        <div class="main-content flex-1 flex flex-col overflow-hidden">

            @include('components.partials.header')

            {{-- INI JUGA PENTING. JADIKAN INI AREA YANG BISA DIBESARKAN DAN DIGULIR --}}
            <div class="main-scroll flex-1 overflow-y-auto p-6">

                @if(session('success'))
                <div class="alert alert-success mb-4 rounded-xl shadow-sm">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-error mb-4 rounded-xl shadow-sm">
                    <i class="fas fa-circle-xmark"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                {{ $slot }}

            </div>

            @include('components.partials.footer')

        </div>

    </div>

    <script>
        function toggleSidebar(){
            const sidebar=document.getElementById('appSidebar')
            const overlay=document.getElementById('sidebarOverlay')

            sidebar.classList.toggle('open')

            overlay.style.display=
            sidebar.classList.contains('open')
            ? 'block'
            : 'none'
        }

        function toggleFullscreen(){
            const icon=document.getElementById('fsIcon')

            if(!document.fullscreenElement){
                document.documentElement.requestFullscreen()
                icon.className='fas fa-compress'
            }
            else{
                document.exitFullscreen()
                icon.className='fas fa-expand'
            }
        }
    </script>

    @stack('scripts')

</body>

</html>