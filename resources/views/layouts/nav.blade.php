<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="ps-4">
            <img src="/img/logo-menu.png" class="" height="40" alt="logo icon" />
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ auth()->user()->userable_type == 'App\Models\Customer' ? url('/dashboard') : url('/') }}">
                <div class="parent-icon"><i class='bx bx-home'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        @if (auth()->user()->userable_type == 'App\Models\Customer')
            @include('layouts.menu.customer')
        @else
            @include('layouts.menu.admin')
        @endif
    </ul>
    <!--end navigation-->
</div>