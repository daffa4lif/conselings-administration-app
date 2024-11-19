<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-green-100">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Tahun
                </th>
                <th scope="col" class="px-6 py-3">
                    Kelas
                </th>
                <th scope="col" class="px-6 py-3">
                    Jurusan
                </th>
                <th scope="col" class="px-6 py-3">
                    Riwayat
                </th>
                <th scope="col" class="px-6 py-3">
                    
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($studentClass as $key => $item)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $item->year }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $item->classroom->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->classroom->major }}
                    </td>
                    <td class="px-6 py-4">
                        <p>Absen : {{ $item->absentTotal }}</p>
                        <p>Kasus : 0</p>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('student.delete-classroom', ['id_student' => $id, 'id_class' => $item->classroom->id, 'year' => $item->year]) }}" class="font-medium text-red-600 hover:underline">Delete</a>
                    </td>
                </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center">tidak ada data kelas</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>