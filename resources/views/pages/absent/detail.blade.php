@extends('layouts.app')

@section('body')

<header>
    <x-main-header title="Detail Absent" />
    <x-breadcrumb :datas="[route('absent.index') => 'List Absent']" last="Detail Absent" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-xl font-medium mb-2">Detail Absent</h2>

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="nis" title="NIS" />
            <x-basic-input type="text" id="nis" name="nis" value="{{ $absent->student->nis }}" disabled/>
        </div>
        <div class="mb-5">
            <x-basic-label for="name" title="Name" />
            <x-basic-input type="text" id="name" name="name" value="{{ $absent->student->name }}" disabled />
        </div>
        
        <div class="mt-20 mb-5">
            <x-basic-label for="type" title="Jenis Absent" />
            <select name="type" id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option @selected(old('type', $absent->type) == "IZIN")>IZIN</option>
                <option @selected(old('type', $absent->type) == "SAKIT")>SAKIT</option>
                <option @selected(old('type', $absent->type) == "ALPHA")>ALPHA</option>
            </select>
        </div>
        <div class="mb-5">
            <x-basic-label for="tanggal" title="Tanggal Kejadian" />
            <x-basic-input type="date" id="tanggal" name="date" value="{{ old('date', $absent->violation_date) }}" required/>
        </div>
        <div class="mb-5">
            <x-basic-label for="keterangan" title="Keterangan" />
            <textarea name="description" id="keterangan" cols="30" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>{{ old('description', $absent->description) }}</textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
        </div>
    </form>
</section>

<section class="mt-10 w-full p-4 border border-gray-100 shadow rounded-lg">
    <h2 class="text-xl font-medium mb-2">Hapus Absent</h2>

    <div class="flex justify-center items-center">
        <a href="{{ route('absent.delete', $absent->id) }}" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Hapus</a>
    </div>
</section>
@endsection