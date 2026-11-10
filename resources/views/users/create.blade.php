@extends('layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User')

@section('content')

<div class="page-header">
    <div>
        <h4>Tambah User</h4>
        <p>Tambahkan akun baru ke dalam sistem.</p>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-light">
        Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">Form Tambah Pengguna</div>

    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            @include('users._form')

            <div class="d-flex gap-2">
                <button class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    Simpan
                </button>

                <a href="{{ route('users.index') }}"
                    class="btn btn-light">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection