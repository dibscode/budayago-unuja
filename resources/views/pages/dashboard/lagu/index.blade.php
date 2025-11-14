@extends('layouts.main')
@section('title', 'BudayaGo - Daftar Lagu')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Daftar Semua Lagu</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLaguModal">
                    + Tambah Lagu
                </button>
            </div>

            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Lagu</th>
                            <th>Budaya Terkait</th>
                            <th>Audio</th>
                            <th>Lirik</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lagus as $lagu)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lagu->judul_lagu }}</td>
                                <td>
                                    <a href="{{ route('cultures.show', $lagu->budaya->id) }}">{{ $lagu->budaya->nama_budaya }}</a>
                                </td>
                                <td>
                                    @if ($lagu->audio_url)
                                        <audio controls src="{{ asset('storage/' . $lagu->audio_url) }}" style="width: 200px;"></audio>
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($lagu->lirik, 50) ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editLaguModal{{ $lagu->id }}">
                                        Edit
                                    </button>
                                    <a href="{{ route('cultures.show', $lagu->budaya->id) }}" class="btn btn-sm btn-info">
                                        Lihat Budaya
                                    </a>

                                    <form id="delete-lagu-form-{{ $lagu->id }}"
                                        action="{{ route('lagu.destroy', $lagu->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="from_index" value="true">
                                        <button type="button" class="btn btn-sm btn-danger delete-lagu-btn"
                                            data-id="{{ $lagu->id }}">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="editLaguModal{{ $lagu->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('lagu.update', $lagu->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="from_index" value="true">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-dark">
                                                <h5 class="modal-title">Edit Lagu</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Judul Lagu</label>
                                                    <input type="text" name="judul_lagu" value="{{ $lagu->judul_lagu }}"
                                                        class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Upload Audio Baru (Opsional)</label>
                                                    <input type="file" name="audio_url" class="form-control" accept="audio/*">
                                                </div>
                                                @if ($lagu->audio_url)
                                                    <div class="mb-2">
                                                        <label class="form-label">Audio Saat Ini:</label>
                                                        <audio controls src="{{ asset('storage/' . $lagu->audio_url) }}" style="width: 100%;"></audio>
                                                    </div>
                                                @endif
                                                <div class="mb-3">
                                                    <label class="form-label">Lirik</label>
                                                    <textarea name="lirik" class="form-control" rows="3">{{ $lagu->lirik }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Arti</label>
                                                    <textarea name="arti" class="form-control" rows="3">{{ $lagu->arti }}</textarea>
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

    <div class="modal fade" id="addLaguModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('lagu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="from_index" value="true">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Lagu Baru</h5>
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
                            <label class="form-label">Judul Lagu</label>
                            <input type="text" name="judul_lagu" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Audio</label>
                            <input type="file" name="audio_url" class="form-control" accept="audio/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lirik</label>
                            <textarea name="lirik" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Arti</label>
                            <textarea name="arti" class="form-control" rows="3"></textarea>
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
        document.querySelectorAll('.delete-lagu-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;

                Swal.fire({
                    title: 'Hapus Lagu?',
                    text: 'Lagu ini akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-lagu-form-${id}`).submit();
                    }
                });
            });
        });
    </script>
@endpush