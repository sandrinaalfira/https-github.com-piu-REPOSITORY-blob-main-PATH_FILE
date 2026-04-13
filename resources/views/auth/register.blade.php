<x-layouts.guest title="Register">
    {{-- Script Tailwind Anda dibiarkan karena sudah ada --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{-- Background Biru Tua dengan Flexbox untuk memusatkan konten --}}
    <div class="min-h-screen flex items-center justify-center p-4">
        
        {{-- Kartu Putih di Tengah --}}
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-8">
            
            {{-- Header: Hanya Judul --}}

            <div class="text-center mb-8">
                <img src="{{ asset('storage/images/logo-bengkot.png') }}"
                    class="w-[60px] h-[60px] rounded-[16px] object-cover mx-auto mb-[14px] block">
                <h1 class="text-2xl font-bold text-blue-900">
                    Poliklinik
                </h1>
            </div>

            {{-- Error Alert (disesuaikan stylenya) --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4 text-sm" role="alert">
                    <span class="block sm:inline">{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                {{-- Nama Lengkap --}}
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama">
                        Nama Lengkap
                    </label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                           id="nama"
                           type="text"
                           name="nama"
                           value="{{ old('nama') }}"
                           placeholder="Masukkan nama lengkap..."
                           required>
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                           id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="Masukkan email..."
                           required>
                </div>

                {{-- Alamat --}}
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="alamat">
                        Alamat
                    </label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                           id="alamat"
                           type="text"
                           name="alamat"
                           value="{{ old('alamat') }}"
                           placeholder="Masukkan alamat..."
                           required>
                </div>

                {{-- No. HP & No. KTP (dalam grid) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="no_hp">
                            No. HP
                        </label>
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                               id="no_hp"
                               type="number"
                               name="no_hp"
                               value="{{ old('no_hp') }}"
                               placeholder="No. HP..."
                               required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="no_ktp">
                            No. KTP
                        </label>
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                               id="no_ktp"
                               type="number"
                               name="no_ktp"
                               value="{{ old('no_ktp') }}"
                               placeholder="No. KTP..."
                               required>
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                           id="password"
                           type="password"
                           name="password"
                           placeholder="Password..."
                           required>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                        Konfirmasi Password
                    </label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                           id="password_confirmation"
                           type="password"
                           name="password_confirmation"
                           placeholder="Ulangi password..."
                           required>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-300">
                    Register
                </button>
            </form>

            {{-- Link Login --}}
            <p class="text-center mt-6 text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-bold">
                    Login
                </a>
            </p>

        </div>
    </div>


</x-layouts.guest>