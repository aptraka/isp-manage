@extends('layouts.app')

@section('title', 'Buat Tagihan')
@section('page-title', 'Buat Tagihan')

@section('content')

<div class="page-header">
    <div>
        <h4>Buat Tagihan</h4>
        <p>Buat tagihan baru untuk pelanggan aktif.</p>
    </div>

    <a href="{{ route('invoices.index') }}" class="btn btn-light">
        Kembali
    </a>
</div>

<div class="card">

    <div class="card-header">
        Form Tagihan
    </div>

    <div class="card-body">

        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Pelanggan</label>

                <select name="customer_id"
                    class="form-select @error('customer_id') is-invalid @enderror"
                    id="customerSelect"
                    required>

                    <option value="">Pilih Pelanggan</option>

                    @foreach($customers as $customer)
                    <option value="{{ $customer->id }}"
                        data-price="{{ $customer->package_price }}"
                        @selected(old('customer_id')==$customer->id)>

                        {{ $customer->name }} -
                        {{ $customer->phone }}

                    </option>
                    @endforeach

                </select>

                @error('customer_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Periode Tagihan</label>

                <input type="date"
                    name="billing_period"
                    class="form-control @error('billing_period') is-invalid @enderror"
                    value="{{ old('billing_period', now()->startOfMonth()->format('Y-m-d')) }}"
                    required>

                @error('billing_period')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <small class="text-muted">
                    Sistem akan menggunakan bulan dan tahun dari tanggal yang dipilih.
                </small>
            </div>

            <div class="mb-3">
                <label class="form-label">Nominal Tagihan</label>

                <input type="text"
                    id="customerPrice"
                    class="form-control"
                    value="Pilih pelanggan terlebih dahulu"
                    readonly>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i>
                Simpan Tagihan
            </button>

        </form>

    </div>
</div>

@endsection

@push('scripts')
<script>
    $('#customerSelect').on('change', function() {
        const price = $(this).find(':selected').data('price');

        if (price) {
            $('#customerPrice').val(
                'Rp ' + new Intl.NumberFormat('id-ID').format(price)
            );
        } else {
            $('#customerPrice').val('Pilih pelanggan terlebih dahulu');
        }
    });

    $('#customerSelect').trigger('change');
</script>
@endpush