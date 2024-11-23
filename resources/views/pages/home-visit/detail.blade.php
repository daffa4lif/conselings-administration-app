@extends('layouts.app')

@section('body')

<header>
    <x-main-header title="Detail Kunjungan" />
    <x-breadcrumb :datas="[route('home-visit.index') => 'List Kunjungan']" last="Detail Kunjungan" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-xl font-medium mb-2">Detail Kunjungan</h2>

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="nis" title="NIS" />
            <x-basic-input type="text" id="nis" name="nis" value="{{ $visits->student->nis }}" disabled/>
        </div>
        <div class="mb-5">
            <x-basic-label for="name" title="Name" />
            <x-basic-input type="text" id="name" name="name" value="{{ $visits->student->name }}" disabled />
        </div>
        <div class="mb-5">
            <x-basic-label for="alamat" title="Alamat" />
            <textarea name="address" id="address" cols="30" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-100 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 cursor-not-allowed" disabled>{{ $visits->student->address }}</textarea>
        </div>
        
        <div class="mt-20 mb-5">
            <x-basic-label for="wali" title="nama wali" />
            <x-basic-input type="text" id="name" name="parent" value="{{ old('parent', $visits->parent_name) }}" required />
        </div>
        <div class="mb-5">
            <x-basic-label for="solusi" title="Kasus" />
            <textarea name="case" id="solusi" cols="30" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('case', $visits->case) }}</textarea>
        </div>
        <div class="mb-5">
            <x-basic-label for="solusi" title="Status" />
            <select name="status" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option @selected($visits->status == "PROCESS")>PROCESS</option>
                <option @selected($visits->status == "FINISH")>FINISH</option>
            </select>
        </div>
        <div class="mb-5">
            <x-basic-label for="solusi" title="Solusi" />
            <textarea name="solution" id="solusi" cols="30" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('solution', $visits->solution) }}</textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
        </div>
    </form>
</section>

<section class="mt-10 w-full p-4 border border-gray-100 shadow rounded-lg">
    <h2 class="text-xl font-medium mb-2">Hapus Kunjungan</h2>

    <div class="flex justify-center items-center">
        <a href="{{ route('home-visit.delete', $visits->id) }}" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Hapus</a>
    </div>
</section>
@endsection