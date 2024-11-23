@extends('layouts.app')

@section('body')
<header>
    <x-main-header title="Detail Data User" />
    <x-breadcrumb :datas="[route('master.user.index') => 'List User']" last="Detail Data User" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg">

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="nis" title="Email" />
            <x-basic-input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required />
        </div>
        <div class="mb-5">
            <x-basic-label for="name" title="Name" />
            <x-basic-input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required />
        </div>
        <div class="mb-5">
            <x-basic-label for="password" title="New Password" />
            <x-basic-input type="password" id="password" name="password" value="{{ old('password') }}" />
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Buat</button>
        </div>
    </form>
</section>

<section class="mt-10 w-full p-4 border border-gray-100 shadow rounded-lg">
    <h2 class="text-xl font-medium mb-2">Hapus Kunjungan</h2>

    <div class="flex justify-center items-center">
        <a href="{{ route('master.user.delete', $user->id) }}" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Hapus</a>
    </div>
</section>
@endsection