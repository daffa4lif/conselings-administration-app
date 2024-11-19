@extends('layouts.app')

@section('body')
<header>
    <x-main-header title="Detail Kelas" />
    <x-breadcrumb :datas="[route('classroom.index') => 'List Kelas']" last="Detail Kelas" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-xl font-medium mb-2">Data Kelas</h2>

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="major" title="Tipe Kelas" />
            <select name="major" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option @selected(old('major', $classroom->major) == 'IPA')>IPA</option>
                <option @selected(old('major', $classroom->major) == 'IPS')>IPS</option>
            </select>
        </div>
        <div class="mb-5">
            <x-basic-label for="name" title="Name" />
            <x-basic-input type="text" id="name" name="name" value="{{ old('name', $classroom->name) }}" required />
        </div>
        <div class="flex justify-end">
            <button class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">
                Ubah
            </button>
        </div>
    </form>
</section>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="font-medium text-xl">Data Siswa</h2>
    <p class="text-sm mb-4">Data siswa pada kelas</p>
    <div class="flex justify-end">
        <a href="#" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Tambah
        </a>
    </div>

    
</section>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-red-500 font-medium text-xl">Hapus Permanent</h2>
    <p class="text-sm mb-4">dihapus secara permanent</p>
    <div class="flex justify-center items-center">
        <button class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button" id="btn-delete">
            Hapus
        </button>
    </div>
</section>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    const btnDelete = document.getElementById('btn-delete')
    btnDelete.addEventListener("click", () => {
        Swal.fire({
            title: "Are you sure?",
            text: "Data Akan dihapus secara permanent",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
                window.location = "#"
            }
        });
    })
</script>
@endpush