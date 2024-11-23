@extends('layouts.app')

@section('body')
<header class="mb-5">
    <x-main-header title="List Kasus Siswa" />
    <div class="flex justify-end">
        <a href="{{ route('case.create') }}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" >
            Tambah
        </a>

    </div>

    @include('includes.alert')

</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg">
    @livewire('student-case.list-case')
</section>
@endsection