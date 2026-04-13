<x-layouts.guest title="Login">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <!-- Background dengan warna biru tua -->
    <div class="min-h-screen flex items-center justify-center p-4">
        <!-- Kartu putih di tengah -->
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-8">
            <!-- Logo & Title -->
            <div class="text-center mb-8">
               
                <img src="{{ asset('storage/images/logo-bengkot.png') }}"
                    class="w-[60px] h-[60px] rounded-[16px] object-cover mx-auto mb-[14px] block">
                <h1 class="text-2xl font-bold text-blue-900 mb-2">
                    Poliklinik
                </h1>
            </div>

            <!-- Error Alert -->
            @if ($errors->any())
            <div class="alert alert-error mb-5 rounded-xl text-[0.83rem]">
                <i class="fas fa-circle-xmark"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" 
                               id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Masukkan email..." 
                               required>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" 
                               id="password_login" 
                               type="password" 
                               name="password" 
                               placeholder="Masukkan password..." 
                               required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-eye text-gray-400 cursor-pointer" id="toggle_login"
                               onclick="togglePassword('password_login', 'toggle_login')"></i>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                        Login
                    </button>
                </div>
            </form>

            <!-- Register -->
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-bold">
                        Register
                    </a>
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon  = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } 
            else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
    @endpush
</x-layouts.guest>