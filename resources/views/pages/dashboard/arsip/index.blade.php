@extends('layouts.main')
@section('title', 'BudayaGo - Daftar Arsip')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Daftar Semua Arsip</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addArsipModal">
                    + Tambah Arsip
                </button>
            </div>

            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Benda</th>
                            <th>Budaya Terkait</th>
                            <th>Gambar</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arsips as $arsip)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $arsip->nama_benda }}</td>
                                <td>
                                    <a href="{{ route('cultures.show', $arsip->budaya->id) }}">{{ $arsip->budaya->nama_budaya }}</a>
                                </td>
                                <td>
                                    @if ($arsip->gambar_url)
                                        <a href="{{ asset('storage/' . $arsip->gambar_url) }}" target="_blank"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-image"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($arsip->deskripsi, 50) ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editArsipModal{{ $arsip->id }}">
                                        Edit
                                    </button>
                                    <a href="{{ route('cultures.show', $arsip->budaya->id) }}" class="btn btn-sm btn-info">
                                        Lihat Budaya
                                    </a>

                                    <form id="delete-arsip-form-{{ $arsip->id }}"
                                        action="{{ route('arsip.destroy', $arsip->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="from_index" value="true">
                                        <button type="button" class="btn btn-sm btn-danger delete-arsip-btn"
                                            data-id="{{ $arsip->id }}">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="editArsipModal{{ $arsip->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('arsip.update', $arsip->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="from_index" value="true">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-dark">
                                                <h5 class="modal-title">Edit Arsip</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Benda</label>
                                                    <input type="text" name="nama_benda"
                                                        value="{{ $arsip->nama_benda }}" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Upload Gambar Baru (Opsional)</label>
                                                    <input type="file" name="gambar_url" class="form-control" accept="image/*">
                                                </div>
                                                @if ($arsip->gambar_url)
                                                    <div class="mb-2">
                                                        <label class="form-label">Gambar Saat Ini:</label>
                                                        <img src="{{ asset('storage/' . $arsip->gambar_url) }}" alt="Gambar Lama"
                                                            style="width: 150px; height: auto;">
                                                    </div>
                                                @endif
                                                <div class="mb-3">
                                                    <label class="form-label">Deskripsi</label>
                                                    <textarea name="deskripsi" class="form-control" rows="3">{{ $arsip->deskripsi }}</textarea>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="modal fade" id="addArsipModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="from_index" value="true">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Arsip Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pilih Budaya</label>
                            <select name="id_budaya" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Budaya --</option>
                                @foreach ($budayas as $budaya)
                                    <option value="{{ $budaya->id }}">{{ $budaya->nama_budaya }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Benda</label>
                            <input type="text" name="nama_benda" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Gambar</label>
                            <input type="file" name="gambar_url" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
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
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.delete-arsip-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                Swal.fire({
                    title: 'Hapus Arsip?',
                    text: 'Arsip ini akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-arsip-form-${id}`).submit();
                    }
                });
            });
        });
    </script>
@endpush