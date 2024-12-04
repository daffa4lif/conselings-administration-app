@extends('layouts.app')

@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2.select2-container {
    width: 100% !important;
}

.select2.select2-container .select2-selection {
    border: 1px solid #ccc;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    height: 34px;
    margin-bottom: 15px;
    outline: none !important;
    transition: all 0.15s ease-in-out;
}

.select2.select2-container .select2-selection .select2-selection__rendered {
    color: #333;
    line-height: 32px;
    padding-right: 33px;
}

.select2.select2-container .select2-selection .select2-selection__arrow {
    background: #f8f8f8;
    border-left: 1px solid #ccc;
    -webkit-border-radius: 0 3px 3px 0;
    -moz-border-radius: 0 3px 3px 0;
    border-radius: 0 3px 3px 0;
    height: 32px;
    width: 33px;
}

.select2.select2-container.select2-container--open
    .select2-selection.select2-selection--single {
    background: #f8f8f8;
}

.select2.select2-container.select2-container--open
    .select2-selection.select2-selection--single
    .select2-selection__arrow {
    -webkit-border-radius: 0 3px 0 0;
    -moz-border-radius: 0 3px 0 0;
    border-radius: 0 3px 0 0;
}

.select2.select2-container.select2-container--open
    .select2-selection.select2-selection--multiple {
    border: 1px solid #34495e;
}

.select2.select2-container .select2-selection--multiple {
    height: auto;
    min-height: 34px;
}

.select2.select2-container
    .select2-selection--multiple
    .select2-search--inline
    .select2-search__field {
    margin-top: 0;
    height: 32px;
}

.select2.select2-container
    .select2-selection--multiple
    .select2-selection__rendered {
    display: block;
    padding: 0 4px;
    line-height: 29px;
}

.select2.select2-container
    .select2-selection--multiple
    .select2-selection__choice {
    background-color: #f8f8f8;
    border: 1px solid #ccc;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    margin: 4px 4px 0 0;
    padding: 0 6px 0 22px;
    height: 24px;
    line-height: 24px;
    font-size: 12px;
    position: relative;
}

.select2.select2-container
    .select2-selection--multiple
    .select2-selection__choice
    .select2-selection__choice__remove {
    position: absolute;
    top: 0;
    left: 0;
    height: 22px;
    width: 22px;
    margin: 0;
    text-align: center;
    color: #e74c3c;
    font-weight: bold;
    font-size: 16px;
}

.select2-container .select2-dropdown {
    background: transparent;
    border: none;
    margin-top: -5px;
}

.select2-container .select2-dropdown .select2-search {
    padding: 0;
}

.select2-container .select2-dropdown .select2-search input {
    outline: none !important;
    border: 1px solid #34495e !important;
    border-bottom: none !important;
    padding: 4px 6px !important;
}

.select2-container .select2-dropdown .select2-results {
    padding: 0;
}

.select2-container .select2-dropdown .select2-results ul {
    background: #fff;
    border: 1px solid #34495e;
}

.select2-container
    .select2-dropdown
    .select2-results
    ul
    .select2-results__option--highlighted[aria-selected] {
    background-color: #3498db;
}
</style>
@endpush

@section('body')

<header>
    <x-main-header title="Detail Konseling Grup" />
    <x-breadcrumb :datas="[route('conseling-group.index') => 'List Konseling Grup']" last="Detail Konseling Grup" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-xl font-medium mb-2">Detail Konseling Grup</h2>

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="nis" title="Siswa" />
            <select name="studentIds[]" id="student" multiple>
                <option></option>
                @foreach ($conseling->students as $item)
                    <option value="{{ $item->id }}" selected>{{ $item->nis }} | {{ $item->name }}</option>
                @endforeach
            </select>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-green-100">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                NIS
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Siswa
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($conseling->students as $key => $item)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $key + 1 }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $item->nis }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->name }}
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center">tidak ada data siswa</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
        
            </div>
        </div>
        <div class="mb-5">
            <x-basic-label for="tanggal" title="Tanggal Buat" />
            <x-basic-input type="text" value="{{ date('F d, Y H:i', strtotime($conseling->created_at)) }}" disabled/>
        </div>
        
        <div class="mt-20 mb-5">
            <x-basic-label for="nis" title="Kategori" />
            <select name="category" id="student" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option @selected(\App\Models\Conseling\Conseling::CATEGORY_AKADEMIK == $conseling->category)>{{ \App\Models\Conseling\Conseling::CATEGORY_AKADEMIK }}</option>
                <option @selected(\App\Models\Conseling\Conseling::CATEGORY_NON_AKADEMIK == $conseling->category)>{{ \App\Models\Conseling\Conseling::CATEGORY_NON_AKADEMIK }}</option>
                <option @selected(\App\Models\Conseling\Conseling::CATEGORY_KEDISIPLINAN == $conseling->category)>{{ \App\Models\Conseling\Conseling::CATEGORY_KEDISIPLINAN }}</option>
            </select>
        </div>
        <div class="mb-5">
            <x-basic-label for="status" title="Status" />
            <select name="status" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option @selected(old('status', $conseling->status) == "PROCESS")>PROCESS</option>
                <option @selected(old('status', $conseling->status) == "FINISH")>FINISH</option>
                <option @selected(old('status', $conseling->status) == "DIALIHKAN")>DIALIHKAN</option>
            </select>
        </div>
        <div class="mb-5">
            <x-basic-label for="kasus" title="Kasus" />
            <textarea name="case" id="kasus" cols="30" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>{{ old('case', $conseling->case) }}</textarea>
        </div>
        <div class="mb-5">
            <x-basic-label for="kasus" title="Solusi" />
            <textarea name="solution" id="kasus" cols="30" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('solution', $conseling->solution) }}</textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
        </div>
    </form>
</section>

<section class="mt-10 w-full p-4 border border-gray-100 shadow rounded-lg">
    <h2 class="text-xl font-medium mb-2">Hapus Konseling Grup</h2>

    <div class="flex justify-center items-center">
        <a href="{{ route('conseling-group.delete', $conseling->id) }}" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Hapus</a>
    </div>
</section>
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    $(document).ready(function() {
        $('#student').select2({
            placeholder: 'Cari Siswa...',
            ajax: {
                url: "{{ route('student.api.search') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: '{{ csrf_token() }}',
                        user: "{{ auth()->user()->id }}",
                        search: params.term
                    };
                },
                processResults: function (data, params){
                    return {
                        results: $.map(data, function(item){
                            if(item != null){
                                return {
                                    id: item.id,
                                    text: item.name
                                }
                            }
                        })

                    }
                }
            },
            minimumInputLength: 3
        });
    });
</script>
@endpush