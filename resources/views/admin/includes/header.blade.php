<!--begin::Header-->
<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}"
    data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}"
    data-kt-sticky-animation="false">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
        id="kt_app_header_container">
        <!--begin::Sidebar mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
        <!--end::Sidebar mobile toggle-->
        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="index.html" class="d-lg-none">
                <img alt="Logo" src="assets/media/logos/default-small.svg" class="h-30px" />
            </a>
        </div>
        <!--end::Mobile logo-->
        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <!--begin::Menu wrapper-->
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
                data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                <!--begin::Menu-->
                <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0"
                    id="kt_app_header_menu" data-kt-menu="true">
                    <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu">
                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item here menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-title">
                                    <a href="/" class="">Home page</a>
                                </span>
                                <span class="menu-arrow d-lg-none"></span>
                            </span>
                            <!--end:Menu link-->
                        </div>
                    </div>
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Menu wrapper-->

            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">

                <!--begin::Theme mode-->
                <div class="app-navbar-item ms-1 ms-md-4">
                    <!--begin::Menu toggle-->
                    <a href="#"
                        class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
                        data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-night-day theme-light-show fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                            <span class="path6"></span>
                            <span class="path7"></span>
                            <span class="path8"></span>
                            <span class="path9"></span>
                            <span class="path10"></span>
                        </i>
                        <i class="ki-duotone ki-moon theme-dark-show fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </a>
                    <!--begin::Menu toggle-->
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                        data-kt-menu="true" data-kt-element="theme-mode-menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-night-day fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                        <span class="path7"></span>
                                        <span class="path8"></span>
                                        <span class="path9"></span>
                                        <span class="path10"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Light</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-moon fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Dark</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-screen fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">System</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Theme mode-->

                <!--begin::User menu-->
                <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-35px"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end">
                        <img src="{{ asset('assets/admin/media/avatars/300-2.png') }}" class="rounded-3" alt="user" />
                    </div>
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    <img alt="Logo" src="{{ asset('assets/admin/media/avatars/300-2.png') }}" />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">Robert Fox
                                        <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span>
                                    </div>
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">robert@kt.com</a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>

                        <div class="separator my-2"></div>

                        <div class="menu-item px-5">
                            <a href="account/overview.html" class="menu-link px-5">My Profile</a>
                        </div>

                        <div class="separator my-2"></div>

                        <!--begin::Menu item-->
                        <div class="menu-item px-5 my-1">
                            <a href="account/settings.html" class="menu-link px-5">Account Settings</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                            <a class="menu-link px-5"
                                href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Sign Out
                            </a>

                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::User menu-->

                <!--begin::Header menu toggle-->
                <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                    <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px"
                        id="kt_app_header_menu_toggle">
                        <i class="ki-duotone ki-element-4 fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <!--end::Header menu toggle-->

                <!--begin::Aside toggle-->
                <!--end::Header menu toggle-->
            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>
<!--end::Header-->












<!-- Header -->
<?php /*
<header
   class="header fixed top-0 z-10 left-0 right-0 flex items-stretch shrink-0 bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]"
   data-sticky="true" data-sticky-class="shadow-sm" data-sticky-name="header" id="header">
   <!-- Container -->
   <div class="container-fixed flex justify-between items-stretch lg:gap-4" id="header_container">
       <!-- Mobile Logo -->
       <div class="flex gap-1 lg:hidden items-center -ml-1">
           <a class="shrink-0" href="html/demo1.html">
               <img class="max-h-[25px] w-full" src="{{ asset('assets/admin/media/app/mini-logo.svg') }}" />
           </a>
           <div class="flex items-center">
               <button class="btn btn-icon btn-light btn-clear btn-sm" data-drawer-toggle="#sidebar">
                   <i class="ki-filled ki-menu">
                   </i>
               </button>
               <button class="btn btn-icon btn-light btn-clear btn-sm" data-drawer-toggle="#mega_menu_wrapper">
                   <i class="ki-filled ki-burger-menu-2">
                   </i>
               </button>
           </div>
       </div>
       <!-- End of Mobile Logo -->
       <!-- Mega Men -->
       <div class="flex items-stretch" id="mega_menu_container">
           <div class="flex items-stretch" data-reparent="true" data-reparent-mode="prepend|lg:prepend"
               data-reparent-target="body|lg:#mega_menu_container">
               <div class="hidden lg:flex lg:items-stretch" data-drawer="true"
                   data-drawer-class="drawer drawer-start fixed z-10 top-0 bottom-0 w-full mr-5 max-w-[250px] p-5 lg:p-0 overflow-auto"
                   data-drawer-enable="true|lg:false" id="mega_menu_wrapper">
                   <div class="menu flex-col lg:flex-row gap-5 lg:gap-7.5" data-menu="true" id="mega_menu">
                       <div class="menu-item active">
                           <a class="menu-link text-nowrap text-sm text-gray-800 font-medium menu-item-hover:text-primary menu-item-active:text-gray-900 menu-item-active:font-medium"
                               href="html/demo1.html">
                               <span class="menu-title text-nowrap">
                                   Home
                               </span>
                           </a>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <!-- End of Mega Men -->
       <!-- Topbar -->
       <div class="flex items-center gap-2 lg:gap-3.5">
           <button
               class="btn btn-icon btn-icon-lg size-9 rounded-full hover:bg-primary-light hover:text-primary text-gray-500"
               data-modal-toggle="#search_modal">
               <i class="ki-filled ki-magnifier">
               </i>
           </button>
           <div class="dropdown" data-dropdown="true" data-dropdown-offset="70px, 10px"
               data-dropdown-placement="bottom-end" data-dropdown-trigger="click|lg:click">
               <button
                   class="dropdown-toggle btn btn-icon btn-icon-lg relative cursor-pointer size-9 rounded-full hover:bg-primary-light hover:text-primary dropdown-open:bg-primary-light dropdown-open:text-primary text-gray-500">
                   <i class="ki-filled ki-notification-on">
                   </i>
                   <span
                       class="badge badge-dot badge-success size-[5px] absolute top-0.5 right-0.5 transform translate-y-1/2">
                   </span>
               </button>
               <div class="dropdown-content light:border-gray-300 w-full max-w-[460px]">
                   <div class="flex items-center justify-between gap-2.5 text-sm text-gray-900 font-semibold px-5 py-2.5 border-b border-b-gray-200"
                       id="notifications_header">
                       Notifications
                       <button class="btn btn-sm btn-icon btn-light btn-clear shrink-0" data-dropdown-dismiss="true">
                           <i class="ki-filled ki-cross">
                           </i>
                       </button>
                   </div>
                   <div class="tabs justify-between px-5 mb-2" data-tabs="true" id="notifications_tabs">
                       <div class="flex items-center gap-5">
                           <button class="tab active" data-tab-toggle="#notifications_tab_all">
                               All
                           </button>
                           <button class="tab relative" data-tab-toggle="#notifications_tab_inbox">
                               Inbox
                               <span
                                   class="badge badge-dot badge-success size-[5px] absolute top-2 right-0 transform translate-y-1/2 translate-x-full">
                               </span>
                           </button>
                           <button class="tab" data-tab-toggle="#notifications_tab_team">
                               Team
                           </button>
                           <button class="tab" data-tab-toggle="#notifications_tab_following">
                               Following
                           </button>
                       </div>
                   </div>
                   <div class="grow" id="notifications_tab_all">
                       <div class="flex flex-col">
                           <div class="scrollable-y-auto" data-scrollable="true" data-scrollable-dependencies="#header"
                               data-scrollable-max-height="auto" data-scrollable-offset="200px">
                               <div class="flex flex-col gap-5 pt-3 pb-4 divider-y divider-gray-200">
                                   <div class="flex grow gap-2.5 px-5">
                                       <div class="relative shrink-0 mt-0.5">
                                           <img alt="" class="rounded-full size-8"
                                               src="{{ asset('assets/admin/media/app/mini-logo.svg') }}assets/media/avatars/300-4.png" />
                                           <span
                                               class="size-1.5 badge badge-circle badge-success absolute top-7 end-0.5 ring-1 ring-light transform -translate-y-1/2">
                                           </span>
                                       </div>
                                       <div class="flex flex-col gap-3.5">
                                           <div class="flex flex-col gap-1">
                                               <div class="text-2sm font-medium">
                                                   <a class="hover:text-primary-active text-gray-900 font-semibold"
                                                       href="#">
                                                       Joe Lincoln
                                                   </a>
                                                   <span class="text-gray-700">
                                                       mentioned you in
                                                   </span>
                                                   <a class="hover:text-primary-active text-primary" href="#">
                                                       Latest Trends
                                                   </a>
                                                   <span class="text-gray-700">
                                                       topic
                                                   </span>
                                               </div>
                                               <span class="flex items-center text-2xs font-medium text-gray-500">
                                                   18 mins ago
                                                   <span class="badge badge-circle bg-gray-500 size-1 mx-1.5">
                                                   </span>
                                                   Web Design 2024
                                               </span>
                                           </div>
                                           <div
                                               class="card shadow-none flex flex-col gap-2.5 p-3.5 rounded-lg bg-light-active">
                                               <div class="text-2sm font-semibold text-gray-600 mb-px">
                                                   <a class="hover:text-primary-active text-gray-900 font-semibold"
                                                       href="#">
                                                       @Cody
                                                   </a>
                                                   <span class="text-gray-700 font-medium">
                                                       For an expert opinion, check out what Mike has to say on this
                                                       topic!
                                                   </span>
                                               </div>
                                               <label class="input input-sm">
                                                   <input placeholder="Reply" type="text" value="">
                                                   <button class="btn btn-icon">
                                                       <i class="ki-filled ki-picture">
                                                       </i>
                                                   </button>
                                                   </input>
                                               </label>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="border-b border-b-gray-200">
                                   </div>
                               </div>
                           </div>
                           <div class="border-b border-b-gray-200">
                           </div>
                           <div class="grid grid-cols-2 p-5 gap-2.5" id="notifications_all_footer">
                               <button class="btn btn-sm btn-light justify-center">
                                   Archive all
                               </button>
                               <button class="btn btn-sm btn-light justify-center">
                                   Mark all as read
                               </button>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <div class="menu" data-menu="true">
               <div class="menu-item" data-menu-item-offset="20px, 10px" data-menu-item-placement="bottom-end"
                   data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:click">
                   <div class="menu-toggle btn btn-icon rounded-full">
                       <img alt="" class="size-9 rounded-full border-2 border-success shrink-0"
                           src="{{ asset('assets/admin/media/avatars/300-2.png') }}">
                       </img>
                   </div>
                   <div class="menu-dropdown menu-default light:border-gray-300 w-screen max-w-[250px]">
                       <div class="flex items-center justify-between px-5 py-1.5 gap-1.5">
                           <div class="flex items-center gap-2">
                               <img alt="" class="size-9 rounded-full border-2 border-success"
                                   src="{{ asset('assets/admin/media/avatars/300-2.png') }}">
                               <div class="flex flex-col gap-1.5">
                                   <span class="text-sm text-gray-800 font-semibold leading-none">
                                       Cody Fisher
                                   </span>
                                   <a class="text-xs text-gray-600 hover:text-primary font-medium leading-none"
                                       href="html/demo1/account/home/get-started.html">
                                       c.fisher@gmail.com
                                   </a>
                               </div>
                               </img>
                           </div>
                           <span class="badge badge-xs badge-primary badge-outline">
                               Pro
                           </span>
                       </div>
                       <div class="menu-separator">
                       </div>
                       <div class="flex flex-col">
                           <div class="menu-item">
                               <a class="menu-link" href="html/demo1/public-profile/profiles/default.html">
                                   <span class="menu-icon">
                                       <i class="ki-filled ki-badge">
                                       </i>
                                   </span>
                                   <span class="menu-title">
                                       Public Profile
                                   </span>
                               </a>
                           </div>
  
                           <div class="menu-item" data-menu-item-offset="-10px, 0"
                               data-menu-item-placement="left-start" data-menu-item-toggle="dropdown"
                               data-menu-item-trigger="click|lg:hover">
                               <div class="menu-link">
                                   <span class="menu-icon">
                                       <i class="ki-filled ki-icon">
                                       </i>
                                   </span>
                                   <span class="menu-title">
                                       Language
                                   </span>
                                   <div
                                       class="flex items-center gap-1.5 rounded-md border border-gray-300 text-gray-600 p-1.5 text-2xs font-medium shrink-0">
                                       English
                                       <img alt="" class="inline-block size-3.5 rounded-full"
                                           src="{{ asset('assets/admin/media/flags/united-states.svg') }}" />
                                   </div>
                               </div>
                               <div class="menu-dropdown menu-default light:border-gray-300 w-full max-w-[170px]">
                                   <div class="menu-item active">
                                       <a class="menu-link h-10" href="#">
                                           <span class="menu-icon">
                                               <img alt="" class="inline-block size-4 rounded-full"
                                                   src="{{ asset('assets/admin/media/flags/united-states.svg') }}" />
                                           </span>
                                           <span class="menu-title">
                                               English
                                           </span>
                                           <span class="menu-badge">
                                               <i class="ki-solid ki-check-circle text-success text-base">
                                               </i>
                                           </span>
                                       </a>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="menu-separator">
                       </div>
                       <div class="flex flex-col">
                           <div class="menu-item px-4 py-1.5">

                               <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                   @csrf
                               </form>

                               <a class="btn btn-sm btn-light justify-center"
                                   href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                   Log out
                               </a>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <!-- End of Topbar -->
   </div>
   <!-- End of Container -->
</header>
<!-- End of Header -->