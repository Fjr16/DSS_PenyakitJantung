@extends('layouts.admin.main')

@section('content')

    <div class="accordion mb-3" id="accordionExample">
        <div class="card accordion-item active">
        <h2 class="accordion-header" id="headingOne">
            <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne" role="tabpanel">
            Tambah / Edit Rule
            </button>
        </h2>
    
        <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <form action="{{ route('demster/rule.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label for="penyakit" class="form-label">Penyakit</label>
                                <select class="form-select" id="penyakit" name="disease_id" aria-label="Default select example" required>
                                  <option selected disabled>Pilih Penyakit</option>
                                  @foreach ($penyakits as $p)
                                    @if (old('disease_id') == $p->id)
                                        <option value="{{ $p->id }}" selected>{{ $p->name ?? '-' }}</option>
                                    @else
                                        <option value="{{ $p->id }}">{{ $p->name ?? '-' }}</option>
                                    @endif
                                  @endforeach
                                </select>
                              </div>
                            <div class="row">
                                <label for="penyakit" class="form-label">Gejala</label>
                                @foreach ($gejalas as $g)    
                                <div class="col-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="symtom_id[]" value="{{ $g->id ?? '' }}" id="symtom_id_{{ $loop->iteration }}" />
                                        <label class="form-check-label" for="symtom_id_{{ $loop->iteration }}">
                                            <span class="text-capitalize">{{ $g->name ?? '-' }}</span> {{  ' (' . ($g->code ?? '-') . ')'  }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-12 mt-0">
                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-md btn-success"><i class="bx bx-file"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between border-bottom mb-4">
            <h4 class="m-0 p-0">Data Rule Demster</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table" id="datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Gejala</th>
                            <th>Nama Gejala</th>
                            <th>Nama Penyakit</th>
                            <th>Bobot</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->code ?? '-' }}</td>
                                <td>{{ $item->name ?? '-' }}</td>
                                <td>
                                    <table>
                                        @foreach ($item->diseases as $disease)                                        
                                        <tr>
                                            <td>{{ $disease->name ?? '' }}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td>
                                    {{ $item->diseases->isEmpty() ? '' : ($item->bobot ?? '') }}
                                </td>
                                {{-- <td>
                                    <div class="d-flex">
                                        <button class="btn btn-icon btn-outline-danger" type="button" data-url="{{ route('demster/rule.destroy', encrypt($item->id)) }}" onclick="showModalDelete(this)">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-modal-confirm-delete>
        Apakah anda yakin ingin menghapus data alternatif wisata ini ?
    </x-modal-confirm-delete>
@endsection

