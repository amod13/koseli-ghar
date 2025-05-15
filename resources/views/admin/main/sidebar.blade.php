      <!-- ========== App Menu Sidebar ========== -->
      <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{ asset('admin/assets/images/logo.png') }}" alt="" height="40">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('admin/assets/images/logo.png') }}" alt="" height="40">
                </span>
            </a>
            <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{{ asset('admin/assets/images/logo.png') }}" alt="" height="24">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('admin/assets/images/logo.png') }}" alt="" height="24">
                </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>

        <div id="scrollbar">
            <div class="container-fluid">

                <div id="two-column-menu">
                </div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                    @if (auth()->user()->hasPermission('DashboardController', 'AdminLayout'))
                        <li class="nav-item">
                            @if (auth()->user()->hasPermission('DashboardController', 'AdminLayout'))
                            <a href="{{ route('admin.dashboard') }}" class="nav-link menu-link">
                                <i class="bi bi-speedometer2"></i>
                                <span data-key="t-dashboard">Dashboard</span>
                            </a>
                            @endif
                        </li>
                    @endif

                    @if (auth()->user()->hasPermission('RoleController', 'index') ||
                         auth()->user()->hasPermission('PermissionController', 'index') ||
                         auth()->user()->hasPermission('UserController', 'index'))
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarProducts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProducts">
                                <i class="bi bi-box-seam"></i>
                                <span data-key="t-products">Roles and Permissions</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarProducts">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        @if (auth()->user()->hasPermission('UserController', 'index'))
                                        <a href="{{ route('user.index') }}" class="nav-link" data-key="t-overview">Users</a>
                                        @endif
                                    </li>
                                    <li class="nav-item">
                                        @if (auth()->user()->hasPermission('RoleController', 'index'))
                                        <a href="{{ route('role.index') }}" class="nav-link" data-key="t-list-view">Roles</a>
                                        @endif
                                    </li>
                                    <li class="nav-item">
                                        @if (auth()->user()->hasPermission('PermissionController', 'index'))
                                        <a href="{{ route('permission.index') }}" class="nav-link" data-key="t-grid-view">Permissions</a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermission('MenuController', 'index'))
                    <li class="nav-item">
                        @if (auth()->user()->hasPermission('MenuController', 'index'))
                        <a href="{{ route('menu.index') }}" class="nav-link menu-link"> <i class="bi bi-list"></i>
                            <span data-key="t-menus-list">Menus</span> </a>
                        @endif
                    </li>
                    @endif


                    @if (auth()->user()->hasPermission('ProductController', 'index') ||
                    auth()->user()->hasPermission('CategoryController', 'index') ||
                    auth()->user()->hasPermission('BrandController', 'index'))
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#ProductManage" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="ProductManage">
                                <i class="bi bi-box-seam"></i> <span data-key="t-products">Products</span>
                            </a>
                            <div class="collapse menu-dropdown" id="ProductManage">
                                <ul class="nav nav-sm flex-column">

                                    <li class="nav-item">
                                        @if (auth()->user()->hasPermission('CategoryController', 'index'))
                                        <a href="{{ route('category.index') }}" class="nav-link" data-key="t-categories">Categories</a>
                                        @endif

                                    </li>

                                    <li class="nav-item">
                                        @if (auth()->user()->hasPermission('BrandController', 'index'))
                                        <a href="{{ route('brand.index') }}" class="nav-link" data-key="t-brands">Brands</a>
                                        @endif
                                    </li>

                                    <li class="nav-item">
                                        @if (auth()->user()->hasPermission('ProductController', 'index'))
                                        <a href="{{ route('product.index') }}" class="nav-link" data-key="t-products">List of product</a>
                                        @endif
                                    </li>

                                </ul>
                            </div>
                        </li>
                        @endif

                        @if (auth()->user()->hasPermission('OrderManagementController', 'index'))
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#OrderManage" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="OrderManage">
                                <i class="bi bi-cart-check"></i>
                                <span data-key="t-products">Order Management</span>
                            </a>
                            <div class="collapse menu-dropdown" id="OrderManage">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        @if (auth()->user()->hasPermission('OrderManagementController', 'index'))
                                        <a href="{{ route('order.manage.index') }}" class="nav-link" data-key="t-overview">Orders</a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endif

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#chatManage" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="chatManage">
                            <i class="bi bi-person-circle"></i> <span data-key="t-accounts">Chat Management</span>
                        </a>
                        <div class="collapse menu-dropdown" id="chatManage">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('chat.index') }}" class="nav-link" data-key="t-my-account">Chat</a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarAccounts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAccounts">
                            <i class="bi bi-person-circle"></i> <span data-key="t-accounts">Accounts</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarAccounts">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    @if (auth()->user()->hasPermission('UserDetailController', 'index'))
                                    <a href="{{ route('user.detail.index') }}" class="nav-link" data-key="t-my-account">My Account</a>
                                    @endif
                                </li>

                                <li class="nav-item">
                                    @if (auth()->user()->hasPermission('SettingController', 'index'))
                                    <a href="{{ route('setting.index') }}" class="nav-link" data-key="t-settings">Settings</a>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>

            </div>
            <!-- Sidebar -->
        </div>

        <div class="sidebar-background"></div>
    </div>
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>
