@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h3>Dashboard</h3>
        <p>Ringkasan informasi pelanggan dan tagihan internet.</p>
    </div>

    <div class="text-muted small">
        <i class="bi bi-calendar3 me-1"></i>
        {{ now()->translatedFormat('d F Y') }}
    </div>
</div>

{{-- STATISTICS --}}
<div class="row g-3 mb-4">

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stat-label">Total Pelanggan</span>
                <div class="stat-icon blue">
                    <i class="bi bi-people"></i>
                </div>
            </div>

            <div class="stat-value">
                {{ number_format($totalCustomers) }}
            </div>

            <div class="stat-label">
                Seluruh pelanggan terdaftar
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stat-label">Pelanggan Aktif</span>
                <div class="stat-icon green">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>

            <div class="stat-value">
                {{ number_format($activeCustomers) }}
            </div>

            <div class="stat-label">
                Layanan sedang aktif
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stat-label">Pelanggan Suspend</span>
                <div class="stat-icon orange">
                    <i class="bi bi-pause-circle"></i>
                </div>
            </div>

            <div class="stat-value">
                {{ number_format($suspendedCustomers) }}
            </div>

            <div class="stat-label">
                Layanan ditangguhkan
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stat-label">Tagihan Belum Dibayar</span>
                <div class="stat-icon red">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>

            <div class="stat-value">
                {{ number_format($unpaidInvoices) }}
            </div>

            <div class="stat-label">
                Tagihan menunggu pembayaran
            </div>
        </div>
    </div>

</div>

{{-- CHART AND CUSTOMER STATUS --}}
<div class="row g-3 mb-4">

    {{-- MONTHLY INVOICE CHART --}}
    <div class="col-12 col-xl-8">
        <div class="content-card h-100">

            <div class="content-card-header">
                <div>
                    <h5>Grafik Tagihan Bulanan</h5>
                    <small class="text-muted">
                        Ringkasan nominal tagihan setiap bulan
                    </small>
                </div>

                <span class="badge bg-primary-subtle text-primary">
                    Tahun {{ now()->year }}
                </span>
            </div>

            <div class="content-card-body">
                <div class="chart-container">
                    <canvas id="invoiceChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    {{-- CUSTOMER STATUS --}}
    <div class="col-12 col-xl-4">
        <div class="content-card h-100">

            <div class="content-card-header">
                <h5>Status Pelanggan</h5>
            </div>

            <div class="content-card-body">

                {{-- ACTIVE --}}
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small">Aktif</span>
                        <strong>{{ number_format($activeCustomers) }}</strong>
                    </div>

                    <div class="progress" style="height: 9px;">
                        <div class="progress-bar bg-success"
                            style="width: {{ $totalCustomers > 0 ? ($activeCustomers / $totalCustomers) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                {{-- SUSPEND --}}
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small">Suspend</span>
                        <strong>{{ number_format($suspendedCustomers) }}</strong>
                    </div>

                    <div class="progress" style="height: 9px;">
                        <div class="progress-bar bg-warning"
                            style="width: {{ $totalCustomers > 0 ? ($suspendedCustomers / $totalCustomers) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                {{-- DISCONNECTED --}}
                <div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small">Terputus</span>
                        <strong>{{ number_format($disconnectedCustomers) }}</strong>
                    </div>

                    <div class="progress" style="height: 9px;">
                        <div class="progress-bar bg-danger"
                            style="width: {{ $totalCustomers > 0 ? ($disconnectedCustomers / $totalCustomers) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

{{-- RECENT INVOICES --}}
<div class="content-card">

    <div class="content-card-header">
        <div>
            <h5>Tagihan Terbaru</h5>
            <small class="text-muted">
                Daftar tagihan pelanggan terbaru
            </small>
        </div>

        <a href="{{ route('invoices.index') }}"
            class="btn btn-sm btn-outline-primary">
            Lihat Semua
            <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">

            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Pelanggan</th>
                    <th>Periode</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($recentInvoices as $invoice)
                <tr>
                    <td class="fw-semibold">
                        {{ $invoice->invoice_number }}
                    </td>

                    <td>
                        {{ $invoice->customer?->name ?? 'Pelanggan dihapus' }}
                    </td>

                    <td>
                        {{ $invoice->billing_period->translatedFormat('F Y') }}
                    </td>

                    <td class="fw-semibold">
                        Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                    </td>

                    <td>
                        @if($invoice->payment_status === 'lunas')
                        <span class="badge-status badge-paid">
                            <i class="bi bi-check-circle me-1"></i>
                            Lunas
                        </span>
                        @else
                        <span class="badge-status badge-unpaid">
                            <i class="bi bi-clock me-1"></i>
                            Belum Bayar
                        </span>
                        @endif
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        Belum ada data tagihan.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection

{{-- CHART JAVASCRIPT --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const canvas = document.getElementById('invoiceChart');

        if (!canvas || typeof Chart === 'undefined') {
            return;
        }

        const monthlyInvoices = @json($monthlyInvoices);

        const monthNames = [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];

        const invoiceLabels = monthlyInvoices.map(item => {
            return monthNames[Number(item.month) - 1] ?? '';
        });

        const invoiceValues = monthlyInvoices.map(item => {
            return Number(item.total) || 0;
        });

        new Chart(canvas, {
            type: 'bar',

            data: {
                labels: invoiceLabels,
                datasets: [{
                    label: 'Total Tagihan',
                    data: invoiceValues,
                    backgroundColor: '#2563eb',
                    hoverBackgroundColor: '#1d4ed8',
                    borderRadius: 6,
                    maxBarThickness: 45
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    },

                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID')
                                    .format(context.raw);
                            }
                        }
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true,

                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID')
                                    .format(value);
                            }
                        },

                        grid: {
                            color: '#f1f5f9'
                        }
                    },

                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

    });
</script>
@endpush