<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-bs-theme="light">

    <head>
        
        @include('user.includes.metas')

        @stack('styles_top')
        @stack('scripts_top')

        <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" rel="stylesheet"/>

        <!-- Scripts -->
        @foreach([
            '/assets/admin/plugins/custom/fullcalendar/fullcalendar.bundle.css',
            '/assets/admin/plugins/custom/datatables/datatables.bundle.css',
            '/assets/admin/plugins/global/plugins.bundle.css',
            '/assets/admin/css/style.bundle.css',
        ] as $style)
            <link href="{{ asset($style) }}" rel="stylesheet"/>
        @endforeach

    </head>

    <body id="kt_app_body" data-kt-app-layout="light-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">


        <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
            <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

                <!-- Header -->
                @include('admin.includes.header')
                <!-- End of Header -->

                <!--begin::Wrapper-->
                <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

                    <!--begin::Sidebar-->
                    @include('admin.includes.sidebar')
                    <!--end::Sidebar-->

                    <!--begin::Main-->
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">

                        <!--begin::Content wrapper-->
                        <div class="d-flex flex-column flex-column-fluid">

                            <!--begin::Toolbar-->
							<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                                @include('admin.includes.toolbar')
                            </div>
                            <!--end::Toolbar-->

                            <!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid">
                                <!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-fluid">
                                    @yield('content')
                                </div>
                                <!--end::Content container-->
                            </div>
                            
                        </div>

                        <!--begin::Footer-->
						<div id="kt_app_footer" class="app-footer">
                            @include('admin.includes.footer')
                        </div>
                        <!--end::Footer-->

                    </div>
                    <!--end:::Main-->

                </div>
                <!--end::Wrapper-->
            
            </div>
        </div>

        <!--begin::Drawers-->
        <?php /*
        @include('admin.includes.drawers')
        */ ?>
        <!--end::Drawers-->

        <!-- Modals -->
        @include('admin.includes.modals')
        <!-- End of Modals -->

        <!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-duotone ki-arrow-up">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>
		<!--end::Scrolltop-->

        @stack('styles_bottom')
        @stack('scripts_bottom')

        <!-- jQuery, bootrsap, popper -->
        <script src="{{ asset('/assets/admin/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('/assets/admin/js/scripts.bundle.js') }}"></script>
        <script src="{{ asset('/assets/admin/plugins/custom/datatables/datatables.bundle.js') }}"></script>

        <!-- Global Scripts -->
        @vite([
            //'resources/assets/admin/plugins/global/plugins.bundle.js',
            //'resources/assets/admin/js/scripts.bundle.js',
        ])

        <!-- Page Scripts -->
        @foreach([
            '/assets/admin/plugins/custom/fullcalendar/fullcalendar.bundle.js',
            //'resources/assets/admin/plugins/custom/datatables/datatables.bundle.js',
            '/assets/admin/js/widgets.bundle.js',
            '/assets/admin/js/custom/widgets.js',
            //'resources/assets/admin/js/custom/apps/chat/chat.js',
            //'resources/assets/admin/js/custom/utilities/modals/upgrade-plan.js',
            //'resources/assets/admin/js/custom/utilities/modals/create-app.js',
            //'resources/assets/admin/js/custom/utilities/modals/new-target.js',
            //'resources/assets/admin/js/custom/utilities/modals/users-search.js',    
        ] as $script)
            <script src="{{ asset($script) }}"></script>
        @endforeach

    </body>

</html>
