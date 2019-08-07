<!-- =============================================== -->

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ $user->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">Trang chủ</li>
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-home"></i> <span>Trang chủ</span>
                    <span class="pull-right-container">
                </span>
                </a>
            </li>
            {{--<li class="header">Shop</li>--}}
            {{--<li class="treeview @if(request()->segment(2) == 'products' || request()->segment(2) == 'attributes' || request()->segment(2) == 'brands') active @endif">--}}
            {{--<a href="#">--}}
            {{--<i class="fa fa-gift"></i> <span>Sản phẩm</span>--}}
            {{--<span class="pull-right-container">--}}
            {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
            {{--</a>--}}
            {{--<ul class="treeview-menu">--}}
            {{--@if($user->hasPermission('view-product'))--}}
            {{--<li><a href="{{ route('admin.products.index') }}"><i class="fa fa-circle-o"></i> Danh sách</a>--}}
            {{--</li>@endif--}}
            {{--@if($user->hasPermission('create-product'))--}}
            {{--<li><a href="{{ route('admin.products.create') }}"><i class="fa fa-plus"></i> Tạo mới</a>--}}
            {{--</li>@endif--}}
            {{--<li class="@if(request()->segment(2) == 'attributes') active @endif">--}}
            {{--<a href="#">--}}
            {{--<i class="fa fa-gear"></i> <span>Attributes</span>--}}
            {{--<span class="pull-right-container">--}}
            {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
            {{--</a>--}}
            {{--<ul class="treeview-menu">--}}
            {{--<li><a href="{{ route('admin.attributes.index') }}"><i class="fa fa-circle-o"></i> List attributes</a></li>--}}
            {{--<li><a href="{{ route('admin.attributes.create') }}"><i class="fa fa-plus"></i> Create attribute</a></li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="@if(request()->segment(2) == 'brands') active @endif">--}}
            {{--<a href="#">--}}
            {{--<i class="fa fa-tag"></i> <span>Brands</span>--}}
            {{--<span class="pull-right-container">--}}
            {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
            {{--</a>--}}
            {{--<ul class="treeview-menu">--}}
            {{--<li><a href="{{ route('admin.brands.index') }}"><i class="fa fa-circle-o"></i> List brands</a></li>--}}
            {{--<li><a href="{{ route('admin.brands.create') }}"><i class="fa fa-plus"></i> Create brand</a></li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="treeview @if(request()->segment(2) == 'categories') active @endif">--}}
            {{--<a href="#">--}}
            {{--<i class="fa fa-folder"></i> <span>Danh mục sản phẩm</span>--}}
            {{--<span class="pull-right-container">--}}
            {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
            {{--</a>--}}
            {{--<ul class="treeview-menu">--}}
            {{--<li><a href="{{ route('admin.categories.index') }}"><i class="fa fa-circle-o"></i> Danh sách</a>--}}
            {{--</li>--}}
            {{--<li><a href="{{ route('admin.categories.create') }}"><i class="fa fa-plus"></i> Tạo mới</a></li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="treeview @if(request()->segment(2) == 'customers' || request()->segment(2) == 'addresses') active @endif">--}}
            {{--<a href="#">--}}
            {{--<i class="fa fa-user"></i> <span>Khách hàng</span>--}}
            {{--<span class="pull-right-container">--}}
            {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
            {{--</a>--}}
            {{--<ul class="treeview-menu">--}}
            {{--<li><a href="{{ route('admin.customers.index') }}"><i class="fa fa-circle-o"></i> Khách hàng</a>--}}
            {{--</li>--}}
            {{--<li><a href="{{ route('admin.customers.create') }}"><i class="fa fa-plus"></i> Tạo mới</a></li>--}}
            {{--<li class="@if(request()->segment(2) == 'addresses') active @endif">--}}
            {{--<a href="#"><i class="fa fa-map-marker"></i> Addresses--}}
            {{--<span class="pull-right-container">--}}
            {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
            {{--</a>--}}
            {{--<ul class="treeview-menu">--}}
            {{--<li><a href="{{ route('admin.addresses.index') }}"><i class="fa fa-circle-o"></i> List addresses</a></li>--}}
            {{--<li><a href="{{ route('admin.addresses.create') }}"><i class="fa fa-plus"></i> Create address</a></li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="header">Đơn hàng</li>--}}
            {{--<li class="treeview @if(request()->segment(2) == 'orders') active @endif">--}}
            {{--<a href="#">--}}
            {{--<i class="fa fa-money"></i> <span>Đơn hàng</span>--}}
            {{--<span class="pull-right-container">--}}
            {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
            {{--</a>--}}
            {{--<ul class="treeview-menu">--}}
            {{--<li><a href="{{ route('admin.orders.index') }}"><i class="fa fa-circle-o"></i> Danh sách</a></li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="treeview @if(request()->segment(2) == 'order-statuses') active @endif">--}}
            {{--<a href="#">--}}
            {{--<i class="fa fa-anchor"></i> <span>Loại tình trạng đơn hàng</span>--}}
            {{--<span class="pull-right-container">--}}
            {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
            {{--</a>--}}
            {{--<ul class="treeview-menu">--}}
            {{--<li><a href="{{ route('admin.order-statuses.index') }}"><i class="fa fa-circle-o"></i> Danh sách</a>--}}
            {{--</li>--}}
            {{--<li><a href="{{ route('admin.order-statuses.create') }}"><i class="fa fa-plus"></i> Tạo mới</a></li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="header">DELIVERY</li>--}}
            {{--<li class="treeview @if(request()->segment(2) == 'couriers') active @endif">--}}
            {{--<a href="#">--}}
            {{--<i class="fa fa-truck"></i> <span>Couriers</span>--}}
            {{--<span class="pull-right-container">--}}
            {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
            {{--</a>--}}
            {{--<ul class="treeview-menu">--}}
            {{--<li><a href="{{ route('admin.couriers.index') }}"><i class="fa fa-circle-o"></i> List couriers</a></li>--}}
            {{--<li><a href="{{ route('admin.couriers.create') }}"><i class="fa fa-plus"></i> Create courier</a></li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            <li class="header">Dashboard</li>
            @if($user->hasRole('admin|superadmin'))

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-star"></i> <span>Campaipn</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.campaigns.index') }}"><i class="fa fa-circle-o"></i> Danh sách</a>
                        </li>
                        <li><a href="{{ route('admin.campaign.create') }}"><i class="fa fa-plus"></i> Tạo mới</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-star"></i> <span>Chi nhánh</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.branch.index') }}"><i class="fa fa-circle-o"></i> Danh sách</a>
                        </li>
                        <li><a href="{{ route('admin.branch.create') }}"><i class="fa fa-plus"></i> Tạo mới</a></li>
                    </ul>
                </li>
            @endif
            <li class="header">Cấu hình</li>
            @if($user->hasRole('admin|superadmin'))
                <li class="treeview @if(request()->segment(2) == 'employees' || request()->segment(2) == 'roles' || request()->segment(2) == 'permissions') active @endif">
                    <a href="#">
                        <i class="fa fa-star"></i> <span>Nhân viên</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.employees.index') }}"><i class="fa fa-circle-o"></i> Danh sách</a>
                        </li>
                        <li><a href="{{ route('admin.employees.create') }}"><i class="fa fa-plus"></i> Tạo mới</a></li>
                        <li class="@if(request()->segment(2) == 'roles') active @endif">
                            <a href="#">
                                <i class="fa fa-star-o"></i> <span>Vai trò</span>
                                <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('admin.roles.index') }}"><i class="fa fa-circle-o"></i> Danh sách</a>
                                </li>
                                <li><a href="{{ route('admin.roles.create') }}"><i class="fa fa-plus"></i> Tạo mới</a>
                                </li>
                            </ul>
                        </li>
                        <li class="@if(request()->segment(2) == 'permissions') active @endif">
                            <a href="#">
                                <i class="fa fa-star-o"></i> <span>Phân quyền</span>
                                <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('admin.permissions.index') }}"><i class="fa fa-circle-o"></i> Danh
                                        sách</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- =============================================== -->