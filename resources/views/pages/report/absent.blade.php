@extends('layouts.app')

@section('body')
<header class="mb-5">
    <x-main-header title="Rekap Absent" />

    @include('includes.alert')
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg">
    {{-- @livewire('student.list-students') --}}
</section>
@endsection