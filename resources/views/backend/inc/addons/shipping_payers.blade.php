@canany(['SuperUser','Manager','Security Officer'], Auth::user())

    <li class="menu-item menu-item-submenu  " aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:;" class="menu-link menu-toggle">
            <i class="menu-icon fas fa-address-card"></i>
            <span class="menu-text">Shipping payers</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">Shipping payers</span>
                                </span>
                </li>
                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.payer.create')}}" class="menu-link">
                        <i class="menu-bullet menu-icon flaticon2-plus" style="font-size: 10px;"></i>
                        <span class="menu-text">Add payer</span>
                    </a>
                </li>

                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.payer.index')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">All payers</span>

                    </a>
                </li>
                <li class="menu-item " aria-haspopup="true">
                    <a href="{{route('admin.show-client')}}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text">Client List</span>

                    </a>
                </li>
            </ul>
        </div>
    </li>
@endcanany
