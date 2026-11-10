<nav class="topbar">

    {{-- Bagian kiri --}}
    <div class="d-flex align-items-center gap-3">

        <button type="button" class="btn sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>

        <div>
            <h6 class="topbar-title mb-0">
                @yield('page-title', 'ISP Management')
            </h6>
            <small class="text-muted">
                Customer Management System
            </small>
        </div>

    </div>

    {{-- Bagian kanan --}}
    <div class="topbar-user">

        <span class="text-muted small d-none d-sm-inline">
            <i class="bi bi-calendar3 me-1"></i>
            {{ now()->translatedFormat('d F Y') }}
        </span>

        <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>

        <div class="d-none d-md-block">
            <div class="fw-semibold">
                {{ auth()->user()->name }}
            </div>
            <small class="text-muted text-capitalize">
                {{ auth()->user()->role }}
            </small>
        </div>

    </div>

</nav>