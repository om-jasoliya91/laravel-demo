@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <h2>Welcome, Admin {{ session('user_name') }}</h2>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>

@endsection
