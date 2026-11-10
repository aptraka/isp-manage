@extends('layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')

<div class="page-header">
    <div>
        <h4>Manajemen User</h4>
        <p>Kelola akun administrator dan staff.</p>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>
        Tambah User
    </a>
</div>

<div class="card">

    <div class="card-header">
        Daftar Pengguna
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tanggal Dibuat</th>
                    <th width="130">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $users->firstItem() + $loop->index }}</td>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>
                        @if($user->role === 'admin')
                        <span class="badge bg-primary">Admin</span>
                        @else
                        <span class="badge bg-secondary">Staff</span>
                        @endif
                    </td>

                    <td>{{ $user->created_at->format('d-m-Y') }}</td>

                    <td>
                        <div class="d-flex gap-1">

                            <a href="{{ route('users.edit', $user) }}"
                                class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>

                            @if($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user) }}"
                                method="POST"
                                class="delete-form">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        Belum ada pengguna.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="card-body">
        {{ $users->links() }}
    </div>

</div>

@endsection