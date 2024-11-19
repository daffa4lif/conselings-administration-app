<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-2">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            <div class="w-full">
                <x-basic-label title="Tahun" />
                <select wire:model.live.debounce.400ms="filterYear" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="All">Semua</option>
                    @foreach ($years as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full">
                <x-basic-label title="Tipe" />
                <select wire:model.live.debounce.400ms="filterType" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="All">Semua</option>
                    <option>IZIN</option>
                    <option>SAKIT</option>
                    <option>ALPHA</option>
                </select>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-green-100">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Absent
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tipe
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Keterangan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($absents as $key => $item)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $item->violation_date }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $item->type }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->description }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="#" class="font-medium text-red-600 hover:underline">Delete</a>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center">tidak ada data absent</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>