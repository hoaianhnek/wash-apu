<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Washing APU - @yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/sonxi-favicon.png') }}"/>
    <link rel="apple-touch-icon" href="{{ asset('images/sonxi-favicon.png') }}"/>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Swal Alert -->
    <script src="{{ asset('/js/sweetalert2@11.js') }}"></script>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#0056b3",
                        "background": "#f8fafc",
                        "surface": "#ffffff",
                        "text-main": "#1e293b",
                        "text-muted": "#64748b"
                    },
                    "fontFamily": {
                        "headline": ["Plus Jakarta Sans"],
                        "body": ["Inter"]
                    }
                }
            }
        }
    </script>
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .table-header { background-color: #0056b3; color: white; }
        #loading {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, 0.45);
        }
        #loading[hidden] {
            display: none !important;
        }
        #loading .loader {
            width: 48px;
            height: 48px;
            border: 5px solid rgba(255, 255, 255, 0.55);
            border-top-color: #0056b3;
            border-radius: 50%;
            text-indent: -9999px;
            overflow: hidden;
            animation: loading-spin 0.8s linear infinite;
        }
        @keyframes loading-spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
    
    @yield('css')
</head>
<body class="flex min-h-screen overflow-x-hidden">
    
    @if(!Request::routeIs('login.index'))
        @include('layouts.sidebar')
        <!-- Main Content -->
        <main class="ml-16 xl:ml-64 flex-1 flex flex-col overflow-x-hidden">
            <!-- Header -->
            @include('layouts.header')
            @include('components.production.finished-quantity-modal')

            <div class="flex-1 overflow-x-hidden">
                @yield('content')
            </div>
        </main>
    @else
    <section class="main w-[100%]" id="main">
        @yield('content')
    </section>
    @endif

    {{-- LOADING --}}
    <div id="loading" hidden>
        <div class="loader is_data" role="status" aria-label="Loading">Loading...</div>
    </div>
    
    {{-- JS script --}}
    <script>
        const msgComon = @json(config('messages')).vi;
    </script>
    <!-- Scripts: dùng đường dẫn tuyệt đối từ web root để khớp host:port với trang (tránh APP_URL thiếu :8000) -->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/app.js') }}"></script>
    @yield('js')
    <script src="/js/finished-qty-modal.js"></script>
    @if(session('error'))
        <div
            id="page-loading-overlay"
            class="fixed inset-0 bg-[#d7d7d7] z-[9999]"
        ></div>

        <script>
            document.documentElement.style.overflow = 'hidden';

            document.addEventListener('DOMContentLoaded', async () => {

                showMessageError(@json(session('error')), function() {
                    const overlay = document.getElementById('page-loading-overlay');

                    if (overlay) {
                        overlay.remove();
                    }

                    document.documentElement.style.overflow = '';
                });
            });
        </script>

    @endif
</body>
</html>
