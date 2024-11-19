@extends('layouts.app')

@section('body')
<header>
    <x-main-header title="Detail Siswa" />
    <x-breadcrumb :datas="[route('student.index') => 'Siswa']" last="Detail Siswa" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-xl font-medium mb-2">Data Siswa</h2>

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="nis" title="NIS" />
            <x-basic-input type="text" id="nis" name="nis" value="{{ old('nis', $student->nis) }}" required/>
        </div>
        <div class="mb-5">
            <x-basic-label for="name" title="Name" />
            <x-basic-input type="text" id="name" name="name" value="{{ old('name', $student->name) }}" required />
        </div>
        <div class="mb-5">
            <x-basic-label for="gender" title="Kelamin" />
            <select name="gender" id="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option @selected(old('kelamin', $student->gender) == 'PRIA')>PRIA</option>
                <option @selected(old('kelamin', $student->gender) == 'WANITA')>WANITA</option>
            </select>
        </div>
        <div class="mb-5">
            <x-basic-label for="address" title="Alamat" />
            <textarea name="address" id="address" cols="30" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ $student->address }}</textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Buat</button>
        </div>
    </form>
</section>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-medium mb-2">Kelas</h2>
        <button type="button" data-modal-target="classroom-modal" data-modal-toggle="classroom-modal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">tambah</button>
    </div>

    <!-- Main modal -->
    <div id="classroom-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Tambah Siswa Kedalam Kelas
                    </h3>
                    <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="classroom-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" action="{{ route('student.create-new-classroom', $student->nis) }}" method="POST">
                        @csrf
                        <div>
                            <label for="classroom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                            <select name="classroomId" id="classroom" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach ($classrooms as $item)
                                    <option value="{{ $item->id }}">{{ $item->major }} - {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun Ajaran</label>
                            <input type="number" name="year" id="year" placeholder="contoh: 2024" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                        </div>
                        
                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div> 

    @livewire('student.list-classroom', ['lazy' => true, 'id' => $student->id])
</section>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-xl font-medium mb-2">Riwayat Ketidakhadiran</h2>
    @livewire('student.list-absent', ['lazy' => true, 'id' => $student->id])

</section>
@endsection