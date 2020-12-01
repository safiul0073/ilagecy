<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                @can('isAdmin')

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('dashboard') }}"
                        aria-expanded="false">
                        <i class="mdi mdi-av-timer"></i>
                        <span class="hide-menu">Dashboard </span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('users.index') }}"
                        aria-expanded="false">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu">Users </span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('suppliers.index') }}"
                        aria-expanded="false">
                        <i class="mdi mdi-account-multiple-outline"></i>
                        <span class="hide-menu">Suppliers </span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('products.index') }}"
                        aria-expanded="false">
                        <i class="mdi mdi-archive"></i>
                        <span class="hide-menu">Products </span>
                    </a>
                </li>

                @endcan
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('product.list') }}"
                        aria-expanded="false">
                        <i class="mdi mdi-clipboard-text"></i>
                        <span class="hide-menu">Product Lists</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('leads.list') }}"
                        aria-expanded="false">
                        <i class="mdi mdi-polymer"></i>
                        <span class="hide-menu">Leads</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
