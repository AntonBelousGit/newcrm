@php
    $user_type = Auth::user()->user_type;
@endphp
<!--begin::Aside-->
<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">

    <!--begin::Brand-->
    <div class="brand flex-column-auto" id="kt_brand">

        <!--begin::Logo-->
        <a href="{{ route('admin.index') }}" class="brand-logo">

            <img src="{{ asset('assets/img/logo.png') }}" style="max-height: 50px;">

        </a>

        <!--end::Logo-->
    </div>

    <!--end::Brand-->

    <!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">

        <!--begin::Menu Container-->
        <div id="kt_aside_menu" class="my-4 aside-menu" data-menu-vertical="1" data-menu-scroll="1"
             data-menu-dropdown-timeout="500">

            <!--begin::Menu Nav-->
            <ul class="menu-nav">
                <li class="menu-item" aria-haspopup="true">
                    <a href="{{ route('admin.index') }}" class="menu-link">
                        <i class="menu-icon flaticon-home"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                @canany(['SuperUser','Manager','OPS','Agent','Driver','Client'], Auth::user())
                    @if(count(\File::files(base_path('resources/views/backend/inc/addons/'))) > 0)
                        <li class="menu-section">
                            <h4 class="menu-text">Addons</h4>
                            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                        </li>

                        @foreach(\File::files(base_path('resources/views/backend/inc/addons/')) as $path)
                            @include('backend.inc.addons.'.str_replace('.blade','',pathinfo($path)['filename']))
                        @endforeach

                    @endif
                @endcanany

                @canany(['SuperUser','Manager','Security Officer'], Auth::user())
                    <li class="menu-section">
                        <h4 class="menu-text">Administration</h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>


                    <li class="menu-item menu-item-submenu  " aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon flaticon-users"></i>
                            <span class="menu-text">
                                @can('SuperUser',Auth::user())
                                    Users
                                @else
                                    Settings
                                @endcan
                            </span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item " aria-haspopup="true">
                                    <a href="{{route('admin.users.create')}}" class="menu-link">
                                        <i class="menu-bullet menu-icon flaticon2-plus" style="font-size: 10px;"></i>
                                        <span class="menu-text">Add User</span>
                                    </a>
                                </li>
                                @cannot('SuperUser',Auth::user())
                                <li class="menu-item " aria-haspopup="true">
                                    <a href="{{route('admin.user.edit-client')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Edit Profile</span>
                                    </a>
                                </li>
                                @endcannot
                                <li class="menu-item " aria-haspopup="true">
                                    <a href="{{route('admin.users.index')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">All Users</span>

                                    </a>
                                </li>
                                <li class="menu-item " aria-haspopup="true">
                                    <a href="{{route('admin.driver.index')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Drivers</span>

                                    </a>
                                </li>
                                <li class="menu-item " aria-haspopup="true">
                                    <a href="{{route('admin.agent.index')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Agents</span>

                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="menu-item menu-item-submenu  " aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon flaticon-home"></i>
                            <span class="menu-text">
                               Company
                            </span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item " aria-haspopup="true">
                                    <a href="{{route('admin.company.index')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">All Companies</span>

                                    </a>
                                </li>
                                <li class="menu-item " aria-haspopup="true">
                                    <a href="{{route('admin.company.create')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Add Company</span>

                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcanany
                @canany(['Client','Agent','Driver','OPS'], Auth::user())
                    <li class="menu-section">
                        <h4 class="menu-text">Administration</h4>
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    <li class="menu-item menu-item-submenu  " aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon flaticon-users"></i>
                            <span class="menu-text">Settings</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item " aria-haspopup="true">
                                    <a href="{{route('admin.user.edit-client')}}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Edit Profile</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcanany

            </ul>

            <!--end::Menu Nav-->
        </div>

        <!--end::Menu Container-->
    </div>

    <!--end::Aside Menu-->
</div>
<!--end::Aside-->
