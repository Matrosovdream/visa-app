@extends('admin.layouts.app')

@stack('scripts_bottom')

    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>

@endstack

@section('content')

        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!--begin::Col-->
            <div class="col-xl-4">
                <!--begin::Chart Widget 35-->
                <div class="card card-flush h-md-100">
                    <!--begin::Header-->
                    <div class="card-header pt-5 mb-6">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <!--begin::Statistics-->
                            <div class="d-flex align-items-center mb-2">
                                <!--begin::Currency-->
                                <span class="fs-3 fw-semibold text-gray-500 align-self-start me-1">$</span>
                                <!--end::Currency-->
                                <!--begin::Value-->
                                <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">3,274.94</span>
                                <!--end::Value-->
                                <!--begin::Label-->
                                <span class="badge badge-light-success fs-base">
                                    <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>9.2%</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Statistics-->
                            <!--begin::Description-->
                            <span class="fs-6 fw-semibold text-gray-500">Avg. Agent Earnings</span>
                            <!--end::Description-->
                        </h3>
                        <!--end::Title-->
                        <!--begin::Toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Menu-->
                            <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                data-kt-menu-overflow="true">
                                <i class="ki-duotone ki-dots-square fs-1 text-gray-500 me-n1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                            </button>
                            <!--begin::Menu 2-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu separator-->
                                <div class="separator mb-3 opacity-75"></div>
                                <!--end::Menu separator-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">New Ticket</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">New Customer</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                    data-kt-menu-placement="right-start">
                                    <!--begin::Menu item-->
                                    <a href="#" class="menu-link px-3">
                                        <span class="menu-title">New Group</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <!--end::Menu item-->
                                    <!--begin::Menu sub-->
                                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Admin Group</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Staff Group</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Member Group</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu sub-->
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">New Contact</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu separator-->
                                <div class="separator mt-3 opacity-75"></div>
                                <!--end::Menu separator-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <div class="menu-content px-3 py-3">
                                        <a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
                                    </div>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu 2-->
                            <!--end::Menu-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-0 px-0">
                        <!--begin::Nav-->
                        <ul class="nav d-flex justify-content-between mb-3 mx-9">
                            <!--begin::Item-->
                            <li class="nav-item mb-3">
                                <!--begin::Link-->
                                <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px active"
                                    data-bs-toggle="tab" id="kt_charts_widget_35_tab_1"
                                    href="#kt_charts_widget_35_tab_content_1">1d</a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="nav-item mb-3">
                                <!--begin::Link-->
                                <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px"
                                    data-bs-toggle="tab" id="kt_charts_widget_35_tab_2"
                                    href="#kt_charts_widget_35_tab_content_2">5d</a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="nav-item mb-3">
                                <!--begin::Link-->
                                <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px"
                                    data-bs-toggle="tab" id="kt_charts_widget_35_tab_3"
                                    href="#kt_charts_widget_35_tab_content_3">1m</a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="nav-item mb-3">
                                <!--begin::Link-->
                                <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px"
                                    data-bs-toggle="tab" id="kt_charts_widget_35_tab_4"
                                    href="#kt_charts_widget_35_tab_content_4">6m</a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="nav-item mb-3">
                                <!--begin::Link-->
                                <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px"
                                    data-bs-toggle="tab" id="kt_charts_widget_35_tab_5"
                                    href="#kt_charts_widget_35_tab_content_5">1y</a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Nav-->
                        <!--begin::Tab Content-->
                        <div class="tab-content mt-n6">
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade active show" id="kt_charts_widget_35_tab_content_1">
                                <!--begin::Chart-->
                                <div id="kt_charts_widget_35_chart_1" data-kt-chart-color="primary"
                                    class="min-h-auto h-200px ps-3 pe-6"></div>
                                <!--end::Chart-->
                                <!--begin::Table container-->
                                <div class="table-responsive mx-9 mt-n6">
                                    <!--begin::Table-->
                                    <table class="table align-middle gs-0 gy-4">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="min-w-100px"></th>
                                                <th class="min-w-100px text-end pe-0"></th>
                                                <th class="text-end min-w-50px"></th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-gray-600 fw-bold fs-6">2:30 PM</a>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$2,756.26</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="fw-bold fs-6 text-danger">-139.34</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-gray-600 fw-bold fs-6">3:10 PM</a>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$3,207.03</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="fw-bold fs-6 text-success">+576.24</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-gray-600 fw-bold fs-6">3:55 PM</a>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$3,274.94</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="fw-bold fs-6 text-success">+124.03</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table container-->
                            </div>
                            <!--end::Tap pane-->
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_charts_widget_35_tab_content_2">
                                <!--begin::Chart-->
                                <div id="kt_charts_widget_35_chart_2" data-kt-chart-color="primary"
                                    class="min-h-auto h-200px ps-3 pe-6"></div>
                                <!--end::Chart-->
                                <!--begin::Table container-->
                                <div class="table-responsive mx-9 mt-n6">
                                    <!--begin::Table-->
                                    <table class="table align-middle gs-0 gy-4">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="min-w-100px"></th>
                                                <th class="min-w-100px text-end pe-0"></th>
                                                <th class="text-end min-w-50px"></th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-gray-600 fw-bold fs-6">4:30 PM</a>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$2,345.45</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="fw-bold fs-6 text-success">+134.02</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-gray-600 fw-bold fs-6">11:35 AM</a>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$756.26</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="fw-bold fs-6 text-primary">-124.03</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-gray-600 fw-bold fs-6">3:30 PM</a>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$1,756.26</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="fw-bold fs-6 text-danger">+144.04</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table container-->
                            </div>
                            <!--end::Tap pane-->
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_charts_widget_35_tab_content_3">
                                <!--begin::Chart-->
                                <div id="kt_charts_widget_35_chart_3" data-kt-chart-color="primary"
                                    class="min-h-auto h-200px ps-3 pe-6"></div>
                                <!--end::Chart-->
                                <!--begin::Table container-->
                                <div class="table-responsive mx-9 mt-n6">
                                    <!--begin::Table-->
                                    <table class="table align-middle gs-0 gy-4">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="min-w-100px"></th>
                                                <th class="min-w-100px text-end pe-0"></th>
                                                <th class="text-end min-w-50px"></th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-gray-600 fw-bold fs-6">3:20 AM</a>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$3,756.26</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="fw-bold fs-6 text-primary">+185.03</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-gray-600 fw-bold fs-6">12:30 AM</a>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$2,756.26</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="fw-bold fs-6 text-danger">+124.03</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-gray-600 fw-bold fs-6">4:30 PM</a>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$756.26</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="fw-bold fs-6 text-success">-154.03</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table container-->
                            </div>
                            <!--end::Tap pane-->
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_charts_widget_35_tab_content_4">
                                <!--begin::Chart-->
                                <div id="kt_charts_widget_35_chart_4" data-kt-chart-color="primary"
                                    class="min-h-auto h-200px ps-3 pe-6"></div>
                                <!--end::Chart-->
                                <!--begin::Table container-->
                                <div class="table-responsive mx-9 mt-n6">
                                    <!--begin::Table-->
                                    <table class="table align-middle gs-0 gy-4">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="min-w-100px"></th>
                                                <th class="min-w-100px text-end pe-0"></th>
                                                <th class="text-end min-w-50px"></th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-gray-600 fw-bold fs-6">2:30 PM</a>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$2,756.26</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="fw-bold fs-6 text-warning">+124.03</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-gray-600 fw-bold fs-6">5:30 AM</a>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$1,756.26</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="fw-bold fs-6 text-info">+144.65</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-gray-600 fw-bold fs-6">4:30 PM</a>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$2,085.25</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="fw-bold fs-6 text-primary">+154.06</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table container-->
                            </div>
                            <!--end::Tap pane-->
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_charts_widget_35_tab_content_5">
                                <!--begin::Chart-->
                                <div id="kt_charts_widget_35_chart_5" data-kt-chart-color="primary"
                                    class="min-h-auto h-200px ps-3 pe-6"></div>
                                <!--end::Chart-->
                                <!--begin::Table container-->
                                <div class="table-responsive mx-9 mt-n6">
                                    <!--begin::Table-->
                                    <table class="table align-middle gs-0 gy-4">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="min-w-100px"></th>
                                                <th class="min-w-100px text-end pe-0"></th>
                                                <th class="text-end min-w-50px"></th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-gray-600 fw-bold fs-6">2:30 PM</a>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$2,045.04</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="fw-bold fs-6 text-warning">+114.03</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-gray-600 fw-bold fs-6">3:30 AM</a>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$756.26</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="fw-bold fs-6 text-primary">-124.03</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-gray-600 fw-bold fs-6">10:30 PM</a>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$1.756.26</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <span class="fw-bold fs-6 text-info">+165.86</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table container-->
                            </div>
                            <!--end::Tap pane-->
                        </div>
                        <!--end::Tab Content-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Chart Widget 35-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xl-8">
                <!--begin::Table widget 14-->
                <div class="card card-flush h-md-100">
                    <!--begin::Header-->
                    <div class="card-header pt-7">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">Projects Stats</span>
                            <span class="text-gray-500 mt-1 fw-semibold fs-6">Updated 37 minutes ago</span>
                        </h3>
                        <!--end::Title-->
                        <!--begin::Toolbar-->
                        <div class="card-toolbar">
                            <a href="apps/ecommerce/catalog/add-product.html" class="btn btn-sm btn-light">History</a>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-6">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                        <th class="p-0 pb-3 min-w-175px text-start">ITEM</th>
                                        <th class="p-0 pb-3 min-w-100px text-end">BUDGET</th>
                                        <th class="p-0 pb-3 min-w-100px text-end">PROGRESS</th>
                                        <th class="p-0 pb-3 min-w-175px text-end pe-12">STATUS</th>
                                        <th class="p-0 pb-3 w-125px text-end pe-7">CHART</th>
                                        <th class="p-0 pb-3 w-50px text-end">VIEW</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px me-3">
                                                    <img src="{{ asset('assets/admin/media/avatars/300-2.png') }}" class="" alt="" />
                                                </div>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <a href="#"
                                                        class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Mivy
                                                        App</a>
                                                    <span class="text-gray-500 fw-semibold d-block fs-7">Jane Cooper</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="text-gray-600 fw-bold fs-6">$32,400</span>
                                        </td>
                                        <td class="text-end pe-0">
                                            <!--begin::Label-->
                                            <span class="badge badge-light-success fs-base">
                                                <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>9.2%</span>
                                            <!--end::Label-->
                                        </td>
                                        <td class="text-end pe-12">
                                            <span class="badge py-3 px-4 fs-7 badge-light-primary">In Process</span>
                                        </td>
                                        <td class="text-end pe-0">
                                            <div id="kt_table_widget_14_chart_1" class="h-50px mt-n8 pe-7"
                                                data-kt-chart-color="success"></div>
                                        </td>
                                        <td class="text-end">
                                            <a href="#"
                                                class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                <i class="ki-duotone ki-black-right fs-2 text-gray-500"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end: Card Body-->
                </div>
                <!--end::Table widget 14-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->

@endsection