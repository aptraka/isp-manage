<aside class="sidebar" id="sidebar">

    {{-- BRAND --}}
    <div class="sidebar-brand">

        <div class="brand-icon">
            <i class="bi bi-wifi"></i>
        </div>

        <div class="brand-info">
            <h5>ISP Manager</h5>
            <small>Customer Management</small>
        </div>

    </div>

    {{-- MENU --}}
    <div class="sidebar-menu">

        <div class="menu-label">MENU UTAMA</div>

        @if(auth()->user()->isAdmin())
        <a href="{{ route('dashboard') }}"
            class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>
        @endif

        <a href="{{ route('customers.index') }}"
            class="menu-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span>Pelanggan</span>
        </a>

        <a href="{{ route('invoices.index') }}"
            class="menu-item {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>
            <span>Tagihan</span>
        </a>

        @if(auth()->user()->isAdmin())

        <div class="menu-label mt-4">PENGATURAN</div>

        <a href="{{ route('users.index') }}"
            class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-person-gear"></i>
            <span>Manajemen User</span>
        </a>

        @endif

    </div>

    {{-- FOOTER --}}
    <div class="sidebar-footer">

        <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>

        <div class="user-info">
            <strong>{{ auth()->user()->name }}</strong>
            <small>{{ ucfirst(auth()->user()->role) }}</small>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="btn-logout" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </form>

    </div>

</aside>