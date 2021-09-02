<li class="menu-item menu-item-submenu  " aria-haspopup="true" data-menu-toggle="hover">
    <a href="javascript:;" class="menu-link menu-toggle">
        <i class="menu-icon fas fa-box-open"></i>
        <span class="menu-text">Shipments</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">
            @canany(['SuperUser','Manager','OPS','Agent','Driver'], Auth::user())
                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">Shipments</span>
                                </span>
                </li>
            @endcan
            @canany(['SuperUser','Manager','OPS','Client'], Auth::user())
                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.orders.create')}}" class="menu-link">
                        <i class="menu-bullet menu-icon flaticon2-plus" style="font-size: 10px;"></i>
                        <span class="menu-text">Add Shipment</span>
                    </a>
                </li>
            @endcan
            @canany(['SuperUser','Manager','OPS','Agent','Client'], Auth::user())
                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.orders.index')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">All Shipments</span>

                    </a>
                </li>
            @endcan
            @canany(['SuperUser','Manager','OPS','Agent'], Auth::user())
                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.orders.new_order')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">New order</span>

                    </a>
                </li>
            @endcan
            @canany(['SuperUser','Manager','OPS','Agent','Driver'], Auth::user())
                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.orders.in_work')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">Accepted in work</span>

                    </a>
                </li>
            @endcan
            @canany(['SuperUser','Manager','OPS','Agent'], Auth::user())
                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.orders.delivered')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">Delivered</span>

                    </a>
                </li>
            @endcan
            @canany(['SuperUser','Manager','OPS','Client'], Auth::user())
                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.orders.return_job')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">Return Job</span>

                    </a>
                </li>
            @endcan
            @canany(['SuperUser','Manager','OPS','Client'], Auth::user())
                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.orders.archives')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">Archives</span>

                    </a>
                </li>
            @endcan
            @canany(['SuperUser','Manager','OPS'], Auth::user())
                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.orders.create-return-job')}}" class="menu-link">
                        <i class="menu-bullet menu-icon flaticon2-plus" style="font-size: 10px;"></i>
                        <span class="menu-text">Add return job</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</li>
{{--<li class="menu-item menu-item-submenu  " aria-haspopup="true" data-menu-toggle="hover">--}}
{{--    <a href="javascript:;" class="menu-link menu-toggle">--}}
{{--        <i class="menu-icon fas fa-shipping-fast"></i>--}}
{{--        <span class="menu-text">Tracker</span>--}}
{{--        <i class="menu-arrow"></i>--}}
{{--    </a>--}}
{{--    <div class="menu-submenu">--}}
{{--        <i class="menu-arrow"></i>--}}
{{--        <ul class="menu-subnav">--}}
{{--            @canany(['SuperUser','Manager','OPS','Agent','Driver'], Auth::user())--}}
{{--                <li class="menu-item menu-item-parent" aria-haspopup="true">--}}
{{--                                <span class="menu-link">--}}
{{--                                    <span class="menu-text">Shipments</span>--}}
{{--                                </span>--}}
{{--                </li>--}}
{{--            @endcan--}}
{{--            @canany(['SuperUser','Manager','OPS'], Auth::user())--}}
{{--                <li class="menu-item " aria-haspopup="true">--}}
{{--                    <a href="{{route('admin.tracker.create')}}" class="menu-link">--}}
{{--                        <i class="menu-bullet menu-icon flaticon2-plus" style="font-size: 10px;"></i>--}}
{{--                        <span class="menu-text">Add Tracker</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endcan--}}
{{--            @canany(['SuperUser','Manager','OPS','Agent'], Auth::user())--}}
{{--                <li class="menu-item " aria-haspopup="true">--}}
{{--                    <a href="{{route('admin.tracker.index')}}" class="menu-link">--}}
{{--                        <i class="menu-bullet menu-bullet-dot">--}}
{{--                            <span></span>--}}
{{--                        </i>--}}
{{--                        <span class="menu-text">All Tracker</span>--}}

{{--                    </a>--}}
{{--                </li>--}}
{{--            @endcan--}}
{{--       </ul>--}}
{{--    </div>--}}
{{--</li>--}}
