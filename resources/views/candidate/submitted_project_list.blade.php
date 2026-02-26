<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="flexilecode" />

    <title>Turain || Dashboard</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/daterangepicker.min.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme.min.css') }}" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Remove blur from body & content */
        body.modal-open,
        body.modal-open .container,
        body.modal-open .container-fluid,
        body.modal-open .content,
        body.modal-open .page-content {
            filter: none !important;
            opacity: 1 !important;
        }

        /* Kill backdrop completely */
        .modal-backdrop {
            display: none !important;
        }

        /* Chat popup position */
        .modal-dialog-bottom {
            position: fixed;
            bottom: 90px;
            right: 30px;
            margin: 0;
        }

        /* Keep popup on top */
        .modal {
            z-index: 2000 !important;
        }

        .modal-title {
            color: white;
        }
    </style>
</head>

<body>
    @include('layouts.candidate.sidebar')

    @include('layouts.candidate.header')


    <!--! ================================================================ !-->
    <!--! [Start] Main Content !-->
    <!--! ================================================================ !-->
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Project</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('hr.dashboard') }}"">Home</a></li>
                        <li class=" breadcrumb-item">Submitted Project</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="javascript:void(0)" class="page-header-right-close-toggle">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Back</span>
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">

                            <div class="dropdown">

                            </div>



                        </div>
                    </div>
                    <div class="d-md-none d-flex align-items-center">
                        <a href="javascript:void(0)" class="page-header-right-open-toggle">
                            <i class="feather-align-right fs-20"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <div class="card shadow-sm">
                                        <div class="card-body p-0">
                                            <div class="table-responsive">


                                                <table class="table table-hover align-middle mb-0" id="customerList">
                                                    <thead class="bg-light text-uppercase text-muted small">
                                                        <tr>


                                                            <th>Project</th>
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                            <th>Submited Date</th>
                                                            <th>Project Link</th>
                                                            <th>Project Note</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <div id="projectDetails" class="border rounded p-3 mt-3"
                                                            style="display:none; background:#f9f9f9; position:relative;">

                                                            <!-- Close Button -->
                                                            <button type="button" id="closeProjectDetails"
                                                                class="btn btn-sm btn-outline-danger"
                                                                style="position:absolute; top:8px; right:8px;">
                                                                ✕
                                                            </button>

                                                            <h6 class="mb-2">Project Description</h6>
                                                            <div id="projectDescText"></div>
                                                        </div>


                                                        @forelse ($data as $assign)
                                                            <tr class="shadow-sm rounded mb-2">




                                                                <!-- Project Name -->
                                                                <td>
                                                                    <span
                                                                        class="badge rounded-pill bg-primary mb-1 px-3 py-2">{{ $assign->project }}</span>
                                                                </td>



                                                                <!-- Start Date -->
                                                                <td>
                                                                    <span
                                                                        class="text-secondary">{{ \Carbon\Carbon::parse($assign->start_date)->timezone('Asia/Kolkata')->format('d M Y') }}</span>
                                                                </td>

                                                                <!-- End Date -->
                                                                <td>
                                                                    <span
                                                                        class="text-secondary">{{ \Carbon\Carbon::parse($assign->end_date)->timezone('Asia/Kolkata')->format('d M Y') }}</span>
                                                                </td>

                                                                <td>
                                                                    <span
                                                                        class="text-secondary">{{ \Carbon\Carbon::parse($assign->submission)->timezone('Asia/Kolkata')->format('d M Y') }}</span>
                                                                </td>


                                                                <td>
                                                                    <a href="{{ $assign->project_link }}"
                                                                        target="_blank">
                                                                        {{ \Illuminate\Support\Str::limit($assign->project_link, 20) }}
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    {{ \Illuminate\Support\Str::limit($assign->notes, 10) }}
                                                                </td>
                                                                @php

                                                                    $submitted_by_candidate = $assign->project_link;
                                                                    $submitted_by_mentor = $assign->submitted_by_mentor;
                                                                    $submitted_by_hr = $assign->submitted_by_hr;
                                                                @endphp
                                                                <td>
                                                                    <div class="submission-status">
                                                                        @if ($submitted_by_hr)
                                                                            <!-- HR submitted: show certificate download -->
                                                                            <span class="badge bg-success">Submitted by
                                                                                HR</span>
                                                                            <a href=""
                                                                                class="btn btn-primary btn-sm">
                                                                                <i class="bi bi-download"></i> Download
                                                                                Certificate
                                                                            </a>
                                                                        @elseif($submitted_by_mentor)
                                                                            <!-- Mentor submitted -->
                                                                            <span class="badge bg-info">Submitted by
                                                                                Mentor</span>
                                                                        @elseif($submitted_by_candidate)
                                                                            <!-- Candidate submitted -->
                                                                            <span
                                                                                class="badge bg-warning text-dark">Submitted
                                                                                by You</span>
                                                                        @else
                                                                            <!-- Nothing submitted yet -->
                                                                            <span class="badge bg-secondary">Waiting
                                                                                for
                                                                                Higher Authorization</span>
                                                                        @endif
                                                                    </div>
                                                                </td>


                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="6" class="text-center text-muted">No
                                                                    projects assigned</td>
                                                            </tr>
                                                        @endforelse

                                                    </tbody>

                                                </table>


                                                <!-- END main content -->
                                            </div>


                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ Main Content ] end -->
            </div>
            <!-- [ Footer ] start -->
            <footer class="footer">
                <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
                    <span>Copyright ©</span>
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                </p>
                <p><span>By: <a target="_blank" href="https://wrapbootstrap.com/user/theme_ocean"
                            target="_blank">theme_ocean</a></span> • <span>Distributed by: <a target="_blank"
                            href="https://themewagon.com" target="_blank">ThemeWagon</a></span></p>
                <div class="d-flex align-items-center gap-4">
                    <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Help</a>
                    <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Terms</a>
                    <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Privacy</a>
                </div>
            </footer>
            <!-- [ Footer ] end -->
    </main>
    <!--! ================================================================ !-->
    <!--! [End] Main Content !-->
    <!--! ================================================================ !-->
    <!--! ================================================================ !-->
    <!--! BEGIN: Theme Customizer !-->
    <!--! ================================================================ !-->
    <div class="theme-customizer">
        <div class="customizer-handle">
            <a href="javascript:void(0);" class="cutomizer-open-trigger bg-primary">
                <i class="feather-settings"></i>
            </a>
        </div>
        <div class="customizer-sidebar-wrapper">
            <div
                class="customizer-sidebar-header px-4 ht-80 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Theme Settings</h5>
                <a href="javascript:void(0);" class="cutomizer-close-trigger d-flex">
                    <i class="feather-x"></i>
                </a>
            </div>
            <div class="customizer-sidebar-body position-relative p-4" data-scrollbar-target="#psScrollbarInit">
                <!--! BEGIN: [Navigation] !-->
                <div class="position-relative px-3 pb-3 pt-4 mt-3 mb-5 border border-gray-2 theme-options-set">
                    <label
                        class="py-1 px-2 fs-8 fw-bold text-uppercase text-muted text-spacing-2 bg-white border border-gray-2 position-absolute rounded-2 options-label"
                        style="top: -12px">Navigation</label>
                    <div class="row g-2 theme-options-items app-navigation" id="appNavigationList">
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-navigation-light" name="app-navigation"
                                value="1" data-app-navigation="app-navigation-light" checked />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-navigation-light">Light</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-navigation-dark" name="app-navigation"
                                value="2" data-app-navigation="app-navigation-dark" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-navigation-dark">Dark</label>
                        </div>
                    </div>
                </div>
                <!--! END: [Navigation] !-->
                <!--! BEGIN: [Header] !-->
                <div class="position-relative px-3 pb-3 pt-4 mt-3 mb-5 border border-gray-2 theme-options-set mt-5">
                    <label
                        class="py-1 px-2 fs-8 fw-bold text-uppercase text-muted text-spacing-2 bg-white border border-gray-2 position-absolute rounded-2 options-label"
                        style="top: -12px">Header</label>
                    <div class="row g-2 theme-options-items app-header" id="appHeaderList">
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-header-light" name="app-header"
                                value="1" data-app-header="app-header-light" checked />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-header-light">Light</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-header-dark" name="app-header"
                                value="2" data-app-header="app-header-dark" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-header-dark">Dark</label>
                        </div>
                    </div>
                </div>
                <!--! END: [Header] !-->
                <!--! BEGIN: [Skins] !-->
                <div class="position-relative px-3 pb-3 pt-4 mt-3 mb-5 border border-gray-2 theme-options-set">
                    <label
                        class="py-1 px-2 fs-8 fw-bold text-uppercase text-muted text-spacing-2 bg-white border border-gray-2 position-absolute rounded-2 options-label"
                        style="top: -12px">Skins</label>
                    <div class="row g-2 theme-options-items app-skin" id="appSkinList">
                        <div class="col-6 text-center position-relative single-option light-button active">
                            <input type="radio" class="btn-check" id="app-skin-light" name="app-skin"
                                value="1" data-app-skin="app-skin-light" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-skin-light">Light</label>
                        </div>
                        <div class="col-6 text-center position-relative single-option dark-button">
                            <input type="radio" class="btn-check" id="app-skin-dark" name="app-skin"
                                value="2" data-app-skin="app-skin-dark" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-skin-dark">Dark</label>
                        </div>
                    </div>
                </div>
                <!--! END: [Skins] !-->
                <!--! BEGIN: [Typography] !-->
                <div class="position-relative px-3 pb-3 pt-4 mt-3 mb-0 border border-gray-2 theme-options-set">
                    <label
                        class="py-1 px-2 fs-8 fw-bold text-uppercase text-muted text-spacing-2 bg-white border border-gray-2 position-absolute rounded-2 options-label"
                        style="top: -12px">Typography</label>
                    <div class="row g-2 theme-options-items font-family" id="fontFamilyList">
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-lato" name="font-family"
                                value="1" data-font-family="app-font-family-lato" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-lato">Lato</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-rubik" name="font-family"
                                value="2" data-font-family="app-font-family-rubik" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-rubik">Rubik</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-inter" name="font-family"
                                value="3" data-font-family="app-font-family-inter" checked />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-inter">Inter</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-cinzel" name="font-family"
                                value="4" data-font-family="app-font-family-cinzel" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-cinzel">Cinzel</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-nunito" name="font-family"
                                value="6" data-font-family="app-font-family-nunito" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-nunito">Nunito</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-roboto" name="font-family"
                                value="7" data-font-family="app-font-family-roboto" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-roboto">Roboto</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-ubuntu" name="font-family"
                                value="8" data-font-family="app-font-family-ubuntu" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-ubuntu">Ubuntu</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-poppins" name="font-family"
                                value="9" data-font-family="app-font-family-poppins" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-poppins">Poppins</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-raleway" name="font-family"
                                value="10" data-font-family="app-font-family-raleway" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-raleway">Raleway</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-system-ui"
                                name="font-family" value="11" data-font-family="app-font-family-system-ui" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-system-ui">System UI</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-noto-sans"
                                name="font-family" value="12" data-font-family="app-font-family-noto-sans" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-noto-sans">Noto Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-fira-sans"
                                name="font-family" value="13" data-font-family="app-font-family-fira-sans" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-fira-sans">Fira Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-work-sans"
                                name="font-family" value="14" data-font-family="app-font-family-work-sans" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-work-sans">Work Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-open-sans"
                                name="font-family" value="15" data-font-family="app-font-family-open-sans" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-open-sans">Open Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-maven-pro"
                                name="font-family" value="16" data-font-family="app-font-family-maven-pro" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-maven-pro">Maven Pro</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-quicksand"
                                name="font-family" value="17" data-font-family="app-font-family-quicksand" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-quicksand">Quicksand</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-montserrat"
                                name="font-family" value="18" data-font-family="app-font-family-montserrat" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-montserrat">Montserrat</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-josefin-sans"
                                name="font-family" value="19" data-font-family="app-font-family-josefin-sans" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-josefin-sans">Josefin Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-ibm-plex-sans"
                                name="font-family" value="20" data-font-family="app-font-family-ibm-plex-sans" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-ibm-plex-sans">IBM Plex Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-source-sans-pro"
                                name="font-family" value="5"
                                data-font-family="app-font-family-source-sans-pro" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-source-sans-pro">Source Sans Pro</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-montserrat-alt"
                                name="font-family" value="21"
                                data-font-family="app-font-family-montserrat-alt" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-montserrat-alt">Montserrat Alt</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-roboto-slab"
                                name="font-family" value="22" data-font-family="app-font-family-roboto-slab" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-roboto-slab">Roboto Slab</label>
                        </div>
                    </div>
                </div>
                <!--! END: [Typography] !-->
            </div>
            <div class="customizer-sidebar-footer px-4 ht-60 border-top d-flex align-items-center gap-2">
                <div class="flex-fill w-50">
                    <a href="javascript:void(0);" class="btn btn-danger"
                        data-style="reset-all-common-style">Reset</a>
                </div>
                <div class="flex-fill w-50">
                    <a href="https://www.themewagon.com/themes/Duralux-admin" target="_blank"
                        class="btn btn-primary">Download</a>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="noteModal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-bottom">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title">📝 Today Work</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="assignId">
                    <textarea id="noteText" class="form-control" rows="4" placeholder="Write something..."></textarea>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary btn-sm" id="saveNote">Save</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="githubNoteModal" tabindex="-1"> <!-- renamed -->
        <div class="modal-dialog modal-sm modal-dialog-bottom">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title"> Project Link</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="githubAssignId"> <!-- renamed -->
                    <textarea id="githubNoteText" class="form-control" rows="4" placeholder="Write something..."></textarea> <!-- renamed -->
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary btn-sm" id="githubSaveNote">Save</button> <!-- renamed -->
                </div>

            </div>
        </div>
    </div>

    <!-- Upload Assignment Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header" style="background: blue;">
                    <h5 class="modal-title text-white" id="uploadModalLabel">Submit Assignment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <input type="hidden" id="uploadAssignId">

                    <!-- Project Link -->
                    <div class="mb-3">
                        <label class="form-label">Project Link</label>
                        <input type="url" class="form-control" id="projectLink"
                            placeholder="https://github.com/username/project" required>
                    </div>

                    <!-- Notes -->
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" id="projectNote" rows="4"
                            placeholder="Write short explanation or instructions"></textarea>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" id="uploadSaveBtn" class="btn btn-success">
                        Submit
                    </button>
                </div>

            </div>
        </div>
    </div>


    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>

    <script src="{{ asset('assets/vendors/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/apexcharts.min.js') }}"></script>
    <script src="assets/vendors/js/circle-progress.min.js"></script>

    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard-init.min.js') }}"></script>

    <script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script>
        $(document).ready(function() {

            $('.toggle-desc').on('click', function() {

                let desc = $(this).data('desc');

                $('#projectDescText').text(desc);
                $('#projectDetails').slideDown();

                // Optional: scroll to the div
                $('html, body').animate({
                    scrollTop: $('#projectDetails').offset().top - 100
                }, 300);

            });

        });
    </script>
    <script>
        $(document).ready(function() {

            $('#closeProjectDetails').on('click', function() {
                $('#projectDetails').slideUp();
            });

        });
    </script>
    <script>
        document.getElementById('noteModal')
            .addEventListener('show.bs.modal', function(event) {

                let button = event.relatedTarget;
                let assignId = button.getAttribute('data-id');

                document.getElementById('assignId').value = assignId;
            });
    </script>
    <script>
        document.getElementById('saveNote').addEventListener('click', function() {

            let assignId = document.getElementById('assignId').value;
            let note = document.getElementById('noteText').value;

            if (!note.trim()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Required',
                    text: 'Please write note'
                });
                return;
            }

            fetch("{{ route('assignment.note.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        assign_id: assignId,
                        note: note
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Clear textarea
                        document.getElementById('noteText').value = '';

                        // Close modal
                        bootstrap.Modal.getInstance(
                            document.getElementById('noteModal')
                        ).hide();
                    }
                })
                .catch(err => console.error(err));
        });
    </script>
    <script>
        var githubModal = document.getElementById('githubNoteModal');
        githubModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var assignId = button.getAttribute('data-id');
            document.getElementById('githubAssignId').value = assignId;
        });
    </script>

    <script>
        document.getElementById('githubSaveNote').addEventListener('click', function() {
            let assignId = document.getElementById('githubAssignId').value;
            let note = document.getElementById('githubNoteText').value;

            if (!note.trim()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Required',
                    text: 'Please write note'
                });
                return;
            }

            fetch("{{ route('assignment.github.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        assign_id: assignId,
                        note: note
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        document.getElementById('githubNoteText').value = '';

                        // Close modal
                        bootstrap.Modal.getInstance(
                            document.getElementById('githubNoteModal')
                        ).hide();
                    }
                })
                .catch(err => console.error(err));
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Set assign id when upload button clicked
            document.querySelectorAll('.upload-btn').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('uploadAssignId').value = this.dataset.id;
                    document.getElementById('projectLink').value = '';
                    document.getElementById('projectNote').value = '';
                });
            });

            // Submit assignment
            document.getElementById('uploadSaveBtn').addEventListener('click', function() {

                let assignId = document.getElementById('uploadAssignId').value;
                let projectLink = document.getElementById('projectLink').value.trim();
                let projectNote = document.getElementById('projectNote').value.trim();

                if (!projectLink) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Required',
                        text: 'Please enter project link'
                    });
                    return;
                }

                fetch("{{ route('assignment.submit.post', ':id') }}".replace(':id', assignId), {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            assign_id: assignId,
                            project_link: projectLink,
                            note: projectNote
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Submitted',
                                text: data.message || 'Assignment submitted successfully!',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            bootstrap.Modal.getInstance(
                                document.getElementById('uploadModal')
                            ).hide();
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong!'
                        });
                    });
            });

        });
    </script>

</body>

</html>
