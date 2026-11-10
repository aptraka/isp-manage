<div class="mb-3">
    <label class="form-label">Nama Pelanggan</label>

    <input type="text"
        name="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $customer->name ?? '') }}"
        required>

    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nomor Telepon</label>

    <input type="text"
        name="phone"
        class="form-control @error('phone') is-invalid @enderror"
        value="{{ old('phone', $customer->phone ?? '') }}"
        placeholder="Contoh: 081234567890"
        required>

    @error('phone')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Alamat</label>

    <textarea name="address"
        rows="3"
        class="form-control @error('address') is-invalid @enderror"
        required>{{ old('address', $customer->address ?? '') }}</textarea>

    @error('address')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Paket Internet</label>

    <select name="package_id" class="form-select" required>
        <option value="">Pilih Paket Internet</option>

        @foreach($packages as $package)
        <option value="{{ $package->id }}"
            @selected(old('package_id', $customer->package_id ?? '') == $package->id)>

            {{ $package->name }} - {{ $package->speed }}
            (Rp {{ number_format($package->price, 0, ',', '.') }})

        </option>
        @endforeach
    </select>

    @error('package_id')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Status Pelanggan</label>

    <select name="status" class="form-select" required>
        <option value="aktif"
            @selected(old('status', $customer->status ?? 'aktif') === 'aktif')>
            Aktif
        </option>

        <option value="suspend"
            @selected(old('status', $customer->status ?? '') === 'suspend')>
            Suspend
        </option>

        <option value="terputus"
            @selected(old('status', $customer->status ?? '') === 'terputus')>
            Terputus
        </option>
    </select>

    @error('status')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>