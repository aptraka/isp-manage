@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div class="page-header">
    <div>
        <h4>Dashboard</h4>
        <p>Ringkasan informasi pelanggan dan tagihan internet.</p>
    </div>
</div>

<div class="row g-3 mb-4">

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="d-flex justify-content-between">
                <span class="stat-label">Total Pelanggan</span>
                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-people"></i>
                </div>
            </div>

            <div class="stat-value">{{ number_format($totalCustomers) }}</div>
            <div class="stat-label">Seluruh pelanggan terdaftar</div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="d-flex justify-content-between">
                <span class="stat-label">Pelanggan Aktif</span>
                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>

            <div class="stat-value">{{ number_format($activeCustomers) }}</div>
            <div class="stat-label">Layanan sedang aktif</div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="d-flex justify-content-between">
                <span class="stat-label">Pelanggan Suspend</span>
                <div class="stat-icon bg-warning-subtle text-warning">
                    <i class="bi bi-pause-circle"></i>
                </div>
            </div>

            <div class="stat-value">{{ number_format($suspendedCustomers) }}</div>
            <div class="stat-label">Layanan ditangguhkan</div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="d-flex justify-content-between">
                <span class="stat-label">Tagihan Belum Dibayar</span>
                <div class="stat-icon bg-danger-subtle text-danger">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>

            <div class="stat-value">{{ number_format($unpaidInvoices) }}</div>
            <div class="stat-label">Tagihan menunggu pembayaran</div>
        </div>
    </div>

</div>

<div class="row g-3">

    <div class="col-12 col-xl-8">
        <div class="card h-100">
            <div class="card-header">
                Grafik Tagihan Bulanan
            </div>

            <div class="card-body">
                <canvas id="invoiceChart" height="110"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-4">
        <div class="card h-100">
            <div class="card-header">
                Status Pelanggan
            </div>

            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Aktif</span>
                        <strong>{{ $activeCustomers }}</strong>
                    </div>

                    <div class="progress" style="height: 9px;">
                        <div class="progress-bar bg-success"
                            style="width: {{ $totalCustomers ? ($activeCustomers / $totalCustomers) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Suspend</span>
                        <strong>{{ $suspendedCustomers }}</strong>
                    </div>

                    <div class="progress" style="height: 9px;">
                        <div class="progress-bar bg-warning"
                            style="width: {{ $totalCustomers ? ($suspendedCustomers / $totalCustomers) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                <div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Terputus</span>
                        <strong>{{ $disconnectedCustomers }}</strong>
                    </div>

                    <div class="progress" style="height: 9px;">
                        <div class="progress-bar bg-danger"
                            style="width: {{ $totalCustomers ? ($disconnectedCustomers / $totalCustomers) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="card mt-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Tagihan Terbaru</span>

        <a href="{{ route('invoices.index') }}"
            class="btn btn-sm btn-outline-primary">
            Lihat Semua
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">
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
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->customer->name }}</td>
                    <td>{{ $invoice->billing_period->format('F Y') }}</td>
                    <td>Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
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
                    <td colspan="5" class="text-center text-muted py-4">
                        Belum ada data tagihan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const monthlyInvoices = @json($monthlyInvoices);

    const monthNames = [
        'Januari', 'Februari', 'Maret', 'April',
        'Mei', 'Juni', 'Juli', 'Agustus',
        'September', 'Oktober', 'November', 'Desember'
    ];

    const invoiceLabels = monthlyInvoices.map(item => {
        return monthNames[item.month - 1];
    });

    const invoiceValues = monthlyInvoices.map(item => {
        return Number(item.total);
    });

    new Chart(document.getElementById('invoiceChart'), {
        type: 'bar',
        data: {
            labels: invoiceLabels,
            datasets: [{
                label: 'Total Tagihan',
                data: invoiceValues,
                backgroundColor: '#2563eb',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
</script>
@endpush