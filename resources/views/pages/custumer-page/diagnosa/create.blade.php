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
                        <select class="form-select" id="jenis-kelamin" name="jenis_kelamin" aria-label="Default select example" required>
                          <option selected>Pilih</option>
                          <option value="Pria">Pria</option>
                          <option value="Wanita">Wanita</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" placeholder="Ketik alamat pasien disini ..." cols="30" rows="4" required></textarea>
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

@isset($showModal)    
    <!-- Extra Large Modal -->
    <div class="modal fade" id="exLargeModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-image: url('/assets/img/bg.jpg'); background-size: cover; background-position: center;">
            <h4 class="modal-title text-white" id="exampleModalLabel4">
                Hasil Diagnosa
            </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>     
        <div class="modal-body">
            <div class="pb-2 border-bottom mb-2">
                <div class="mb-0 row">
                    <span class="fw-bold col-1">Nama</span>
                    <span class="col-11">
                        : {{ $dataPasien['name'] }} ({{ $dataPasien['usia'] }}) th <span class="badge bg-{{ $dataPasien['jenis_kelamin'] == 'Pria' ? 'primary' : 'danger' }}">{{ $dataPasien['jenis_kelamin'] == 'Pria' ? 'L' : 'P' }}</span>
                    </span> 
                </div>
                <div class="mb-0 row">
                    <span class="fw-bold col-1">Alamat</span> 
                    <span class="col-11">
                        : {{ $dataPasien['alamat'] ?? '-' }}
                    </span>
                </div>
            </div>
            <div class="mb-2">
                <h5>Gejala Dialami</h5>
                <div class="row mb-3">
                    <div class="col">
                        <ol>
                            @foreach ($dataGejala as $sym)
                                <li>{{ $sym->name ?? '-' }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                <h5>Hasil Diagnosa</h5>
                <div class="row">
                    <div class="col">
                        Pasien di diagnosa <span class="fw-bold fst-italic">{{ $hasilDiagnosa ? $hasilDiagnosa->name : 'Tidak Diketahui' }}</span>
                        @if ($hasilDiagnosa)
                        dengan nilai
                        sebesar <span class="fw-bold fst-italic">{{ (round($maxValue ?? 0, 2) * 100) . ' %' }}</span>
                        @endif 
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </div>
@endisset

  <script>
        if ({{ isset($showModal) }}){
            document.addEventListener("DOMContentLoaded", function() {
                const modal = new bootstrap.Modal(document.getElementById('exLargeModal'));
                modal.show();
            });
        }

  </script>
    
@endsection