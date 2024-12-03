@extends('layouts.app')

@section('body')

<header>
    <x-main-header title="Detail Konseling" />
    <x-breadcrumb :datas="[route('conseling.index') => 'List Konseling']" last="Detail Konseling" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-xl font-medium mb-2">Detail Konseling</h2>

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="nis" title="NIS" />
            <x-basic-input type="text" id="nis" name="nis" value="{{ $conseling->student->nis }}" disabled/>
        </div>
        <div class="mb-5">
            <x-basic-label for="name" title="Name" />
            <x-basic-input type="text" id="name" name="name" value="{{ $conseling->student->name }}" disabled />
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
            </select>
        </div>
        <div class="mb-5">
            <x-basic-label for="kasus" title="Kasus" />
            <textarea name="case" id="kasus" cols="30" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>{{ old('case', $conseling->case) }}</textarea>
        </div>
        <div class="mb-5">
            <x-basic-label for="kasus" title="Solusi" />
            <textarea name="solution" id="kasus" cols="30" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>{{ old('solution', $conseling->solution) }}</textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
        </div>
    </form>
</section>

<section class="mt-10 w-full p-4 border border-gray-100 shadow rounded-lg">
    <h2 class="text-xl font-medium mb-2">Hapus Konseling</h2>

    <div class="flex justify-center items-center">
        <a href="{{ route('conseling.delete', $conseling->id) }}" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Hapus</a>
    </div>
</section>
@endsection