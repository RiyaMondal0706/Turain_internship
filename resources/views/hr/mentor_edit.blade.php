<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="theme_ocean">

    <title>Turain || Mentor Edit</title>


    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/select2-theme.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme.min.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .datepicker {
            z-index: 9999 !important;
        }
    </style>

</head>

<body>
    @include('layouts.hr.sidebar')

    @include('layouts.hr.header')


    <!--! ================================================================ !-->
    <!--! [Start] Main Content !-->
    <!--! ================================================================ !-->
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Intern</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('hr.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Mentor Edit</li>
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

                        <div class="card border-top-0">
                            <div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3">
                            </div>
                            <form id="mentorForm" action="{{ route('mentor.update', $mentor->id) }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="tab-content">

                                    <div class="tab-pane fade show active" id="profileTab" role="tabpanel">
                                        <div class="card-body personal-info">

                                            <div class="mb-4 d-flex align-items-center justify-content-between">
                                                <h5 class="fw-bold mb-0 me-4">
                                                    <span class="d-block mb-2">Personal Information:</span>
                                                    <span
                                                        class="fs-12 fw-normal text-muted text-truncate-1-line">Following
                                                        information is publicly displayed, be careful! </span>
                                                </h5>
                                                <a href="javascript:void(0);" class="btn btn-sm btn-light-brand">Add
                                                    New</a>
                                            </div>
                                            <div class="row mb-4 align-items-center">
                                                <div class="col-lg-4">
                                                    <label class="fw-semibold">Profile Image:</label>
                                                </div>

                                                <div class="col-lg-8">
                                                    <div class="mb-4 mb-md-0 d-flex gap-4 your-brand">

                                                        <div
                                                            class="wd-100 ht-100 position-relative overflow-hidden border border-gray-2 rounded">

                                                            <!-- Preview Image -->
                                                            <img id="avatarPreview"
                                                                src="{{ asset('assets/images/mentor/' . $mentor->image) }}"
                                                                class="upload-pic img-fluid rounded h-100 w-100"
                                                                alt="Avatar">

                                                            <!-- Overlay -->
                                                            <div class="position-absolute start-50 top-50 translate-middle h-100 w-100 hstack align-items-center justify-content-center c-pointer upload-button"
                                                                onclick="document.getElementById('avatarInput').click()">
                                                                <i class="feather feather-camera"></i>
                                                            </div>

                                                            <!-- File Input -->
                                                            <input id="avatarInput" class="file-upload d-none"
                                                                type="file" name="avatar"
                                                                accept="image/png, image/jpeg, image/jpg"
                                                                onchange="previewAvatar(this)">
                                                        </div>

                                                        <div class="d-flex flex-column gap-1">
                                                            <div class="fs-11 text-gray-500 mt-2"># Upload your profile
                                                            </div>
                                                            <div class="fs-11 text-gray-500"># Avatar size 150x150
                                                            </div>
                                                            <div class="fs-11 text-gray-500"># Max upload size 2MB
                                                            </div>
                                                            <div class="fs-11 text-gray-500"># Allowed file types: png,
                                                                jpg, jpeg</div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-4 align-items-center">
                                                <div class="col-lg-4">
                                                    <label for="fullnameInput" class="fw-semibold">Name:<span
                                                            class="text-danger">*</span> </label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="input-group">
                                                        <div class="input-group-text"><i class="feather-user"></i>
                                                        </div>
                                                        <input type="text" class="form-control" id="fullnameInput"
                                                            placeholder="Name" name = "name"
                                                            value = "{{ $mentor->name }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-4 align-items-center">
                                                <div class="col-lg-4">
                                                    <label for="mailInput" class="fw-semibold">Email:<span
                                                            class="text-danger">*</span> </label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="input-group">
                                                        <div class="input-group-text"><i class="feather-mail"></i>
                                                        </div>
                                                        <input type="email" class="form-control" id="mailInput"
                                                            placeholder="Email" name = "email"
                                                            value = "{{ $mentor->email }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-4 align-items-center">
                                                <div class="col-lg-4">
                                                    <label for="phoneInput" class="fw-semibold">Phone:<span
                                                            class="text-danger">*</span> </label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="input-group">
                                                        <div class="input-group-text"><i class="feather-phone"></i>
                                                        </div>
                                                        <input type="text" class="form-control" id="phoneInput"
                                                            placeholder="Phone" maxlength="10" inputmode="numeric"
                                                            pattern="[6-9][0-9]{9}" name = "phone"
                                                            oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^([0-5])/, '')"
                                                            title="Enter a 10-digit number starting with 6, 7, 8, or 9"
                                                            value = "{{ $mentor->phone }}">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-4 align-items-center">
                                                <div class="col-lg-4">
                                                    <label for="designationInput" class="fw-semibold">Department:<span
                                                            class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="input-group">
                                                        <div class="input-group-text"><i
                                                                class="feather-briefcase"></i></div>
                                                        <select class="form-control" id="departmentInput"
                                                            name="department_id" required>
                                                            <option value="">Select Department</option>
                                                            @foreach ($departments as $department)
                                                                <option value="{{ $department->id }}"
                                                                    {{ $mentor->department == $department->id ? 'selected' : '' }}>
                                                                    {{ $department->department_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-4 align-items-center">
                                                <div class="col-lg-4">
                                                    <label for="designationInput"
                                                        class="fw-semibold">Designation:<span
                                                            class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="input-group">
                                                        <div class="input-group-text"><i
                                                                class="feather-briefcase"></i></div>
                                                        <select class="form-control" id="designationInput"
                                                            name="designation_id" required>
                                                            <option value="">Select Designation</option>
                                                        </select>


                                                        <input type="hidden" id="selectedDesignation"
                                                            value="{{ $mentor->designation }}">




                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-4 align-items-center">
                                                <div class="col-lg-4">
                                                    <label for="addressInput_1" class="fw-semibold">Address:<span
                                                            class="text-danger">*</span> </label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="input-group">
                                                        <div class="input-group-text"><i class="feather-map-pin"></i>
                                                        </div>
                                                        <textarea class="form-control" name = "address" id="addressInput_1" cols="30" rows="3"
                                                            placeholder="Address">{{ $mentor->address }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-8 offset-lg-4">
                                                <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                                                    <span class="btn-text">Submit Internship</span>
                                                    <span id="submitLoader"
                                                        class="spinner-border spinner-border-sm d-none ms-2"
                                                        role="status" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                        </div>


                                    </div>

                                </div>

                        </div>

                        </form>
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
                                value="1" data-app-navigation="app-navigation-light" checked>
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-navigation-light">Light</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-navigation-dark" name="app-navigation"
                                value="2" data-app-navigation="app-navigation-dark">
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
                                value="1" data-app-header="app-header-light" checked>
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-header-light">Light</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-header-dark" name="app-header"
                                value="2" data-app-header="app-header-dark">
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
                                value="1" data-app-skin="app-skin-light">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-skin-light">Light</label>
                        </div>
                        <div class="col-6 text-center position-relative single-option dark-button">
                            <input type="radio" class="btn-check" id="app-skin-dark" name="app-skin"
                                value="2" data-app-skin="app-skin-dark">
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
                                value="1" data-font-family="app-font-family-lato">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-lato">Lato</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-rubik" name="font-family"
                                value="2" data-font-family="app-font-family-rubik">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-rubik">Rubik</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-inter" name="font-family"
                                value="3" data-font-family="app-font-family-inter" checked>
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-inter">Inter</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-cinzel" name="font-family"
                                value="4" data-font-family="app-font-family-cinzel">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-cinzel">Cinzel</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-nunito" name="font-family"
                                value="6" data-font-family="app-font-family-nunito">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-nunito">Nunito</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-roboto" name="font-family"
                                value="7" data-font-family="app-font-family-roboto">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-roboto">Roboto</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-ubuntu" name="font-family"
                                value="8" data-font-family="app-font-family-ubuntu">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-ubuntu">Ubuntu</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-poppins" name="font-family"
                                value="9" data-font-family="app-font-family-poppins">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-poppins">Poppins</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-raleway" name="font-family"
                                value="10" data-font-family="app-font-family-raleway">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-raleway">Raleway</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-system-ui"
                                name="font-family" value="11" data-font-family="app-font-family-system-ui">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-system-ui">System UI</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-noto-sans"
                                name="font-family" value="12" data-font-family="app-font-family-noto-sans">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-noto-sans">Noto Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-fira-sans"
                                name="font-family" value="13" data-font-family="app-font-family-fira-sans">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-fira-sans">Fira Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-work-sans"
                                name="font-family" value="14" data-font-family="app-font-family-work-sans">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-work-sans">Work Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-open-sans"
                                name="font-family" value="15" data-font-family="app-font-family-open-sans">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-open-sans">Open Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-maven-pro"
                                name="font-family" value="16" data-font-family="app-font-family-maven-pro">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-maven-pro">Maven Pro</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-quicksand"
                                name="font-family" value="17" data-font-family="app-font-family-quicksand">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-quicksand">Quicksand</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-montserrat"
                                name="font-family" value="18" data-font-family="app-font-family-montserrat">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-montserrat">Montserrat</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-josefin-sans"
                                name="font-family" value="19" data-font-family="app-font-family-josefin-sans">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-josefin-sans">Josefin Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-ibm-plex-sans"
                                name="font-family" value="20" data-font-family="app-font-family-ibm-plex-sans">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-ibm-plex-sans">IBM Plex Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-source-sans-pro"
                                name="font-family" value="5" data-font-family="app-font-family-source-sans-pro">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-source-sans-pro">Source Sans Pro</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-montserrat-alt"
                                name="font-family" value="21" data-font-family="app-font-family-montserrat-alt">
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-montserrat-alt">Montserrat Alt</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-roboto-slab"
                                name="font-family" value="22" data-font-family="app-font-family-roboto-slab">
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


    <script src="assets/vendors/js/vendors.min.js"></script>

    <script src="assets/vendors/js/select2.min.js"></script>
    <script src="assets/vendors/js/select2-active.min.js"></script>
    {{-- <script src="assets/vendors/js/datepicker.min.js"></script> --}}
    <script src="assets/vendors/js/lslstrength.min.js"></script>

    <script src="assets/js/common-init.min.js"></script>
    <script src="assets/js/customers-create-init.min.js"></script>

    <script src="assets/js/theme-customizer-init.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/vendors/js/datepicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>



    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById('avatarPreview').src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script>
        function showToast(message) {
            const toast = document.createElement('div');

            toast.className = 'toast align-items-center text-bg-danger border-0';
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button"
                class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast"></button>
        </div>
    `;

            document.getElementById('toastContainer').appendChild(toast);

            const bsToast = new bootstrap.Toast(toast, {
                delay: 3000
            });
            bsToast.show();

            toast.addEventListener('hidden.bs.toast', () => toast.remove());
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('mentorForm');
            if (!form) return;

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const btn = document.getElementById('submitBtn');
                const loader = document.getElementById('submitLoader');

                const name = document.getElementById('fullnameInput').value.trim();
                const email = document.getElementById('mailInput').value.trim();
                const phone = document.getElementById('phoneInput').value.trim();
                const designation = document.getElementById('designationInput').value;
                const address = document.getElementById('addressInput_1').value.trim();


                if (!name) return showToast('Name is required');
                if (!email || !validateEmail(email)) return showToast('Valid email required');
                if (!/^[6-9][0-9]{9}$/.test(phone)) return showToast('Valid phone number required');
                if (!designation) return showToast('Designation is required');
                if (!address) return showToast('Address is required');


                btn.disabled = true;
                loader.classList.remove('d-none');
                btn.querySelector('.btn-text').innerText = 'Submitting...';

                form.submit();
            });
        });

        function validateEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }
    </script>




    <script>
        $(document).ready(function() {

            function loadDesignations(departmentId, selectedId = null) {

                if (!departmentId) return;

                $.ajax({
                    url: "{{ route('get.designations') }}",
                    type: "GET",
                    data: {
                        department_id: departmentId
                    },
                    success: function(data) {

                        let options = '<option value="">Select Designation</option>';

                        $.each(data, function(key, item) {
                            let selected = (item.id == selectedId) ? 'selected' : '';
                            options += `<option value="${item.id}" ${selected}>
                                    ${item.designation_name}
                                </option>`;
                        });

                        $('#designationInput').html(options);
                    }
                });
            }

            // ✅ On page load (EDIT PAGE)
            let departmentId = $('#departmentInput').val();
            let selectedDesignation = $('#selectedDesignation').val();

            if (departmentId && selectedDesignation) {
                loadDesignations(departmentId, selectedDesignation);
            }

            // On department change
            $('#departmentInput').on('change', function() {
                loadDesignations($(this).val());
            });
        });
    </script>

</body>



</html>
