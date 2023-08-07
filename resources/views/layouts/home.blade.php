@extends('layouts.dashboard')
@section('title','home')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-0 text-gray-800 text-uppercase" >WELCOME {{request()->session()->get('loggedInUser')['name']}}</h1>
    </div>
@endsection

@section('script')

    
@endsection
