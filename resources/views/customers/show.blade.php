@extends('layouts.app')

@section('title', 'Detail Pelanggan')
@section('page-title', 'Detail Pelanggan')

@section('content')

<div class="page-header">
    <div>
        <h4>Detail Pelanggan</h4>
        <p>Informasi lengkap pelanggan dan riwayat tagihan.</p>
    </div>

    <a href="{{ route('customers.index') }}" class="btn btn-light">
        Kembali
    </a>
</div>

<div class="row g-3">

    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">Informasi Pelanggan</div>

            <div class="card-body">

                <div class="mb-3">
                    <small class="text-muted">Nama</small>
                    <div class="fw-semibold">{{ $customer->name }}</div>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Nomor Telepon</small>
                    <div class="fw-semibold">{{ $customer->phone }}</div>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Alamat</small>
                    <div class="fw-semibold">{{ $customer->address }}</div>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Paket Internet</small>
                    <div class="fw-semibold">
                        {{ $customer->internetPackage->name }}
                        ({{ $customer->internetPackage->speed }})
                    </div>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Harga Paket</small>
                    <div class="fw-semibold">
                        Rp {{ number_format($customer->package_price, 0, ',', '.') }}
                    </div>
                </div>

                <div>
                    <small class="text-muted">Status</small>
                    <div>
                        @if($customer->status === 'aktif')
                        <span class="badge bg-success">Aktif</span>
                        @elseif($customer->status === 'suspend')
                        <span class="badge bg-warning text-dark">Suspend</span>
                        @else
                        <span class="badge bg-danger">Terputus</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">Riwayat Tagihan</div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">

                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Periode</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($customer->invoices as $invoice)
                        <tr>
                            <td>
                                <a href="{{ route('invoices.show', $invoice) }}">
                                    {{ $invoice->invoice_number }}
                                </a>
                            </td>

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
                                <span class="badge bg-warning text-dark">Belum Bayar</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                Belum ada tagihan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

@endsection