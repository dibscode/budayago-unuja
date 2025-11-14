@extends('layouts.main')
@section('title', 'Detail Budaya')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5>Detail Budaya: {{ $budaya->nama_budaya }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Budaya</th>
                        <td>{{ $budaya->nama_budaya }}</td>
                    </tr>
                    <tr>
                        <th>Provinsi</th>
                        <td>{{ $budaya->provinsi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $budaya->deskripsi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Koordinat</th>
                        <td>
                            @if ($budaya->koordinat_lat && $budaya->koordinat_lng)
                                {{ $budaya->koordinat_lat }}, {{ $budaya->koordinat_lng }}
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Video</th>
                        <td>
                            @if ($budaya->video_url)
                                <a href="{{ $budaya->video_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-play-circle"></i> Lihat Video
                                </a>
                            @else
                                <span class="text-muted">Tidak ada video</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Daftar Segmen</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSegmentModal">
                    + Tambah Segment
                </button>
            </div>
            <div class="card-body">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Urutan</th>
                            <th>Judul Segment</th>
                            <th>Video</th>
                            <th>Teks Narasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($budaya->segments->sortBy('urutan') as $segment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $segment->urutan }}</td>
                                <td>{{ $segment->judul_segment ?? '-' }}</td>
                                <td>
                                    @if ($segment->video_url)
                                        <a href="{{ $segment->video_url }}" target="_blank"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-play-circle"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($segment->teks_narasi, 60) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editSegmentModal{{ $segment->id }}">
                                        Edit
                                    </button>

                                    <form id="delete-form-{{ $segment->id }}"
                                        action="{{ route('cultures.segments.destroy', ['id' => $budaya->id, 'segmentId' => $segment->id]) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-btn"
                                            data-id="{{ $segment->id }}">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="editSegmentModal{{ $segment->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('cultures.segments.update', $budaya->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-dark">
                                                <h5 class="modal-title">Edit Segment</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Urutan</label>
                                                    <input type="number" name="urutan" value="{{ $segment->urutan }}"
                                                        class="form-control" required>
                                                </div>
                                                <input type="hidden" name="segment_id" value="{{ $segment->id }}">
                                                <div class="mb-3">
                                                    <label class="form-label">Judul Segment</label>
                                                    <input type="text" name="judul_segment"
                                                        value="{{ $segment->judul_segment }}" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Video URL</label>
                                                    <input type="text" name="video_url"
                                                        value="{{ $segment->video_url }}" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Teks Narasi</label>
                                                    <textarea name="teks_narasi" class="form-control" rows="3">{{ $segment->teks_narasi }}</textarea>
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
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada segment untuk budaya ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Daftar Lagu</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLaguModal">
                    + Tambah Lagu
                </button>
            </div>
            <div class="card-body">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Lagu</th>
                            <th>Audio</th>
                            <th>Lirik</th>
                            <th>Arti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($budaya->lagus as $lagu)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lagu->judul_lagu ?? '-' }}</td>
                                <td>
                                    @if ($lagu->audio_url)
                                        <audio controls src="{{ asset('storage/' . $lagu->audio_url) }}" style="width: 200px;"></audio>
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($lagu->lirik, 60) }}</td>
                                <td>{{ Str::limit($lagu->arti, 60) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editLaguModal{{ $lagu->id }}">
                                        Edit
                                    </button>

                                    <form id="delete-lagu-form-{{ $lagu->id }}"
                                        action="{{ route('lagu.destroy', $lagu->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
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
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-dark">
                                                <h5 class="modal-title">Edit Lagu</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Judul Lagu</label>
                                                    <input type="text" name="judul_lagu"
                                                        value="{{ $lagu->judul_lagu }}" class="form-control" required>
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
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada lagu untuk budaya ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Daftar Arsip</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addArsipModalDetail">
                    + Tambah Arsip
                </button>
            </div>
            <div class="card-body">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Benda</th>
                            <th>Gambar</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($budaya->arsips as $arsip)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $arsip->nama_benda ?? '-' }}</td>
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
                                <td>{{ Str::limit($arsip->deskripsi, 60) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editArsipModal{{ $arsip->id }}">
                                        Edit
                                    </button>

                                    <form id="delete-arsip-form-{{ $arsip->id }}"
                                        action="{{ route('arsip.destroy', $arsip->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
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
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-dark">
                                                <h5 class="modal-title">Edit Arsip</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
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
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada arsip untuk budaya ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="modal fade" id="addSegmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('cultures.segments.store', $budaya->id) }}" method="POST">
                @csrf
                <input type="hidden" name="id_budaya" value="{{ $budaya->id }}">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Segment</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="urutan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul Segment</label>
                            <input type="text" name="judul_segment" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Video URL</label>
                            <input type="text" name="video_url" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teks Narasi</label>
                            <textarea name="teks_narasi" class="form-control" rows="3"></textarea>
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

    <div class="modal fade" id="addLaguModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('cultures.lagu.store', $budaya->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_budaya" value="{{ $budaya->id }}">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Lagu</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
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

    <div class="modal fade" id="addArsipModalDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('cultures.arsip.store', $budaya->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_budaya" value="{{ $budaya->id }}">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Arsip</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
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
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;

                Swal.fire({
                    title: 'Hapus Segment?',
                    text: 'Segment ini akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${id}`).submit();
                    }
                });
            });
        });
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