@extends('layouts.admin.main')

@section('content')
<div class="card">
    <div class="card-header mb-4 border-bottom">
        <h4 class="m-0 p-0">Edit Penyakit <span class="text-primary">{{ $item->code ?? $lastCode }}</span></h4>
    </div>
    <div class="card-body">
        <form action="{{ route('penyakit.update', encrypt($item->id)) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="kode-penyakit" class="form-label">Kode Penyakit</label>
                        <input type="text" class="form-control form-control-md" id="kode-penyakit" placeholder="Kode Penyakit" value="{{ old('code', $item->code ?? $lastCode) }}" required disabled/>
                    </div>
                    <div class="mb-3">
                        <label for="nama-penyakit" class="form-label">Nama Penyakit</label>
                        <input type="text" class="form-control form-control-md" id="nama-penyakit" name="name" placeholder="Nama penyakit" value="{{ old('name', $item->name ?? '') }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control form-control-md" id="deskripsi" cols="10" rows="3" placeholder="Deskripsi penyakit">{{ old('description', $item->description ?? '') }}</textarea>
                    </div>
                </div>
                <div class="col-md-12 mt-4 border-top">
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('penyakit.index') }}" class="btn btn-md btn-danger me-2"><i class="bx bx-left-arrow"></i> Kembali</a>
                        <button type="submit" class="btn btn-md btn-success"><i class="bx bx-file"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection