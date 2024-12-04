@extends('layouts.app')

@section('body')

<header>
    <x-main-header title="Detail Kasus" />
    <x-breadcrumb :datas="[route('case.index') => 'List Kasus']" last="Detail Kasus" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-xl font-medium mb-2">Detail Kasus</h2>

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="nis" title="NIS" />
            <x-basic-input type="text" id="nis" name="nis" value="{{ $case->student->nis }}" disabled/>
        </div>
        <div class="mb-5">
            <x-basic-label for="name" title="Name" />
            <x-basic-input type="text" id="name" name="name" value="{{ $case->student->name }}" disabled />
        </div>
        
        <div class="mt-20 mb-5">
            <x-basic-label for="solusi" title="Jenis Kasus" />
            <select name="type" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option @selected(old('type', $case->type) == "RINGAN")>RINGAN</option>
                <option @selected(old('type', $case->type) == "SEDANG")>SEDANG</option>
                <option @selected(old('type', $case->type) == "BERAT")>BERAT</option>
            </select>
        </div>
        <div class="mb-5">
            <x-basic-label for="wali" title="Point Kasus" />
            <x-basic-input type="number" id="name" name="point" value="{{ old('point', $case->point) }}" required />
        </div>
        <div class="mb-5">
            <x-basic-label for="solusi" title="Kasus" />
            <textarea name="case" id="solusi" cols="30" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('case', $case->case) }}</textarea>
        </div>
        <div class="mb-5">
            <x-basic-label for="solusi" title="Status" />
            <select name="status" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option @selected($case->status == "PROCESS")>PROCESS</option>
                <option @selected($case->status == "FINISH")>FINISH</option>
                <option @selected($case->status =="DIALIHKAN")>DIALIHKAN</option>
            </select>
        </div>
        <div class="mb-5">
            <x-basic-label for="solusi" title="Solusi" />
            <textarea name="solution" id="solusi" cols="30" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('solution', $case->solution) }}</textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
        </div>
    </form>
</section>

<section class="mt-10 w-full p-4 border border-gray-100 shadow rounded-lg">
    <h2 class="text-xl font-medium mb-2">Hapus Kunjungan</h2>

    <div class="flex justify-center items-center">
        <a href="{{ route('case.delete', $case->id) }}" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Hapus</a>
    </div>
</section>
@endsection