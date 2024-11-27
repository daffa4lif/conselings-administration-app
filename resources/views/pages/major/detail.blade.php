@extends('layouts.app')

@section('body')
<header>
    <x-main-header title="Detail Penjurusan Kelas" />
    <x-breadcrumb :datas="[route('major.index') => 'List Penjurusan Kelas']" last="Detail Penjurusan Kelas" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-xl font-medium mb-2">Data Penjurusan</h2>

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="name" title="Name" />
            <x-basic-input type="text" id="name" name="name" value="{{ old('name', $major->name) }}" required />
        </div>
        <div class="flex justify-end">
            <button class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">
                Ubah
            </button>
        </div>
    </form>
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
                window.location = "{{ route('major.delete', $major->id) }}"
            }
        });
    })
</script>
@endpush