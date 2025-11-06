@extends('layouts.main')
@section('title', 'Users Manajemen')
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Manajemen User</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    + Tambah User
                </button>
            </div>

            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->nama_lengkap }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'secondary' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>{{ $user->alamat ?? '-' }}</td>
                                <td>{{ $user->no_telp ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editUserModal{{ $user->id }}">
                                        Edit
                                    </button>

                                    <form id="delete-form-{{ $user->id }}"
                                        action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-btn"
                                            data-id="{{ $user->id }}">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Edit --}}
                            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-dark">
                                                <h5 class="modal-title">Edit User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="nama_lengkap{{ $user->id }}" class="form-label">Nama
                                                        Lengkap</label>
                                                    <input type="text" class="form-control"
                                                        id="nama_lengkap{{ $user->id }}" name="nama_lengkap"
                                                        value="{{ $user->nama_lengkap }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email{{ $user->id }}" class="form-label">Email</label>
                                                    <input type="email" class="form-control"
                                                        id="email{{ $user->id }}" name="email"
                                                        value="{{ $user->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password{{ $user->id }}" class="form-label">
                                                        Password (opsional)
                                                    </label>
                                                    <input type="password" class="form-control"
                                                        id="password{{ $user->id }}" name="password"
                                                        placeholder="Kosongkan jika tidak diubah">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="role{{ $user->id }}" class="form-label">Role</label>
                                                    <select name="role" id="role{{ $user->id }}" class="form-select"
                                                        required>
                                                        <option value="admin"
                                                            {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="penjual"
                                                            {{ $user->role === 'penjual' ? 'selected' : '' }}>Penjual
                                                        </option>
                                                        <option value="pembeli"
                                                            {{ $user->role === 'pembeli' ? 'selected' : '' }}>Pembeli
                                                        </option>

                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="alamat{{ $user->id }}"
                                                        class="form-label">Alamat</label>
                                                    <textarea name="alamat" id="alamat{{ $user->id }}" class="form-control">{{ $user->alamat }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="no_telp{{ $user->id }}" class="form-label">No.
                                                        Telepon</label>
                                                    <input type="text" class="form-control"
                                                        id="no_telp{{ $user->id }}" name="no_telp"
                                                        value="{{ $user->no_telp }}">
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

    {{-- Modal Tambah User --}}
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah User Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="penjual">Penjual</option>
                                <option value="pembeli">Pembeli</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp">
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
    {{-- End Modal Tambah User --}}
@endsection
