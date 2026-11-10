<nav class="top-navbar">

    <div class="d-flex align-items-center gap-3">

        <button class="btn btn-light sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>

        <div>
            <h6 class="mb-0">@yield('page-title', 'ISP Management')</h6>
            <small class="text-muted">Customer Management System</small>
        </div>

    </div>

    <div class="d-flex align-items-center gap-3">

        <span class="text-muted small">
            <i class="bi bi-calendar3 me-1"></i>
            {{ now()->translatedFormat('d F Y') }}
        </span>

        <div class="navbar-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>

    </div>

</nav>