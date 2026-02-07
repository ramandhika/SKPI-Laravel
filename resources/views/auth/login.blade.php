<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SKPI System</title>

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
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-[#fbc21d]/30 blur-3xl"></div>
        <div class="absolute top-[20%] right-[10%] w-[30%] h-[30%] rounded-full bg-purple-200/30 blur-3xl"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[35%] h-[35%] rounded-full bg-blue-200/30 blur-3xl"></div>
    </div>

    <div
        class="w-full max-w-[420px] bg-white rounded-3xl shadow-xl border border-slate-100 relative z-10 overflow-hidden">

        <div class="pt-10 pb-6 text-center px-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-[#f0f9fc] text-[#0F7287] mb-4 shadow-sm">
                <i class="fas fa-university text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Welcome Back</h1>
            <p class="text-slate-500 text-sm mt-2">Masuk ke SKPI Management System</p>
        </div>

        <div class="px-8 pb-10">
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                    <div class="text-sm text-red-600">
                        <span class="font-semibold block mb-1">Login Gagal</span>
                        <ul class="list-disc list-inside text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <p class="text-sm text-green-700">{{ session('status') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-slate-700 ml-1">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i
                                class="fas fa-envelope text-slate-400 group-focus-within:text-[#0C6C85] transition-colors"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] text-slate-800 placeholder:text-slate-400 transition-all outline-none"
                            placeholder="nama@tsu.ac.id" required autofocus>
                    </div>
                </div>

                <div class="space-y-1.5" x-data="{ show: false }">
                    <div class="flex items-center justify-between ml-1">
                        <label class="text-sm font-semibold text-slate-700">Password</label>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i
                                class="fas fa-lock text-slate-400 group-focus-within:text-[#0C6C85] transition-colors"></i>
                        </div>
                        <input :type="show ? 'text' : 'password'" name="password"
                            class="w-full pl-11 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] text-slate-800 placeholder:text-slate-400 transition-all outline-none"
                            placeholder="Masukkan password" required>

                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer transition-colors">
                            <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 rounded text-[#0F7287] border-slate-300 focus:ring-[#0C6C85] focus:ring-offset-0 cursor-pointer">
                        <span class="ml-2 text-sm text-slate-600 select-none">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm font-medium text-[#0F7287] hover:text-[#0C6C85] hover:underline">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <button type="submit"
                    class="w-full bg-[#0F7287] hover:bg-[#064D62] text-white font-semibold py-3.5 rounded-xl shadow-lg shadow-[#0C6C85]/30 hover:shadow-[#0C6C85]/40 transform active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2">
                    <span>Masuk Aplikasi</span>
                    <i class="fas fa-arrow-right text-sm"></i>
                </button>
            </form>
        </div>

        <div class="bg-slate-50 border-t border-slate-100 p-4 text-center">
            <p class="text-xs text-slate-500">
                &copy; {{ date('Y') }} Sistem Informasi SKPI.
            </p>
        </div>
    </div>

</body>

</html>
