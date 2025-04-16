<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
        </div>
        <div class="sidebar-brand-text mx-3">DonasiWoy!</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->

    {{-- request is berguna untuk mengecek apakah url yang sedang dibuka sama dengan url yang dituju --}}
    {{-- jika sama maka akan menambahkan class active --}}
    {{-- jika tidak maka tidak akan menambahkan class active --}}
    <li class="nav-item @if (request()->is('admin')) active @endif">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item @if (request()->is('admin/campaigns*')) active @endif">
        <a class="nav-link" href="{{ route('admin.campaigns.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Campaign</span></a>
    </li>

    <li class="nav-item @if (request()->is('admin/donations*')) active @endif">
        <a class="nav-link" href="{{ route('admin.donations.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Donasi</span></a>
    </li>

    <li class="nav-item @if (request()->is('admin/news*')) active @endif">
        <a class="nav-link" href="{{ route('admin.news.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>News</span></a>
    </li>
</ul>
<!-- End of Sidebar -->
