@extends('layouts.admin.main')

@section('content')
  <div class="row">
      <div class="col-lg-12 mb-1 order-0">
        <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title text-primary">Selamat Datang {{ auth()->user()->name ?? '-' }} ({{ auth()->user()->level ?? '-' }})</h5>
                <p class="mb-0">
                  Profesional, Berintegritas, dan fokus pada keakuratan dalam membantu dokter mendiagnosa penyakit jantung.
                </p>
              </div>
        </div>
      </div>
  </div>
  <div class="row">
    <div class="col-md">
      <div class="card text-white bg-primary">
        <div class="card-body">
          <h4 class="text-white">Total Penyakit</h4>
          <hr>
          <h1 class="text-white">{{ $penyakit->count() ?? '-' }}</h1>
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card text-white bg-secondary">
        <div class="card-body">
          <h4 class="text-white">Total Gejala</h4>
          <hr>
          <h1 class="text-white">{{ $gejala->count() ?? '-' }}</h1>
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card text-white bg-dark">
        <div class="card-body">
          <h4 class="text-white">Total Pengguna</h4>
          <hr>
          <h1 class="text-white">{{ $pengguna->count() ?? '-' }}</h1>
        </div>
      </div>
    </div>
  </div>

    <div class="nav-align-top mt-4">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-left-align-home">Penyakit</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-left-align-profile">Gejala</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-left-align-messages">Pengguna</button>
        </li>
      </ul>
      <div class="tab-content border">
        <div class="tab-pane fade show active" id="navs-left-align-home">
         <div class="table-responsive">
          <table class="table table-sm text-nowrap">
            <thead class="table-secondary">
              <tr>
                <th>Kode Penyakit</th>
                <th>Nama Penyakit</th>
                <th>Deskripsi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($penyakit->take(5) as $a)                  
                <tr>
                  <td>{{ $a->code ?? '-' }}</td>
                  <td>{{ $a->name ?? '-' }}</td>
                  <td class="text-wrap">{{ $a->description ?? '-' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="table-footer">
            <a href="{{ route('penyakit.index') }}" class="btn btn-sm btn-outline-primary">Lihat Selengkapnya ..</a>
          </div>
         </div>
        </div>

        <div class="tab-pane fade" id="navs-left-align-profile">
          <div class="table-responsive">
            <table class="table" id="dataTable">
              <thead class="table-secondary">
                <tr>
                  <th>Kode Gejala</th>
                  <th>Nama Gejala</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($gejala->take(5) as $r)                    
                  <tr>
                    <td>{{ $r->code ?? '-' }}</td>
                    <td>{{ $r->name ?? '-' }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div class="table-footer">
              <a href="{{ route('gejala.index') }}" class="btn btn-sm btn-outline-primary">Lihat Selengkapnya ..</a>
            </div>
           </div>
        </div>
        <div class="tab-pane fade" id="navs-left-align-messages">
          <div class="table-responsive">
            <table class="table" id="dataTable">
              <thead class="table-secondary">
                <tr>
                  <th>Nama Pengguna</th>
                  <th>Username</th>
                  <th>level</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($pengguna as $usr)
                  <tr>
                    <td>{{ $usr->name ?? '-' }}</td>
                    <td>{{ $usr->username ?? '-' }}</td>
                    <td>{{ $usr->level ?? '-' }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div class="table-footer">
              <a href="{{ route('user.index') }}" class="btn btn-sm btn-outline-primary">Lihat Selengkapnya ..</a>
            </div>
           </div>
        </div>
      </div>
    </div>
@endsection
