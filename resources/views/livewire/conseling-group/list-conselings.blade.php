<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-2">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            <div class="w-full">
                <x-basic-label title="Kategori" />
                <select wire:model.live.debounce.400ms="filterCategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="All">Semua</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full">
                <x-basic-label title="Status" />
                <select wire:model.live.debounce.400ms="filterStatus" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="All">Semua</option>
                    <option>PROCESS</option>
                    <option>FINISH</option>
                    <option>DIALIHKAN</option>
                </select>
            </div>
            <div class="w-full">
                <x-basic-label title="Berasarkan" />
                <select wire:model.live.debounce.400ms="filterOrder" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="old">data lama</option>
                    <option value="new">data baru</option>
                </select>
            </div>
        </div>
        <div class="w-full">
            <x-basic-label title="Cari Nama" />
            <input type="search" wire:model.live.debounce.400ms="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Search...">
        </div>
    </div>
    <div wire:loading class="w-full gap-3 p-4 border border-gray-100 shadow rounded-md mb-2">
        <div class="flex justify-center">
            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin fill-green-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
        </div>
    </div>
    <div wire:loading.remove class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-green-100">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/3">
                        Siswa
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Kategori
                    </th>
                    <th scope="col" class="px-6 py-3 w-2/3">
                        Kasus
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status Proces
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Ubah
                    </th>
                    <th scope="col" class="px-6 py-3">
                        
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($conselings as $key => $item)
                <tr class="bg-white border-b hover:bg-gray-100">
                    <td class="px-6 py-4">
                        {{ ($conselings->currentPage() - 1) * $conselings->perPage() + $key + 1 }}
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        @foreach ($item->students as $student)
                            <p>{{ $student->name }}</p>
                            <p class="text-xs text-gray-500">{{ $student->nis }}</p>
                        @endforeach
                    </th>
                    <td class="px-6 py-4">
                        {{ $item->category }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->case }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->status }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->updated_at }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('conseling-group.detail', $item->id) }}" class="font-medium text-blue-600 hover:underline">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-900 font-medium text-md">Tidak Ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex items-center gap-3 mt-4">
        <p class="text-sm">Per Page</p>
        <select name="filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-1" wire:model.change="perPage">
            <option>10</option>
            <option>50</option>
            <option>100</option>
        </select>
    </div>

    <div class="mt-4 sm:flex sm:justify-end">
        {{ $conselings->links() }}
    </div>
</div>