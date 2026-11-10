@extends('layouts.app')

@section('title', 'Data Pelanggan')
@section('page-title', 'Data Pelanggan')

@section('content')

<div class="page-header">
    <div>
        <h4>Data Pelanggan</h4>
        <p>Kelola informasi dan status pelanggan internet.</p>
    </div>

    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>
        Tambah Pelanggan
    </a>
</div>

<div class="card">

    <div class="card-header">
        Daftar Pelanggan
    </div>

    <div class="card-body border-bottom">

        <form method="GET" action="{{ route('customers.index') }}"
            class="row g-2">

            <div class="col-md-5">
                <input type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari nama, nomor telepon, atau alamat..."
                    value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>

                    <option value="aktif" @selected(request('status')==='aktif' )>
                        Aktif
                    </option>

                    <option value="suspend" @selected(request('status')==='suspend' )>
                        Suspend
                    </option>

                    <option value="terputus" @selected(request('status')==='terputus' )>
                        Terputus
                    </option>
                </select>
            </div>

            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-primary">
                    <i class="bi bi-search me-1"></i>
                    Cari
                </button>

                <a href="{{ route('customers.index') }}"
                    class="btn btn-light">
                    Reset
                </a>
            </div>

        </form>

    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Telepon</th>
                    <th>Paket</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td>{{ $customers->firstItem() + $loop->index }}</td>

                    <td>
                        <strong>{{ $customer->name }}</strong>
                    </td>

                    <td>{{ $customer->phone }}</td>

                    <td>
                        {{ $customer->internetPackage->name }}
                        <small class="text-muted">
                            ({{ $customer->internetPackage->speed }})
                        </small>
                    </td>

                    <td>
                        Rp {{ number_format($customer->package_price, 0, ',', '.') }}
                    </td>

                    <td>
                        @if($customer->status === 'aktif')
                        <span class="badge bg-success">Aktif</span>
                        @elseif($customer->status === 'suspend')
                        <span class="badge bg-warning text-dark">Suspend</span>
                        @else
                        <span class="badge bg-danger">Terputus</span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex gap-1">

                            <a href="{{ route('customers.show', $customer) }}"
                                class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('customers.edit', $customer) }}"
                                class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>

                            @if(auth()->user()->isAdmin())
                            <form action="{{ route('customers.destroy', $customer) }}"
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
                    <td colspan="7" class="text-center py-4 text-muted">
                        Data pelanggan tidak ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="card-body">
        {{ $customers->links() }}
    </div>

</div>

@endsection