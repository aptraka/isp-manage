@extends('layouts.app')

@section('title', 'Detail Tagihan')
@section('page-title', 'Detail Tagihan')

@section('content')

<div class="page-header">
    <div>
        <h4>Detail Tagihan</h4>
        <p>Informasi lengkap tagihan pelanggan.</p>
    </div>

    <a href="{{ route('invoices.index') }}" class="btn btn-light">
        Kembali
    </a>
</div>

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <span>Invoice {{ $invoice->invoice_number }}</span>

                @if($invoice->payment_status === 'lunas')
                <span class="badge bg-success">Lunas</span>
                @else
                <span class="badge bg-warning text-dark">Belum Bayar</span>
                @endif
            </div>

            <div class="card-body">

                <div class="row mb-4">

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Nama Pelanggan</small>
                        <div class="fw-semibold">
                            {{ $invoice->customer->name }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Nomor Telepon</small>
                        <div class="fw-semibold">
                            {{ $invoice->customer->phone }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Paket Internet</small>
                        <div class="fw-semibold">
                            {{ $invoice->customer->internetPackage->name }}
                            ({{ $invoice->customer->internetPackage->speed }})
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Periode Tagihan</small>
                        <div class="fw-semibold">
                            {{ $invoice->billing_period->format('F Y') }}
                        </div>
                    </div>

                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Total Tagihan</span>

                    <h4 class="text-primary fw-bold mb-0">
                        Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                    </h4>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Status Pembayaran</small>
                        <div class="fw-semibold">
                            {{ $invoice->payment_status === 'lunas'
                                ? 'Lunas'
                                : 'Belum Bayar' }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Tanggal Pembayaran</small>
                        <div class="fw-semibold">
                            {{ $invoice->paid_at
                                ? $invoice->paid_at->format('d-m-Y H:i')
                                : '-' }}
                        </div>
                    </div>
                </div>

                @if(auth()->user()->isAdmin()
                && $invoice->payment_status === 'belum_bayar')

                <form action="{{ route('invoices.pay', $invoice) }}"
                    method="POST"
                    onsubmit="return confirm('Konfirmasi pembayaran tagihan ini?')">

                    @csrf

                    <button class="btn btn-success w-100">
                        <i class="bi bi-check-circle me-1"></i>
                        Tandai Sudah Dibayar
                    </button>

                </form>

                @endif

            </div>
        </div>

    </div>

</div>

@endsection