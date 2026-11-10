@extends('layouts.app')

@section('title', 'Data Tagihan')
@section('page-title', 'Data Tagihan')

@section('content')

<div class="page-header">
    <div>
        <h4>Data Tagihan</h4>
        <p>Kelola dan pantau pembayaran tagihan pelanggan.</p>
    </div>

    @if(auth()->user()->isAdmin())
    <a href="{{ route('invoices.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>
        Buat Tagihan
    </a>
    @endif
</div>

<div class="card">

    <div class="card-header">
        Daftar Tagihan
    </div>

    <div class="card-body border-bottom">
        <form action="{{ route('invoices.index') }}" method="GET"
            class="row g-2">

            <div class="col-md-5">
                <input type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari nomor invoice atau pelanggan..."
                    value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>

                    <option value="belum_bayar"
                        @selected(request('status')==='belum_bayar' )>
                        Belum Bayar
                    </option>

                    <option value="lunas"
                        @selected(request('status')==='lunas' )>
                        Lunas
                    </option>
                </select>
            </div>

            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-primary">
                    <i class="bi bi-search me-1"></i>
                    Cari
                </button>

                <a href="{{ route('invoices.index') }}"
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
                    <th>Nomor Invoice</th>
                    <th>Pelanggan</th>
                    <th>Periode</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Tanggal Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($invoices as $invoice)
                <tr>
                    <td>{{ $invoices->firstItem() + $loop->index }}</td>

                    <td>
                        <strong>{{ $invoice->invoice_number }}</strong>
                    </td>

                    <td>{{ $invoice->customer->name }}</td>

                    <td>
                        {{ $invoice->billing_period->format('F Y') }}
                    </td>

                    <td>
                        Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                    </td>

                    <td>
                        @if($invoice->payment_status === 'lunas')
                        <span class="badge bg-success">Lunas</span>
                        @else
                        <span class="badge bg-warning text-dark">
                            Belum Bayar
                        </span>
                        @endif
                    </td>

                    <td>
                        {{ $invoice->paid_at
                                ? $invoice->paid_at->format('d-m-Y H:i')
                                : '-' }}
                    </td>

                    <td>
                        <div class="d-flex gap-1">

                            <a href="{{ route('invoices.show', $invoice) }}"
                                class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>

                            @if(auth()->user()->isAdmin())
                            @if($invoice->payment_status === 'belum_bayar')
                            <form action="{{ route('invoices.pay', $invoice) }}"
                                method="POST"
                                onsubmit="return confirm('Konfirmasi pembayaran tagihan ini?')">
                                @csrf

                                <button class="btn btn-sm btn-success"
                                    title="Tandai Lunas">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            @endif

                            <form action="{{ route('invoices.destroy', $invoice) }}"
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
                    <td colspan="8" class="text-center py-4 text-muted">
                        Data tagihan tidak ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="card-body">
        {{ $invoices->links() }}
    </div>

</div>

@endsection