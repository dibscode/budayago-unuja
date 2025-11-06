@extends('layouts.main')
@section('title', 'BudayaGo - Daftar Budaya')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Daftar Budaya</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBudayaModal">
                    + Tambah Budaya
                </button>
            </div>

            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Budaya</th>
                            <th>Provinsi</th>
                            <th>Koordinat</th>
                            <th>Video</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cultures as $budaya)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $budaya->nama_budaya }}</td>
                                <td>{{ $budaya->provinsi ?? '-' }}</td>
                                <td>
                                    @if ($budaya->koordinat_lat && $budaya->koordinat_lng)
                                        {{ $budaya->koordinat_lat }}, {{ $budaya->koordinat_lng }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($budaya->video_url)
                                        <a href="{{ $budaya->video_url }}" target="_blank"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-play-circle"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editBudayaModal{{ $budaya->id }}">
                                        Edit
                                    </button>
                                    <a href="{{route('cultures.show',$budaya->id)}}" class="btn btn-sm btn-info">
                                        Lihat Detail
                                    </a>

                                    <form id="delete-form-{{ $budaya->id }}"
                                        action="{{ route('cultures.destroy', $budaya->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-btn"
                                            data-id="{{ $budaya->id }}">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Edit Budaya --}}
                            <div class="modal fade" id="editBudayaModal{{ $budaya->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('cultures.update', $budaya->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-dark">
                                                <h5 class="modal-title">Edit Budaya</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Budaya</label>
                                                    <input type="text" name="nama_budaya" class="form-control"
                                                        value="{{ $budaya->nama_budaya }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Provinsi</label>
                                                    <input type="text" name="provinsi" class="form-control"
                                                        value="{{ $budaya->provinsi }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Deskripsi</label>
                                                    <textarea name="deskripsi" class="form-control" rows="3">{{ $budaya->deskripsi }}</textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Koordinat Latitude</label>
                                                        <input type="text" name="koordinat_lat" class="form-control"
                                                            value="{{ $budaya->koordinat_lat }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Koordinat Longitude</label>
                                                        <input type="text" name="koordinat_lng" class="form-control"
                                                            value="{{ $budaya->koordinat_lng }}">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">URL Video</label>
                                                    <input type="text" name="video_url" class="form-control"
                                                        value="{{ $budaya->video_url }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-warning">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- End Modal Edit --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- Modal Tambah Budaya --}}
    <div class="modal fade" id="addBudayaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('cultures.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Budaya Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Budaya</label>
                            <input type="text" name="nama_budaya" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Koordinat Latitude</label>
                                <input type="text" name="koordinat_lat" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Koordinat Longitude</label>
                                <input type="text" name="koordinat_lng" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL Video</label>
                            <input type="text" name="video_url" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- End Modal Tambah Budaya --}}
@endsection
