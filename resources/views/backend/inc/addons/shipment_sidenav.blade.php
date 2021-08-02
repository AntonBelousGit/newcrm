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
            @canany(['SuperUser','Manager','OPS'], Auth::user())
                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.orders.create')}}" class="menu-link">
                        <i class="menu-bullet menu-icon flaticon2-plus" style="font-size: 10px;"></i>
                        <span class="menu-text">Add Shipment</span>
                    </a>
                </li>
            @endcan
            @canany(['SuperUser','Manager','OPS','Agent'], Auth::user())
                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.orders.index')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">All Shipments</span>

                    </a>
                </li>
                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.orders.new_order')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">New order</span>

                    </a>
                </li>
                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.orders.in_processing')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">In processing</span>

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

        </ul>
    </div>
</li>
