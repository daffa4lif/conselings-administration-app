@extends('layouts.app')

@section('body')
    <x-main-header title="Dashboard" />
    <section>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                @livewire('dashboard.count-student', ['lazy' => true])
            </div>
            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                @livewire('dashboard.count-case', ['lazy' => true])
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                @livewire('dashboard.count-visits', ['lazy' => true])
            </div>
            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                @livewire('dashboard.count-conseling', ['lazy' => true])
            </div>
            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                @livewire('dashboard.count-conseling-group', ['lazy' => true])
            </div>
        </div>
    </section>
@endsection