@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Add User</h1>
    <form method="POST" action="{{ route('users.store') }}" class="w-full sm:w-1/2 mx-auto">
        @include('users.partials._form')
    </form>
@endsection
