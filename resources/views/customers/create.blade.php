@extends('layouts.app')

@section('title', 'Tambah Pelanggan')
@section('page-title', 'Tambah Pelanggan')

@section('content')

<div class="page-header">
    <div>
        <h4>Tambah Pelanggan</h4>
        <p>Masukkan informasi pelanggan baru.</p>
    </div>

    <a href="{{ route('customers.index') }}" class="btn btn-light">
        Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">Form Pelanggan</div>

    <div class="card-body">
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

            @include('customers._form')

            <button class="btn btn-primary">
                <i class="bi bi-save me-1"></i>
                Simpan Pelanggan
            </button>
        </form>
    </div>
</div>

@endsection