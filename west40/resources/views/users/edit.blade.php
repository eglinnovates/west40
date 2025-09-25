@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Edit User</h1>
    <form method="POST" action="{{ route('users.update', $user) }}" class="w-full sm:w-1/2 mx-auto">
        @method('PUT')
        @include('users.partials._form', ['user' => $user])
    </form>
@endsection
