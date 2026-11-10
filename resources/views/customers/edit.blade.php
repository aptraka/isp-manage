@extends('layouts.app')

@section('title', 'Edit Pelanggan')
@section('page-title', 'Edit Pelanggan')

@section('content')

<div class="page-header">
    <div>
        <h4>Edit Pelanggan</h4>
        <p>Perbarui informasi pelanggan.</p>
    </div>

    <a href="{{ route('customers.index') }}" class="btn btn-light">
        Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">Form Edit Pelanggan</div>

    <div class="card-body">
        <form action="{{ route('customers.update', $customer) }}"
            method="POST">
            @csrf
            @method('PUT')

            @include('customers._form')

            <button class="btn btn-primary">
                <i class="bi bi-save me-1"></i>
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

@endsection