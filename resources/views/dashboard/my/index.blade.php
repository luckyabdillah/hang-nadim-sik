@extends('dashboard.layouts.main')

@section('content')
    <div class="alert alert-secondary mb-3">
        Selamat Datang kembali, {{ auth()->user()->name }}.
    </div>
@endsection