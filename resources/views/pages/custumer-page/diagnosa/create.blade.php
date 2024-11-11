@extends('layouts.dokter.main')

@section('content')

<div class="card">
    <div class="card-header border-bottom mb-4" style="background-image: url('/assets/img/bg.jpg'); background-size: cover; background-position: center;">
        <h4 class="text-dark mb-1">Diagnosa Dini Penyakit Jantung</h4>
        <h6 class="text-white mt-0">Ketahui penyakit anda lebih dini, untuk membantu proses pengobatan</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('diagnosa.store') }}" method="POST">
            @csrf
            <div class="row mb-4">
                <div class="col-md-4 me-1 border p-4">
                    <h5>Detail Pasien</h5>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Masukkan nama lengkap anda" name="name" aria-describedby="floatingInputHelp" value="{{ old('name') }}" required/>
                        <label for="floatingInput">Nama</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" placeholder="Masukkan usia anda" name="usia" aria-describedby="floatingInputHelp" value="{{ old('usia') }}" required/>
                        <label for="floatingInput">Usia</label>
                    </div>
                    <div class="mb-3">
                        <label for="jenis-kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis-kelamin" name="jenis_kelamin" aria-label="Default select example">
                          <option selected>Pilih</option>
                          <option value="Pria">Pria</option>
                          <option value="Wanita">Wanita</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" placeholder="Ketik alamat pasien disini ..." cols="30" rows="4"></textarea>
                    </div>
                </div>
                <div class="col-md-7 border p-4">
                    <div class="mb-3">
                        <h5 class="mb-0">Gejala Pasien</h5>
                        <small class="fst-italic text-secondary">
                            * Pilih gejala yang dialami pasien dengan mencentang kotak dibawah ini
                        </small>
                    </div>
                    <div class="row mb-3">
                        @foreach ($data as $index => $item)
                            <div class="col-6">
                                <div class="form-check mb-2">
                                  <input class="form-check-input" type="checkbox" value="{{ $item->id }}" name="symtom_id[]" id="gejala_{{ $index }}" />
                                  <label class="form-check-label" for="gejala_{{ $index }}">
                                    {{ $item->name ?? '-' }}
                                  </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-12 d-flex justify-content-center">
                <a href="{{ route('homepage') }}" class="btn btn-md btn-danger me-2"><i class="bx bx-left-arrow"></i> Kembali</a>
                <button type="submit" class="btn btn-md btn-primary"><i class='bx bx-sync'></i> Diagnosa</button>
            </div>
        </form>
    </div>
</div>
    
@endsection