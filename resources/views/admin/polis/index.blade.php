<x-layouts.app title="Data Poli">
 <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-slate-800">
            Data Poli
        </h2>

        <a href="{{ route('polis.create') }}" class="btn bg-[#2d4499] hover:bg-[#1e2d6b] 
                  text-white border-none rounded-lg px-5">
            <i class="fas fa-plus"></i>
            Tambah Poli
        </a>
    </div>

    {{-- Alert (Success & Error) --}}
    @if(session('success'))
    <div role="alert" class="alert alert-success mb-4 rounded-xl shadow-sm">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div role="alert" class="alert alert-error mb-4 rounded-xl shadow-sm">
        <i class="fas fa-circle-xmark"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    {{-- Card --}}
    <div class="card bg-base-100 shadow-md rounded-2xl border">
        <div class="card-body p-0">

            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">

                    {{-- Head --}}
                    <thead class="bg-slate-100 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left">Nama Poli</th>
                            <th scope="col" class="px-6 py-4 text-left">Keterangan</th>
                            <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    {{-- Body --}}
                    <tbody>
                        @forelse($polis as $poli)
                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $poli->nama_poli }}
                            </td>

                            <td class="px-6 py-4 text-slate-500">
                                {{ $poli->keterangan ?? '-' }} {{-- Tampilkan '-' jika keterangan kosong --}}
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('polis.edit', $poli->id) }}" 
                                       class="btn btn-sm bg-amber-500 hover:bg-amber-600 text-white border-none rounded-lg px-4"
                                       title="Edit {{ $poli->nama_poli }}">
                                        <i class="fas fa-pen-to-square"></i>
                                        Edit
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('polis.destroy', $poli->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus poli ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm bg-red-500 hover:bg-red-600 text-white border-none rounded-lg px-4"
                                                title="Hapus {{ $poli->nama_poli }}">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-14 text-slate-400">
                                <i class="fas fa-inbox text-4xl mb-3 block opacity-50"></i>
                                <span class="text-lg font-medium">Belum ada data poli</span>
                                <p class="text-sm mt-1">Silakan tambah poli pertama menggunakan tombol di atas.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</x-layouts.app>