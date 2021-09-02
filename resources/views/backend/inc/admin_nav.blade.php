
<!--begin::Header-->
<div id="kt_header" class="header header-fixed  @if (!trim($__env->yieldContent('subheader'))) has_shadow @endif">

    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">

        <!--begin::Topbar-->
        <div class="topbar">

            <!--begin::Notifications-->

            <!--end::Notifications-->

            <!--begin::Languages-->
            <div class="dropdown">
                @php
                    if(Session::has('locale')){
                        $locale = Session::get('locale', Config::get('app.locale'));
                    }
                    else{
                        $locale = env('DEFAULT_LANGUAGE');
                    }
                @endphp

                <!--begin::Toggle-->


                <!--end::Toggle-->

                <!--begin::Dropdown-->
                <div
                    class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right" id="lang-change">

                    <!--begin::Nav-->
                    <ul class="navi navi-hover py-4">

                    </ul>

                    <!--end::Nav-->
                </div>

                <!--end::Dropdown-->
            </div>

            <!--end::Languages-->

            <!--begin::User-->
            <div class="dropdown">

                <!--begin::Toggle-->
                <div class="topbar-item" data-toggle="dropdown" data-offset="0px,0px">
                    <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2">
                        <span
                            class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                        <span
                            class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{Auth::user()->name}}</span>
                        <div class="symbol symbol-30 mr-3">
                            <img src="{{ asset(Auth::user()->avatar_original) }}"onerror="this.onerror=null;this.src='{{ asset('assets/img/avatar-place.png') }}';" alt="">
                        </div>
                    </div>
                </div>

                <!--end::Toggle-->

                <!--begin::Dropdown-->
                <div
                    class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg p-0">

                    <!--begin::Header-->
                    <div class="d-flex align-items-center justify-content-between flex-wrap p-8 bg-dark-o-5 bgi-no-repeat rounded-top">
                        <div class="d-flex align-items-center mr-2">

                            <!--begin::Symbol-->
                            <div class="symbol symbol-30 mr-3">
                                <img src="{{ asset(Auth::user()->avatar_original) }}"onerror="this.onerror=null;this.src='{{ asset('assets/img/avatar-place.png') }}';" alt="">
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Text-->
                            <div class="text-dark m-0 flex-grow-1 mr-3 font-size-h5">{{Auth::user()->name}}</div>

                            <!--end::Text-->
                        </div>
                    </div>

                    <!--end::Header-->

                    <!--begin::Nav-->
                    <div class="navi navi-spacer-x-0 pt-5">

                        <!--begin::Item-->
                        <a href=""
                            class="navi-item px-8">
                            <div class="navi-link">
                                <div class="navi-icon mr-2">
                                    <i class="flaticon2-calendar-3 text-success"></i>
                                </div>
                                <div class="navi-text">
                                    <div class="font-weight-bold">Profile</div>
                                    <div class="text-muted">Account settings and more</div>
                                </div>
                            </div>
                        </a>

                        <!--end::Item-->

                        <!--begin::Footer-->
                        <div class="navi-separator mt-3"></div>
                        <div class="navi-footer px-8 py-5">
                            <a href="{{ route('logout')}}"
                                class="btn btn-light-primary font-weight-bold">Logout</a>
                        </div>

                        <!--end::Footer-->
                    </div>

                    <!--end::Nav-->
                </div>

                <!--end::Dropdown-->
            </div>

            <!--end::User-->
        </div>

        <!--end::Topbar-->
    </div>

    <!--end::Container-->
</div>
