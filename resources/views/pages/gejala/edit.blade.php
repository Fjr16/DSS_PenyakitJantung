@extends('layouts.admin.main')

@section('content')
<div class="card">
    <div class="card-header mb-4 border-bottom">
        <h4 class="m-0 p-0">Edit Gejala <span class="text-primary">{{ $item->code ?? $lastCode }}</span></h4>
    </div>
    <div class="card-body">
        <form action="{{ route('gejala.update', encrypt($item->id)) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="kode-gejala" class="form-label">Kode Gejala</label>
                        <input type="text" class="form-control form-control-md" id="kode-gejala" placeholder="Kode Gejala" value="{{ old('code', $item->code ?? $lastCode) }}" required disabled/>
                    </div>
                    <div class="mb-3">
                        <label for="nama-gejala" class="form-label">Nama Gejala</label>
                        <input type="text" class="form-control form-control-md" id="nama-gejala" name="name" placeholder="Nama gejala" value="{{ old('name', $item->name ?? '') }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="bobot" class="form-label">Bobot</label>
                        <input type="number" step="0.01" min="0.01" class="form-control form-control-md" id="bobot" name="bobot" placeholder="Bobot Gejala" value="{{ old('bobot', $item->bobot ?? 0.01) }}" required />
                    </div>
                </div>
                <div class="col-md-12 mt-4 border-top">
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('gejala.index') }}" class="btn btn-md btn-danger me-2"><i class="bx bx-left-arrow"></i> Kembali</a>
                        <button type="submit" class="btn btn-md btn-success"><i class="bx bx-file"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection