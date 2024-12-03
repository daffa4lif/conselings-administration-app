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
    <x-main-header title="Buat Konseling" />
    <x-breadcrumb :datas="[route('conseling.index') => 'List Konseling']" last="Buat Konseling" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-xl font-medium mb-2">Buat Konseling</h2>

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="nis" title="Siswa" />
            <select name="studentId" id="student">
                <option></option>
            </select>
        </div>

        <div class="mb-5">
            <x-basic-label for="nis" title="Kategori" />
            <select name="category" id="student" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option>{{ \App\Models\Conseling\Conseling::CATEGORY_AKADEMIK }}</option>
                <option>{{ \App\Models\Conseling\Conseling::CATEGORY_NON_AKADEMIK }}</option>
                <option>{{ \App\Models\Conseling\Conseling::CATEGORY_KEDISIPLINAN }}</option>
            </select>
        </div>

        <div class="mt-20 mb-5">
            <x-basic-label for="kasus" title="Kasus" />
            <textarea name="case" id="kasus" cols="30" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>{{ old('case') }}</textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
        </div>
    </form>
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