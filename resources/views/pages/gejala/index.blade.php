@extends('layouts.admin.main')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between border-bottom mb-4">
            <h4 class="m-0 p-0">Data Gejala</h4>
            @can('admin')
            <a href="{{ route('gejala.create') }}" class="btn btn-sm btn-primary">Tambah Gejala</a>
            @endcan
        </div>
        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table" id="datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Gejala</th>
                            <th>Nama Gejala</th>
                            <th>Bobot</th>
                            @can('admin')
                            <th>Action</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->code ?? '-' }}</td>
                                <td>{{ $item->name ?? '-' }}</td>
                                <td>{{ $item->bobot ?? '-' }}</td>
                                @can('admin')
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('gejala.edit', encrypt($item->id)) }}" class="btn btn-icon btn-outline-warning me-1"><i class="bx bx-edit"></i></a>
                                            
                                        <button class="btn btn-icon btn-outline-danger" type="button" data-url="{{ route('gejala.destroy', encrypt($item->id)) }}" onclick="showModalDelete(this)">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
                                @endcan
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

