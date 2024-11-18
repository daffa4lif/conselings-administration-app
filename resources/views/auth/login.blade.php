@extends('layouts.guest')

@section('body')
<main class="h-dvh flex justify-center items-center p-4">
    <section class="grid grid-cols-1 sm:grid-cols-2 p-4 border border-gray-50 shadow rounded-lg">
        <div class="max-w-xl mx-auto w-full p-2">
            <div class="">
                <h1 class="text-4xl text-center font-semibold">Bimbingan Konseling</h1>
                <p>
                <p class="text-center">MAN 4 Kebumen</p>
            </div>
            <div class="mt-5">
                <h2 class="text-center text-xl font-medium">Login</h1>
        
                    @include('includes.alert')
        
                    <form method="POST">
                        @csrf
                        <div class="mb-5">
                            <x-basic-label for="email" title="Email" />
                            <x-basic-input type="email" id="email" name="email" value="{{ old('email')}} " required />
                        </div>
                        <div class="mb-5">
                            <x-basic-label for="password" title="Password" />
                            <x-basic-input type="password" id="password" name="password" required />
                        </div>
                        <div class="flex items-start mb-5">
                            <div class="flex items-center h-5">
                                <input id="remember" name="remember-me" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300" />
                            </div>
                            <label for="remember" class="ms-2 text-sm font-medium text-gray-900 cursor-pointer">Remember me</label>
                        </div>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Login</button>
                    </form>
            </div>
        </div>
        <div class="max-w-lg hidden sm:block ">
        <div class="flex items-center justify-center mt-10">
            <img src="{{ asset('assets/images/logo.png') }}" alt="" style="max-width: 300px; height: auto;">
        </div>
        </div>
    </section>
</main>
@endsection