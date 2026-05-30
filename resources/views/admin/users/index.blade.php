@extends('layouts.admin')

@section('content')

<h3 class="fw-bold mb-4">List User</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive">

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role Saat Ini</th>
                    <th width="260">Ubah Role</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>

                        <td>
                            <span class="badge bg-primary">
                                {{ $user->role ?? 'user' }}
                            </span>
                        </td>

                        <td>
                            <form action="{{ route('admin.users.update-role', $user->id) }}"
                                  method="POST"
                                  class="d-flex gap-2">
                                @csrf
                                @method('PUT')

                                <select name="role" class="form-select form-select-sm">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>
                                        User
                                    </option>
                                    <option value="penulis" {{ $user->role == 'penulis' ? 'selected' : '' }}>
                                        Penulis
                                    </option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                                        Admin
                                    </option>
                                </select>

                                <button class="btn btn-sm btn-success">
                                    Simpan
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Belum ada user.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection