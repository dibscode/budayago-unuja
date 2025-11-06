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

        {{-- SEGMENT LIST --}}
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
                        @forelse ($budaya->segments as $segment)
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

                            {{-- Modal Edit Segment --}}
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
                            {{-- End Modal Edit Segment --}}
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada segment untuk budaya ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- Modal Tambah Segment --}}
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
    {{-- End Modal Tambah Segment --}}
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
    </script>
@endpush
