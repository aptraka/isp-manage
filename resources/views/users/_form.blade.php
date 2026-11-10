<div class="mb-3">
    <label class="form-label">Nama Lengkap</label>

    <input type="text"
        name="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $user->name ?? '') }}"
        required>

    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Email</label>

    <input type="email"
        name="email"
        class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email', $user->email ?? '') }}"
        required>

    @error('email')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Role</label>

    <select name="role" class="form-select" required>
        <option value="">Pilih Role</option>

        <option value="admin"
            @selected(old('role', $user->role ?? '') === 'admin')>
            Admin
        </option>

        <option value="staff"
            @selected(old('role', $user->role ?? '') === 'staff')>
            Staff
        </option>
    </select>

    @error('role')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">
        Password
        @isset($user)
        <small class="text-muted">(Kosongkan jika tidak diubah)</small>
        @endisset
    </label>

    <input type="password"
        name="password"
        class="form-control @error('password') is-invalid @enderror"
        @empty($user) required @endempty>

    @error('password')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Konfirmasi Password</label>

    <input type="password"
        name="password_confirmation"
        class="form-control"
        @empty($user) required @endempty>
</div>