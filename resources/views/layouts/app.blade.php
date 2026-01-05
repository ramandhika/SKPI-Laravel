<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SKPI Management')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex flex-col md:flex-row">

        <div
            class="md:hidden bg-white border-b border-slate-200 p-4 flex justify-between items-center sticky top-0 z-30">
            <span class="font-bold text-lg text-indigo-600">SKPI App</span>
            <button @click="sidebarOpen = !sidebarOpen" class="text-slate-600 focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm md:hidden" x-cloak></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-white transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-auto md:flex md:w-72 md:flex-col shadow-xl">

            <div class="flex items-center justify-center h-20 border-b border-slate-700/50 bg-slate-900">
                <div class="text-center">
                    <h1 class="text-2xl font-bold tracking-tight text-white">SKPI<span class="text-indigo-400">
                            Sistem</span></h1>
                    <div class="text-xs text-slate-400 font-medium px-2 py-0.5 rounded bg-slate-800 mt-1 inline-block">
                        {{ ucfirst(auth()->user()->role) }} Workspace
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">

                @if (auth()->check())
                    @if (auth()->user()->role === 'admin')
                        @include('sidebar.admin')
                    @elseif(auth()->user()->role === 'mahasiswa')
                        @include('sidebar.mahasiswa')
                    @elseif(auth()->user()->role === 'dosen')
                        @include('sidebar.dosen')
                    @endif
                @endif

            </div>

            <div class="p-4 border-t border-slate-700/50 bg-slate-800/50">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold shadow-lg">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400 truncate" title="{{ auth()->user()->email }}">
                            {{ auth()->user()->email }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-red-400 bg-slate-900/50 hover:bg-red-500/10 hover:text-red-300 rounded-lg transition-all duration-200 border border-transparent hover:border-red-500/20">
                        <i class="fas fa-power-off"></i> <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50">

            <header
                class="bg-white border-b border-slate-200 sticky top-0 z-20 hidden md:flex items-center justify-between px-8 py-4 shadow-sm backdrop-blur-md bg-white/90">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">@yield('page-title')</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Manage your academic achievements efficiently.</p>
                </div>

                <div class="flex items-center gap-4">
                    <button
                        class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 flex items-center justify-center transition">
                        <i class="far fa-bell"></i>
                    </button>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-4 md:p-8">
                <div class="max-w-7xl mx-auto">

                    @if (session('success'))
                        <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms
                            class="mb-6 flex items-center p-4 text-sm text-green-800 border border-green-200 rounded-xl bg-green-50 shadow-sm relative"
                            role="alert">
                            <i class="fas fa-check-circle text-green-500 text-lg mr-3"></i>
                            <div>
                                <span class="font-medium">Success!</span> {{ session('success') }}
                            </div>
                            <button @click="show = false"
                                class="absolute right-4 top-4 text-green-600 hover:text-green-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms
                            class="mb-6 flex items-center p-4 text-sm text-red-800 border border-red-200 rounded-xl bg-red-50 shadow-sm relative"
                            role="alert">
                            <i class="fas fa-exclamation-circle text-red-500 text-lg mr-3"></i>
                            <div>
                                <span class="font-medium">Error!</span> {{ session('error') }}
                            </div>
                            <button @click="show = false"
                                class="absolute right-4 top-4 text-red-600 hover:text-red-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <span class="font-bold">Perhatikan hal berikut:</span>
                            </div>
                            <ul class="list-disc list-inside text-sm space-y-1 ml-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')

                </div>

                <footer class="mt-10 text-center text-xs text-slate-400 pb-4">
                    &copy; {{ date('Y') }} SKPI System. All rights reserved.
                </footer>
            </div>
        </main>
    </div>

    @stack('scripts')
</body>

</html>
