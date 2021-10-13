@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div id="content" class="content">
        {{ Breadcrumbs::render('dashboard') }}
        <center style="margin: 50px">
            {{-- <img style="width:80%" src="{{ asset('vendor/assets/img/logo/logo.png') }}" alt=""> --}}
            <h1>Halaman Dashboard</h1>
        </center>
    </div>
@endsection
