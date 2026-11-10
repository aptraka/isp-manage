@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')

<div class="page-header">
    <div>
        <h4>Edit User</h4>
        <p>Perbarui informasi akun pengguna.</p>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-light">
        Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">Form Edit Pengguna</div>

    <div class="card-body">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            @include('users._form')

            <button class="btn btn-primary">
                <i class="bi bi-save me-1"></i>
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

@endsection