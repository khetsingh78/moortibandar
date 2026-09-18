<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Admin</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ Auth::user()?->profile_url ?? URL::asset('admin/img/user.jpg') }}"
                    alt="" style="width: 40px; height: 40px;">
                {{-- URL::asset('admin/img/user.jpg') --}}
                <div
                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                </div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ Str::limit(Auth::user()?->name, 10, '..') ?? 'N/A' }}</h6>
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ route('dashboard') }}"
                class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i
                    class="fa fa-tachometer-alt me-2"></i>Dashboard</a>

            <a href="{{ route('products.index') }}"
                class="nav-item nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"><i
                    class="fab fa-product-hunt"></i>
                Products</a>

            <a href="{{ route('categories.index') }}"
                class="nav-item nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"><i
                    class="fa-solid fa-layer-group"></i>Categories</a>

            <a href="{{ route('coupons.index') }}"
                class="nav-item nav-link {{ request()->routeIs('coupons.*') ? 'active' : '' }}"><i
                    class="fa-solid fa-tag"></i>Coupon</a>

            {{-- <a href="{{ route('discounts.index') }}"
                class="nav-item nav-link {{ request()->routeIs('discounts.*') ? 'active' : '' }}"><i
                    class="fa-solid fa-tag"></i>Discount</a> --}}

            <a href="{{ route('orders.index') }}"
                class="nav-item nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"><i
                    class="fa-brands fa-first-order"></i>Orders</a>

            {{-- <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="far fa-file-alt me-2"></i>Order Management</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('orders.index') }}" class="dropdown-item">Orders</a>
                </div>
            </div> --}}

            <a href="widget.html" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Widgets</a>
            <a href="form.html" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Forms</a>
            <a href="table.html" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Tables</a>
            <a href="chart.html" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="far fa-file-alt me-2"></i>Pages</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="signin.html" class="dropdown-item">Sign In</a>
                    <a href="signup.html" class="dropdown-item">Sign Up</a>
                    <a href="404.html" class="dropdown-item">404 Error</a>
                    <a href="blank.html" class="dropdown-item">Blank Page</a>
                </div>
            </div>
        </div>
    </nav>
</div>
