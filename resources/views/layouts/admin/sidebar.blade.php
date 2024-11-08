<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/dashboard" class="app-brand-link">
            {{-- <span class="app-brand-logo demo">
                SPK
            </span> --}}
            <span class="text-center menu-text fw-bolder fs-4 ms-2 mt-1">Diagnosa Dini Penyakit Jantung</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">

        {{-- Main --}}
        {{-- <li class="menu-header small text-uppercase">
            <span class="menu-header-text text-secondary">Main</span>
        </li> --}}
        <!-- Dashboard -->
        <li class="menu-header small text-muted">
            <span class="menu-header-text text-uppercase">Dashboard</span>
        </li>
        <li class="menu-item {{ $title === 'dashboard' ? 'active' : '' }}">
            <a href="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <li class="menu-header small text-muted">
            <span class="menu-header-text text-uppercase">Master Data</span>
        </li>

        <li class="menu-item {{ $title === 'Penyakit' ? 'active' : '' }}">
            <a href="{{ route('penyakit.index') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-virus'></i>
                <div>Penyakit</div>
            </a>
        </li>
        <li class="menu-item {{ $title === 'Gejala' ? 'active' : '' }}">
            <a href="{{ route('gejala.index') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-first-aid'></i>
                <div>Gejala</div>
            </a>
        </li>
        @can('admin')
        <li class="menu-item {{ $title === 'User' ? 'active' : '' }}">
            <a href="{{ route('user.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>Manajemen user</div>
            </a>
        </li>
        @endcan

        <li class="menu-header small text-muted">
            <span class="menu-header-text text-uppercase">Perhitungan</span>
        </li>
        <li class="menu-item {{ $title === 'Rule' ? 'active' : '' }}">
            <a href="" class="menu-link">
                <i class='menu-icon tf-icons bx bx-cog'></i>
                <div>Dempster Rule</div>
            </a>
        </li>
        
    </ul>
</aside>
