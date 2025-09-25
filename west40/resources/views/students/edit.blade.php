@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Edit Student</h1>
    <form method="POST" action="{{ route('students.update', $student) }}">
        @method('PUT')
        <div class="w-full sm:w-1/2">
            @include('students.partials._form', ['student' => $student])
        </div>
    </form>
@endsection
