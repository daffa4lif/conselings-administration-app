@extends('layouts.app')

@section('body')
<header class="mb-5">
    <x-main-header title="List Siswa" />
    <div class="flex justify-end">
        <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
            Tambah
        </button>

        <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Tambah Data Siswa
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="default-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, ratione.</p>
                        <div class="grid grid-cols-2 gap-5">
                            <a href="{{ route('student.create') }}" class="w-full border border-gray-100 hover:border-gray-300 shadow h-36 sm:h-64 rounded-lg flex justify-center items-center">
                                <div class="text-gray-500 text-center">
                                    <i class="fa-regular fa-square-plus text-xl sm:text-[3rem]"></i>
                                    <p class="mt-2 font-bold">Create</p>
                                </div>
                            </a>
                            <a href="{{ route('student.upload') }}" class="w-full border border-gray-100 hover:border-gray-300 shadow h-36 sm:h-64 rounded-lg flex justify-center items-center">
                                <div class="text-gray-500 text-center">
                                    <i class="fa-solid fa-upload text-xl sm:text-[3rem]"></i>
                                    <p class="mt-2 font-bold">Upload</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('includes.alert')

</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg">
    @livewire('student.list-students')
</section>
@endsection