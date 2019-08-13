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
            <li class="header">Dashboard</li>
            @if($user->hasRole('admin|superadmin'))

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-star"></i> <span>Chiến dịch</span>
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
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-star"></i> <span>Dịch vụ</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.services.index') }}"><i class="fa fa-circle-o"></i> Danh sách</a>
                        </li>
                        <li><a href="{{ route('admin.services.create') }}"><i class="fa fa-plus"></i> Tạo mới</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-star"></i> <span>Đối tác(Agency)</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.agencys.index') }}"><i class="fa fa-circle-o"></i> Danh sách</a>
                        </li>
                        <li><a href="{{ route('admin.agencys.create') }}"><i class="fa fa-plus"></i> Tạo mới</a></li>
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