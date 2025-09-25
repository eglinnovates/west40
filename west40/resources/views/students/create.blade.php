@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Add Student</h1>
    <div class="w-full sm:w-1/2">
        <form method="POST" action="{{ route('students.store') }}">
            @include('students.partials._form')
        </form>
    </div>
@endsection
