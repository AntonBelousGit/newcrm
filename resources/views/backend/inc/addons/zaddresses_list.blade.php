@canany(['SuperUser','Manager','Security Officer','Client','OPS'], Auth::user())

    <li class="menu-item menu-item-submenu  " aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:;" class="menu-link menu-toggle">
            <i class="menu-icon fas fa-address-book"></i>
            <span class="menu-text">Addresses List</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">Addresses List</span>
                                </span>
                </li>
                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.addresses-list.index')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">All</span>

                    </a>
                </li>
            </ul>
        </div>
    </li>
@endcanany
