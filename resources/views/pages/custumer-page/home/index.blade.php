@extends('layouts.dokter.main')

@section('content')
    <div class="card border-0 w-100 h-100" style="background-image: url('assets/img/bg.jpg'); background-size: cover; background-position: center;">
        <div class="card-header border-bottom mb-4 text-center bg-white py-3">
            <h2 class="text-secondary m-0">
                Selamat Datang, {{ Auth::user()->name ?? '' }}
            </h2>
        </div>
        <div class="card-body position-relative d-flex align-items-center justify-content-center">
            <div class="row justify-content-center text-center">
                <h4 class="p-4 text-white text-uppercase" style="letter-spacing: 7px; max-width: 800px;">Sistem Pendukung Keputusan Diagnosa Dini Penyakit Jantung Menggunakan Metode Dempster Shafer</h4>
            </div>
        </div>
        <div class="card-footer text-center bg-transparent">
            <a href="{{ route('diagnosa.create') }}" class="btn btn-md btn-primary" style="padding: 10px 20px; font-size: 1.1em;">Mulai Diagnosa</a>
        </div>
    </div>
@endsection