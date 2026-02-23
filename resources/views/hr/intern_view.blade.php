<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="flexilecode" />

    <title>Turain || Intern View </title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/daterangepicker.min.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme.min.css') }}" />

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
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Intern View</li>
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
                            <a href="javascript:void(0);" class="btn btn-icon btn-light-brand successAlertMessage">
                                <i class="feather-star"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-light-brand">
                                <i class="feather-eye me-2"></i>
                                <span>Follow</span>
                            </a>
                            <a href="customers-create.html" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Create Customer</span>
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
                    <div class="col-xxl-4 col-xl-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="mb-4 text-center">
                                    <div class="wd-150 ht-150 mx-auto mb-3 position-relative">
                                        <div class="avatar-image wd-150 ht-150 border border-5 border-gray-3">
                                            <img src="{{ asset('assets/images/intern/' . $intern->image) }}"
                                                alt="" class="img-fluid">
                                        </div>
                                        <div class="wd-10 ht-10 text-success rounded-circle position-absolute translate-middle"
                                            style="top: 76%; right: 10px">
                                            <i class="bi bi-patch-check-fill"></i>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <a href="javascript:void(0);"
                                            class="fs-14 fw-bold d-block">{{ $intern->name }}</a>
                                        <a href="javascript:void(0);" class="fs-12 fw-normal text-muted d-block">
                                            {{ $intern->email }}</a>
                                    </div>

                                </div>
                                <ul class="list-unstyled mb-4">
                                    <li class="hstack justify-content-between mb-4">
                                        <span class="text-muted fw-medium hstack gap-3"><i
                                                class="feather-map-pin"></i>Location</span>
                                        <a href="javascript:void(0);" class="float-end">{{ $intern->address }}</a>
                                    </li>
                                    <li class="hstack justify-content-between mb-4">
                                        <span class="text-muted fw-medium hstack gap-3"><i
                                                class="feather-phone"></i>Phone</span>
                                        <a href="javascript:void(0);" class="float-end">{{ $intern->phone }}</a>
                                    </li>
                                    <li class="hstack justify-content-between mb-0">
                                        <span class="text-muted fw-medium hstack gap-3"><i
                                                class="feather-mail"></i>Email</span>
                                        <a href="javascript:void(0);" class="float-end">{{ $intern->email }}</a>
                                    </li>
                                </ul>

                            </div>
                        </div>


                    </div>
                    <div class="col-xxl-8 col-xl-6">
                        <div class="card border-top-0">
                            <div class="card-header p-0">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs flex-wrap w-100 text-center customers-nav-tabs" id="myTab"
                                    role="tablist">
                                    <li class="nav-item flex-fill border-top" role="presentation">
                                        <a href="javascript:void(0);" class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#overviewTab" role="tab">Profile</a>
                                    </li>
                                    <li class="nav-item flex-fill border-top" role="presentation">
                                        <a href="javascript:void(0);" class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#billingTab" role="tab">Educational Information</a>
                                    </li>
                                    <li class="nav-item flex-fill border-top" role="presentation">
                                        <a href="javascript:void(0);" class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#activityTab" role="tab">Address</a>
                                    </li>
                                    <li class="nav-item flex-fill border-top" role="presentation">
                                        <a href="javascript:void(0);" class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#notificationsTab" role="tab">Mentor</a>
                                    </li>
                                    <li class="nav-item flex-fill border-top" role="presentation">
                                        <a href="javascript:void(0);" class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#connectionTab" role="tab">Work</a>
                                    </li>

                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active p-4" id="overviewTab" role="tabpanel">

                                    <div class="profile-details mb-5">
                                        <div class="mb-4 d-flex align-items-center justify-content-between">
                                            <h5 class="fw-bold mb-0">Profile Details:</h5>

                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Full Name:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->name }}</div>
                                        </div>

                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Date of Birth:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->dob }}</div>
                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Mobile Number:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->phone }}</div>
                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Email Address:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->email }}</div>
                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Location:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->address }}</div>
                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Joining Date:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->entry_date }}</div>
                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Ending Date:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->end_date }}</div>
                                        </div>


                                    </div>


                                </div>
                                <div class="tab-pane fade" id="billingTab" role="tabpanel">

                                    <div class="educational-details mb-5">
                                        <div class="mb-4 d-flex align-items-center justify-content-between">
                                            <h5 class="fw-bold mb-0">Educational Details:</h5>

                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Madhyamik Board:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->mp_boad }}</div>
                                        </div>

                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Madhyamik Marks:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->mp_marks }}</div>
                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Hs Board:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->hs_boad }}</div>
                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Hs marks:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->hs_marks }}</div>
                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Graduation:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->graduation }}</div>
                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Graduation CGPA:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->graduation_cgpa }}</div>
                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Post Graduation:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->post_graduation }}</div>
                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Post Graduation CGPA:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->post_graduation_cgpa }}
                                            </div>
                                        </div>

                                    </div>


                                </div>
                                <div class="tab-pane fade" id="activityTab" role="tabpanel">

                                    <div class="address-details mb-5">
                                        <div class="mb-4 d-flex align-items-center justify-content-between">
                                            <h5 class="fw-bold mb-0">Address Details:</h5>

                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Address Details:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->address }}</div>
                                        </div>

                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">Pincode:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $intern->pincode }}</div>
                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">State:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $state->name }}</div>
                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">District:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $districts->name }}</div>
                                        </div>
                                        <div class="row g-0 mb-4">
                                            <div class="col-sm-6 text-muted">City:</div>
                                            <div class="col-sm-6 fw-semibold">{{ $cities->name }}</div>
                                        </div>




                                    </div>


                                </div>
                                <div class="tab-pane fade" id="notificationsTab" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th class="wd-250 text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark">Successful payments
                                                        </div>
                                                        <small class="fs-12 text-muted">Receive a notification
                                                            for
                                                            every successful payment.</small>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="form-group select-wd-lg">
                                                            <select class="form-control" data-select2-selector="icon">
                                                                <option value="SMS" data-icon="feather-smartphone">
                                                                    SMS</option>
                                                                <option value="Push" data-icon="feather-bell">Push
                                                                </option>
                                                                <option value="Email" data-icon="feather-mail"
                                                                    selected>Email
                                                                </option>
                                                                <option value="Repeat" data-icon="feather-repeat">
                                                                    Repeat</option>
                                                                <option value="Deactivate"
                                                                    data-icon="feather-bell-off">Deactivate
                                                                </option>
                                                                <option value="SMS+Push"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                </option>
                                                                <option value="Email+Push" data-icon="feather-mail">
                                                                    Email + Push</option>
                                                                <option value="SMS+Email"
                                                                    data-icon="feather-smartphone">SMS + Email
                                                                </option>
                                                                <option value="SMS+Push+Email"
                                                                    data-icon="feather-smartphone">SMS + Push +
                                                                    Email
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark">Customer payment dispute
                                                        </div>
                                                        <small class="fs-12 text-muted">Receive a notification
                                                            if a
                                                            payment is disputed by a customer and for dispute
                                                            purposes.
                                                        </small>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="form-group select-wd-lg">
                                                            <select class="form-control" data-select2-selector="icon">
                                                                <option value="SMS" data-icon="feather-smartphone">
                                                                    SMS</option>
                                                                <option value="Push" data-icon="feather-bell">Push
                                                                </option>
                                                                <option value="Email" data-icon="feather-mail">
                                                                    Email</option>
                                                                <option value="Repeat" data-icon="feather-repeat">
                                                                    Repeat</option>
                                                                <option value="Deactivate"
                                                                    data-icon="feather-bell-off" selected>
                                                                    Deactivate
                                                                </option>
                                                                <option value="SMS+Push"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                </option>
                                                                <option value="Email+Push" data-icon="feather-mail">
                                                                    Email + Push</option>
                                                                <option value="SMS+Email"
                                                                    data-icon="feather-smartphone">SMS + Email
                                                                </option>
                                                                <option value="SMS+Push+Email"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                    + Email
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark">Refund alerts</div>
                                                        <small class="fs-12 text-muted">Receive a notification
                                                            if a
                                                            payment is stated as risk by the Finance Department.
                                                        </small>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="form-group select-wd-lg">
                                                            <select class="form-control" data-select2-selector="icon">
                                                                <option value="SMS" data-icon="feather-smartphone">
                                                                    SMS
                                                                </option>
                                                                <option value="Push" data-icon="feather-bell"
                                                                    selected>Push
                                                                </option>
                                                                <option value="Email" data-icon="feather-mail">
                                                                    Email</option>
                                                                <option value="Repeat" data-icon="feather-repeat">
                                                                    Repeat</option>
                                                                <option value="Deactivate"
                                                                    data-icon="feather-bell-off">Deactivate
                                                                </option>
                                                                <option value="SMS+Push"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                </option>
                                                                <option value="Email+Push" data-icon="feather-mail">
                                                                    Email + Push</option>
                                                                <option value="SMS+Email"
                                                                    data-icon="feather-smartphone">SMS + Email
                                                                </option>
                                                                <option value="SMS+Push+Email"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                    + Email
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark">Invoice payments</div>
                                                        <small class="fs-12 text-muted">Receive a notification
                                                            if a
                                                            customer sends an incorrect amount to pay their
                                                            invoice.
                                                        </small>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="form-group select-wd-lg">
                                                            <select class="form-control" data-select2-selector="icon">
                                                                <option value="SMS" data-icon="feather-smartphone">
                                                                    SMS
                                                                </option>
                                                                <option value="Push" data-icon="feather-bell">Push
                                                                </option>
                                                                <option value="Email" data-icon="feather-mail"
                                                                    selected>Email
                                                                </option>
                                                                <option value="Repeat" data-icon="feather-repeat">
                                                                    Repeat</option>
                                                                <option value="Deactivate"
                                                                    data-icon="feather-bell-off">Deactivate
                                                                </option>
                                                                <option value="SMS+Push"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                </option>
                                                                <option value="Email+Push" data-icon="feather-mail">
                                                                    Email + Push</option>
                                                                <option value="SMS+Email"
                                                                    data-icon="feather-smartphone">SMS + Email
                                                                </option>
                                                                <option value="SMS+Push+Email"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                    + Email
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark">Rating reminders</div>
                                                        <small class="fs-12 text-muted">Send an email
                                                            reminding me to
                                                            rate an item a week after purchase </small>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="form-group select-wd-lg">
                                                            <select class="form-control" data-select2-selector="icon">
                                                                <option value="SMS" data-icon="feather-smartphone">
                                                                    SMS
                                                                </option>
                                                                <option value="Push" data-icon="feather-bell">Push
                                                                </option>
                                                                <option value="Email" data-icon="feather-mail">
                                                                    Email</option>
                                                                <option value="Repeat" data-icon="feather-repeat">
                                                                    Repeat</option>
                                                                <option value="Deactivate"
                                                                    data-icon="feather-bell-off" selected>
                                                                    Deactivate
                                                                </option>
                                                                <option value="SMS+Push"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                </option>
                                                                <option value="Email+Push" data-icon="feather-mail">
                                                                    Email + Push</option>
                                                                <option value="SMS+Email"
                                                                    data-icon="feather-smartphone">SMS + Email
                                                                </option>
                                                                <option value="SMS+Push+Email"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                    + Email
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark">Item update
                                                            notifications</div>
                                                        <small class="fs-12 text-muted">Send an email when an
                                                            item
                                                            I've purchased is updated </small>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="form-group select-wd-lg">
                                                            <select class="form-control" data-select2-selector="icon">
                                                                <option value="SMS" data-icon="feather-smartphone">
                                                                    SMS
                                                                </option>
                                                                <option value="Push" data-icon="feather-bell">Push
                                                                </option>
                                                                <option value="Email" data-icon="feather-mail">
                                                                    Email</option>
                                                                <option value="Repeat" data-icon="feather-repeat">
                                                                    Repeat</option>
                                                                <option value="Deactivate"
                                                                    data-icon="feather-bell-off">Deactivate
                                                                </option>
                                                                <option value="SMS+Push"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                </option>
                                                                <option value="Email+Push" data-icon="feather-mail">
                                                                    Email + Push</option>
                                                                <option value="SMS+Email"
                                                                    data-icon="feather-smartphone">SMS + Email
                                                                </option>
                                                                <option value="SMS+Push+Email"
                                                                    data-icon="feather-smartphone" selected>
                                                                    SMS + Push
                                                                    + Email</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark">Item comment
                                                            notifications
                                                        </div>
                                                        <small class="fs-12 text-muted">Send me an email when
                                                            someone
                                                            comments on one of my items </small>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="form-group select-wd-lg">
                                                            <select class="form-control" data-select2-selector="icon">
                                                                <option value="SMS" data-icon="feather-smartphone">
                                                                    SMS
                                                                </option>
                                                                <option value="Push" data-icon="feather-bell">Push
                                                                </option>
                                                                <option value="Email" data-icon="feather-mail">
                                                                    Email</option>
                                                                <option value="Repeat" data-icon="feather-repeat">
                                                                    Repeat</option>
                                                                <option value="Deactivate"
                                                                    data-icon="feather-bell-off">Deactivate
                                                                </option>
                                                                <option value="SMS+Push"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                </option>
                                                                <option value="Email+Push" data-icon="feather-mail">
                                                                    Email + Push</option>
                                                                <option value="SMS+Email"
                                                                    data-icon="feather-smartphone" selected>
                                                                    SMS +
                                                                    Email</option>
                                                                <option value="SMS+Push+Email"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                    + Email
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark">Team comment
                                                            notifications
                                                        </div>
                                                        <small class="fs-12 text-muted">Send me an email when
                                                            someone
                                                            comments on one of my team items </small>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="form-group select-wd-lg">
                                                            <select class="form-control" data-select2-selector="icon">
                                                                <option value="SMS" data-icon="feather-smartphone">
                                                                    SMS
                                                                </option>
                                                                <option value="Push" data-icon="feather-bell">Push
                                                                </option>
                                                                <option value="Email" data-icon="feather-mail">
                                                                    Email</option>
                                                                <option value="Repeat" data-icon="feather-repeat">
                                                                    Repeat</option>
                                                                <option value="Deactivate"
                                                                    data-icon="feather-bell-off">Deactivate
                                                                </option>
                                                                <option value="SMS+Push"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                </option>
                                                                <option value="Email+Push" data-icon="feather-mail"
                                                                    selected>Email +
                                                                    Push</option>
                                                                <option value="SMS+Email"
                                                                    data-icon="feather-smartphone">SMS + Email
                                                                </option>
                                                                <option value="SMS+Push+Email"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                    + Email
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark">Item review
                                                            notifications</div>
                                                        <small class="fs-12 text-muted">Send me an email when
                                                            my items
                                                            are approved or rejected </small>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="form-group select-wd-lg">
                                                            <select class="form-control" data-select2-selector="icon">
                                                                <option value="SMS" data-icon="feather-smartphone">
                                                                    SMS
                                                                </option>
                                                                <option value="Push" data-icon="feather-bell">Push
                                                                </option>
                                                                <option value="Email" data-icon="feather-mail">
                                                                    Email</option>
                                                                <option value="Repeat" data-icon="feather-repeat">
                                                                    Repeat</option>
                                                                <option value="Deactivate"
                                                                    data-icon="feather-bell-off" selected>
                                                                    Deactivate
                                                                </option>
                                                                <option value="SMS+Push"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                </option>
                                                                <option value="Email+Push" data-icon="feather-mail">
                                                                    Email + Push</option>
                                                                <option value="SMS+Email"
                                                                    data-icon="feather-smartphone">SMS + Email
                                                                </option>
                                                                <option value="SMS+Push+Email"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                    + Email
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark">Buyer review
                                                            notifications
                                                        </div>
                                                        <small class="fs-12 text-muted">Send me an email when
                                                            someone
                                                            leaves a review with their rating </small>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="form-group select-wd-lg">
                                                            <select class="form-control" data-select2-selector="icon">
                                                                <option value="SMS" data-icon="feather-smartphone">
                                                                    SMS
                                                                </option>
                                                                <option value="Push" data-icon="feather-bell">Push
                                                                </option>
                                                                <option value="Email" data-icon="feather-mail">
                                                                    Email</option>
                                                                <option value="Repeat" data-icon="feather-repeat">
                                                                    Repeat</option>
                                                                <option value="Deactivate"
                                                                    data-icon="feather-bell-off">Deactivate
                                                                </option>
                                                                <option value="SMS+Push"
                                                                    data-icon="feather-smartphone" selected>
                                                                    SMS + Push
                                                                </option>
                                                                <option value="Email+Push" data-icon="feather-mail">
                                                                    Email + Push</option>
                                                                <option value="SMS+Email"
                                                                    data-icon="feather-smartphone">SMS + Email
                                                                </option>
                                                                <option value="SMS+Push+Email"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                    + Email
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark">Expiring support
                                                            notifications
                                                        </div>
                                                        <small class="fs-12 text-muted">Send me emails showing
                                                            my soon
                                                            to expire support entitlements </small>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="form-group select-wd-lg">
                                                            <select class="form-control" data-select2-selector="icon">
                                                                <option value="SMS" data-icon="feather-smartphone">
                                                                    SMS
                                                                </option>
                                                                <option value="Push" data-icon="feather-bell">Push
                                                                </option>
                                                                <option value="Email" data-icon="feather-mail"
                                                                    selected>Email
                                                                </option>
                                                                <option value="Repeat" data-icon="feather-repeat">
                                                                    Repeat</option>
                                                                <option value="Deactivate"
                                                                    data-icon="feather-bell-off">Deactivate
                                                                </option>
                                                                <option value="SMS+Push"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                </option>
                                                                <option value="Email+Push" data-icon="feather-mail">
                                                                    Email + Push</option>
                                                                <option value="SMS+Email"
                                                                    data-icon="feather-smartphone">SMS + Email
                                                                </option>
                                                                <option value="SMS+Push+Email"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                    + Email
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark">Daily summary emails
                                                        </div>
                                                        <small class="fs-12 text-muted">Send me a daily
                                                            summary of all
                                                            items approved or rejected </small>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="form-group select-wd-lg">
                                                            <select class="form-control" data-select2-selector="icon">
                                                                <option value="SMS" data-icon="feather-smartphone">
                                                                    SMS
                                                                </option>
                                                                <option value="Push" data-icon="feather-bell"
                                                                    selected>Push
                                                                </option>
                                                                <option value="Email" data-icon="feather-mail">
                                                                    Email</option>
                                                                <option value="Repeat" data-icon="feather-repeat">
                                                                    Repeat</option>
                                                                <option value="Deactivate"
                                                                    data-icon="feather-bell-off">Deactivate
                                                                </option>
                                                                <option value="SMS+Push"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                </option>
                                                                <option value="Email+Push" data-icon="feather-mail">
                                                                    Email + Push</option>
                                                                <option value="SMS+Email"
                                                                    data-icon="feather-smartphone">SMS + Email
                                                                </option>
                                                                <option value="SMS+Push+Email"
                                                                    data-icon="feather-smartphone">SMS + Push
                                                                    + Email
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                    <div class="notify-activity-section">
                                        <div class="px-4 mb-4 d-flex justify-content-between">
                                            <h5 class="fw-bold">Account Activity</h5>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-light-brand">View
                                                Alls</a>
                                        </div>
                                        <div class="px-4">
                                            <div
                                                class="hstack justify-content-between p-4 mb-3 border border-dashed border-gray-3 rounded-1">
                                                <div class="hstack me-4">
                                                    <div class="avatar-text">
                                                        <i class="feather-message-square"></i>
                                                    </div>
                                                    <div class="ms-4">
                                                        <a href="javascript:void(0);"
                                                            class="fw-bold mb-1 text-truncate-1-line">Someone
                                                            comments
                                                            on one of my items</a>
                                                        <div class="fs-12 text-muted text-truncate-1-line">If
                                                            someone
                                                            comments on one of your items, it's important to
                                                            respond in
                                                            a timely and appropriate manner.</div>
                                                    </div>
                                                </div>
                                                <div class="form-check form-switch form-switch-sm">
                                                    <label class="form-check-label fw-500 text-dark c-pointer"
                                                        for="formSwitchComment"></label>
                                                    <input class="form-check-input c-pointer" type="checkbox"
                                                        id="formSwitchComment">
                                                </div>
                                            </div>
                                            <div
                                                class="hstack justify-content-between p-4 mb-3 border border-dashed border-gray-3 rounded-1">
                                                <div class="hstack me-4">
                                                    <div class="avatar-text">
                                                        <i class="feather-briefcase"></i>
                                                    </div>
                                                    <div class="ms-4">
                                                        <a href="javascript:void(0);"
                                                            class="fw-bold mb-1 text-truncate-1-line">Someone
                                                            replies
                                                            to my job posting</a>
                                                        <div class="fs-12 text-muted text-truncate-1-line">
                                                            Great! It's
                                                            always exciting to hear from someone who's
                                                            interested in a
                                                            job posting you've put out.</div>
                                                    </div>
                                                </div>
                                                <div class="form-check form-switch form-switch-sm">
                                                    <label class="form-check-label fw-500 text-dark c-pointer"
                                                        for="formSwitchReplie"></label>
                                                    <input class="form-check-input c-pointer" type="checkbox"
                                                        id="formSwitchReplie">
                                                </div>
                                            </div>
                                            <div
                                                class="hstack justify-content-between p-4 mb-3 border border-dashed border-gray-3 rounded-1">
                                                <div class="hstack me-4">
                                                    <div class="avatar-text">
                                                        <i class="feather-briefcase"></i>
                                                    </div>
                                                    <div class="ms-4">
                                                        <a href="javascript:void(0);"
                                                            class="fw-bold mb-1 text-truncate-1-line">Someone
                                                            mentions
                                                            or follows me</a>
                                                        <div class="fs-12 text-muted text-truncate-1-line">If
                                                            you
                                                            received a notification that someone mentioned or
                                                            followed
                                                            you, take a moment to read it and understand what it
                                                            means.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-check form-switch form-switch-sm">
                                                    <label class="form-check-label fw-500 text-dark c-pointer"
                                                        for="formSwitchFollow"></label>
                                                    <input class="form-check-input c-pointer" type="checkbox"
                                                        id="formSwitchFollow">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="connectionTab" role="tabpanel">
                                    <div class="development-connections p-4 pb-0">
                                        <div class="mb-4 d-flex align-items-center justify-content-between">
                                            <h5 class="fw-bold">Developement Connections:</h5>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-light-brand">View
                                                Alls</a>
                                        </div>
                                        <div
                                            class="hstack justify-content-between p-4 mb-3 border border-dashed border-gray-3 rounded-1">
                                            <div class="hstack me-4">
                                                <div class="wd-40">
                                                    <img src="assets/images/brand/google-drive.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                                <div class="ms-4">
                                                    <a href="javascript:void(0);"
                                                        class="fw-bold mb-1 text-truncate-1-line">Google
                                                        Drive: Cloud
                                                        Storage & File Sharing</a>
                                                    <div class="fs-12 text-muted text-truncate-1-line">
                                                        Google's
                                                        powerful search capabilities are embedded in Drive and
                                                        offer
                                                        speed, reliability, and collaboration. And features like
                                                        Drive
                                                        search chips help your team ...</div>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch form-switch-sm">
                                                <label class="form-check-label fw-500 text-dark c-pointer"
                                                    for="formSwitchGDrive"></label>
                                                <input class="form-check-input c-pointer" type="checkbox"
                                                    id="formSwitchGDrive">
                                            </div>
                                        </div>
                                        <div
                                            class="hstack justify-content-between p-4 mb-3 border border-dashed border-gray-3 rounded-1">
                                            <div class="hstack me-4">
                                                <div class="wd-40">
                                                    <img src="assets/images/brand/dropbox.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                                <div class="ms-4">
                                                    <a href="javascript:void(0);"
                                                        class="fw-bold mb-1 text-truncate-1-line">Dropbox:
                                                        Cloud
                                                        Storage & File Sharing</a>
                                                    <div class="fs-12 text-muted text-truncate-1-line">Dropbox
                                                        brings
                                                        everything—traditional files, cloud content, and web
                                                        shortcuts—together in one place. ... Save and access
                                                        your files
                                                        from any device, and share ...</div>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch form-switch-sm">
                                                <label class="form-check-label fw-500 text-dark c-pointer"
                                                    for="formSwitchDropbox"></label>
                                                <input class="form-check-input c-pointer" type="checkbox"
                                                    id="formSwitchDropbox" checked>
                                            </div>
                                        </div>
                                        <div
                                            class="hstack justify-content-between p-4 mb-3 border border-dashed border-gray-3 rounded-1">
                                            <div class="hstack me-4">
                                                <div class="wd-40">
                                                    <img src="assets/images/brand/github.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                                <div class="ms-4">
                                                    <a href="javascript:void(0);"
                                                        class="fw-bold mb-1 text-truncate-1-line">GitHub:
                                                        Where the
                                                        world builds software</a>
                                                    <div class="fs-12 text-muted text-truncate-1-line">GitHub
                                                        is where
                                                        over 83 million developers shape the future of software,
                                                        together. Contribute to the open source community,
                                                        manage your
                                                        Git repositories, ...</div>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch form-switch-sm">
                                                <label class="form-check-label fw-500 text-dark c-pointer"
                                                    for="formSwitchGitHub"></label>
                                                <input class="form-check-input c-pointer" type="checkbox"
                                                    id="formSwitchGitHub" checked>
                                            </div>
                                        </div>
                                        <div
                                            class="hstack justify-content-between p-4 mb-3 border border-dashed border-gray-3 rounded-1">
                                            <div class="hstack me-4">
                                                <div class="wd-40">
                                                    <img src="assets/images/brand/gitlab.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                                <div class="ms-4">
                                                    <a href="javascript:void(0);"
                                                        class="fw-bold mb-1 text-truncate-1-line">GitLab: The
                                                        One
                                                        DevOps Platform</a>
                                                    <div class="fs-12 text-muted text-truncate-1-line">GitLab
                                                        helps
                                                        you automate the builds, integration, and verification
                                                        of your
                                                        code. With SAST, DAST, code quality analysis, plus
                                                        pipelines
                                                        that enable ...</div>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch form-switch-sm">
                                                <label class="form-check-label fw-500 text-dark c-pointer"
                                                    for="formSwitchGitLab"></label>
                                                <input class="form-check-input c-pointer" type="checkbox"
                                                    id="formSwitchGitLab">
                                            </div>
                                        </div>
                                        <div
                                            class="hstack justify-content-between p-4 mb-3 border border-dashed border-gray-3 rounded-1">
                                            <div class="hstack me-4">
                                                <div class="wd-40">
                                                    <img src="assets/images/brand/shopify.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                                <div class="ms-4">
                                                    <a href="javascript:void(0);"
                                                        class="fw-bold mb-1 text-truncate-1-line">Shopify:
                                                        Ecommerce
                                                        Developers Platform</a>
                                                    <div class="fs-12 text-muted text-truncate-1-line">Try
                                                        Shopify
                                                        free and start a business or grow an existing one. Get
                                                        more than
                                                        ecommerce software with tools to manage every part of
                                                        your
                                                        business.</div>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch form-switch-sm">
                                                <label class="form-check-label fw-500 text-dark c-pointer"
                                                    for="formSwitchShopify"></label>
                                                <input class="form-check-input c-pointer" type="checkbox"
                                                    id="formSwitchShopify" checked>
                                            </div>
                                        </div>
                                        <div
                                            class="hstack justify-content-between p-4 border border-dashed border-gray-3 rounded-1">
                                            <div class="hstack me-4">
                                                <div class="wd-40">
                                                    <img src="assets/images/brand/whatsapp.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                                <div class="ms-4">
                                                    <a href="javascript:void(0);"
                                                        class="fw-bold mb-1 text-truncate-1-line">WhatsApp:
                                                        WhatsApp
                                                        from Facebook is a FREE messaging and video calling
                                                        app</a>
                                                    <div class="fs-12 text-muted text-truncate-1-line">
                                                        Reliable
                                                        messaging. With WhatsApp, you'll get fast, simple,
                                                        secure
                                                        messaging and calling for free*, available on phones all
                                                        ...
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch form-switch-sm">
                                                <label class="form-check-label fw-500 text-dark c-pointer"
                                                    for="formSwitchWhatsApp"></label>
                                                <input class="form-check-input c-pointer" type="checkbox"
                                                    id="formSwitchWhatsApp">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="social-connections px-4 mb-4">
                                        <div class="mb-4 d-flex align-items-center justify-content-between">
                                            <h5 class="fw-bold">Social Connections:</h5>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-light-brand">View
                                                Alls</a>
                                        </div>
                                        <div
                                            class="hstack justify-content-between p-4 mb-3 border border-dashed border-gray-3 rounded-1">
                                            <div class="hstack me-4">
                                                <div class="wd-40">
                                                    <img src="assets/images/brand/facebook.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                                <div class="ms-4">
                                                    <a href="javascript:void(0);"
                                                        class="fw-bold mb-1 text-truncate-1-line">Facebook:
                                                        The World
                                                        Most Popular Social Network</a>
                                                    <div class="fs-12 text-muted text-truncate-1-line">Create
                                                        an
                                                        account or log into Facebook. Connect with friends,
                                                        family and
                                                        other people you know. Share photos and videos, send
                                                        messages
                                                        and get updates.</div>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch form-switch-sm">
                                                <label class="form-check-label fw-500 text-dark c-pointer"
                                                    for="formSwitchFacebook"></label>
                                                <input class="form-check-input c-pointer" type="checkbox"
                                                    id="formSwitchFacebook" checked>
                                            </div>
                                        </div>
                                        <div
                                            class="hstack justify-content-between p-4 mb-3 border border-dashed border-gray-3 rounded-1">
                                            <div class="hstack me-4">
                                                <div class="wd-40">
                                                    <img src="assets/images/brand/instagram.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                                <div class="ms-4">
                                                    <a href="javascript:void(0);"
                                                        class="fw-bold mb-1 text-truncate-1-line">Instagram:
                                                        Edit &
                                                        Share photos, Videos & Dessages</a>
                                                    <div class="fs-12 text-muted text-truncate-1-line">Create
                                                        an
                                                        account or log in to Instagram - A simple, fun &
                                                        creative way to
                                                        capture, edit & share photos, videos & messages with
                                                        friends &
                                                        family.</div>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch form-switch-sm">
                                                <label class="form-check-label fw-500 text-dark c-pointer"
                                                    for="formSwitchInstagram"></label>
                                                <input class="form-check-input c-pointer" type="checkbox"
                                                    id="formSwitchInstagram">
                                            </div>
                                        </div>
                                        <div
                                            class="hstack justify-content-between p-4 mb-3 border border-dashed border-gray-3 rounded-1">
                                            <div class="hstack me-4">
                                                <div class="wd-40">
                                                    <img src="assets/images/brand/twitter.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                                <div class="ms-4">
                                                    <a href="javascript:void(0);"
                                                        class="fw-bold mb-1 text-truncate-1-line">Twitter:
                                                        It's what's
                                                        happening / Twitter </a>
                                                    <div class="fs-12 text-muted text-truncate-1-line">From
                                                        breaking
                                                        news and entertainment to sports and politics, get the
                                                        full
                                                        story with all the live commentary.</div>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch form-switch-sm">
                                                <label class="form-check-label fw-500 text-dark c-pointer"
                                                    for="formSwitchTwitter"></label>
                                                <input class="form-check-input c-pointer" type="checkbox"
                                                    id="formSwitchTwitter" checked>
                                            </div>
                                        </div>
                                        <div
                                            class="hstack justify-content-between p-4 mb-3 border border-dashed border-gray-3 rounded-1">
                                            <div class="hstack me-4">
                                                <div class="wd-40">
                                                    <img src="assets/images/brand/spotify.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                                <div class="ms-4">
                                                    <a href="javascript:void(0);"
                                                        class="fw-bold mb-1 text-truncate-1-line">Spotify: Web
                                                        Player:
                                                        Music for everyone </a>
                                                    <div class="fs-12 text-muted text-truncate-1-line">Spotify
                                                        is a
                                                        digital music service that gives you access to millions
                                                        of
                                                        songs.</div>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch form-switch-sm">
                                                <label class="form-check-label fw-500 text-dark c-pointer"
                                                    for="formSwitchSpotify"></label>
                                                <input class="form-check-input c-pointer" type="checkbox"
                                                    id="formSwitchSpotify" checked>
                                            </div>
                                        </div>
                                        <div
                                            class="hstack justify-content-between p-4 mb-3 border border-dashed border-gray-3 rounded-1">
                                            <div class="hstack me-4">
                                                <div class="wd-40">
                                                    <img src="assets/images/brand/youtube.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                                <div class="ms-4">
                                                    <a href="javascript:void(0);"
                                                        class="fw-bold mb-1 text-truncate-1-line">YouTube: The
                                                        World
                                                        Largest Video Sharing Platform</a>
                                                    <div class="fs-12 text-muted text-truncate-1-line">Enjoy
                                                        the
                                                        videos and music you love, upload original content, and
                                                        share it
                                                        all with friends, family, and the world on YouTube.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch form-switch-sm">
                                                <label class="form-check-label fw-500 text-dark c-pointer"
                                                    for="formSwitchYouTube"></label>
                                                <input class="form-check-input c-pointer" type="checkbox"
                                                    id="formSwitchYouTube">
                                            </div>
                                        </div>
                                        <div
                                            class="hstack justify-content-between p-4 border border-dashed border-gray-3 rounded-1">
                                            <div class="hstack me-4">
                                                <div class="wd-40">
                                                    <img src="assets/images/brand/pinterest.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                                <div class="ms-4">
                                                    <a href="javascript:void(0);"
                                                        class="fw-bold mb-1 text-truncate-1-line">Pinterest:
                                                        Discover
                                                        recipes, home ideas, style inspiration and other ideas
                                                        to
                                                        try</a>
                                                    <div class="fs-12 text-muted text-truncate-1-line">
                                                        Pinterest is an
                                                        image sharing and social media service designed to
                                                        enable saving
                                                        and discovery of information on the internet using
                                                        images.</div>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch form-switch-sm">
                                                <label class="form-check-label fw-500 text-dark c-pointer"
                                                    for="formSwitchPinterest"></label>
                                                <input class="form-check-input c-pointer" type="checkbox"
                                                    id="formSwitchPinterest" checked>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade p-4" id="securityTab" role="tabpanel">
                                    <div class="p-4 mb-4 border border-dashed border-gray-3 rounded-1">
                                        <h6 class="fw-bolder"><a href="javascript:void(0);">Two-factor
                                                Authentication</a></h6>
                                        <div class="fs-12 text-muted text-truncate-3-line mt-2 mb-4">
                                            Two-factor
                                            authentication is an enhanced security meansur. Once enabled, you'll
                                            be
                                            required to give two types of identification when you log into
                                            Google
                                            Authentication and SMS are Supported.</div>
                                        <div class="form-check form-switch form-switch-sm">
                                            <label class="form-check-label fw-500 text-dark c-pointer"
                                                for="2faVerification">Enable 2FA Verification</label>
                                            <input class="form-check-input c-pointer" type="checkbox"
                                                id="2faVerification" checked>
                                        </div>
                                    </div>
                                    <div class="p-4 mb-4 border border-dashed border-gray-3 rounded-1">
                                        <h6 class="fw-bolder"><a href="javascript:void(0);">Secondary
                                                Verification</a></h6>
                                        <div class="fs-12 text-muted text-truncate-3-line mt-2 mb-4">The first
                                            factor
                                            is a password and the second commonly includes a text with a code
                                            sent to
                                            your smartphone, or biometrics using your fingerprint, face, or
                                            retina.
                                        </div>
                                        <div class="form-check form-switch form-switch-sm">
                                            <label class="form-check-label fw-500 text-dark c-pointer"
                                                for="secondaryVerification">Set up secondary method</label>
                                            <input class="form-check-input c-pointer" type="checkbox"
                                                id="secondaryVerification" checked>
                                        </div>
                                    </div>
                                    <div class="p-4 mb-4 border border-dashed border-gray-3 rounded-1">
                                        <h6 class="fw-bolder"><a href="javascript:void(0);">Backup Codes</a>
                                        </h6>
                                        <div class="fs-12 text-muted text-truncate-3-line mt-4 mb-4">A backup
                                            code is
                                            automatically generated for you when you turn on two-factor
                                            authentication
                                            through your iOS or Android Twitter app. You can also generate a
                                            backup code
                                            on twitter.com.</div>
                                        <div class="form-check form-switch form-switch-sm">
                                            <label class="form-check-label fw-500 text-dark c-pointer"
                                                for="generateBackup">Generate backup codes</label>
                                            <input class="form-check-input c-pointer" type="checkbox"
                                                id="generateBackup">
                                        </div>
                                    </div>
                                    <div class="p-4 border border-dashed border-gray-3 rounded-1">
                                        <h6 class="fw-bolder"><a href="javascript:void(0);">Login
                                                Verification</a>
                                        </h6>
                                        <div class="fs-12 text-muted text-truncate-3-line mt-2 mb-4">Login
                                            verification is an enhanced security meansur. Once enabled, you'll
                                            be
                                            required to give two types of identification when you log into
                                            Google
                                            Authentication and SMS are Supported.</div>
                                        <div class="form-check form-switch form-switch-sm">
                                            <label class="form-check-label fw-500 text-dark c-pointer"
                                                for="loginVerification">Enable Login Verification</label>
                                            <input class="form-check-input c-pointer" type="checkbox"
                                                id="loginVerification" checked>
                                        </div>
                                    </div>
                                    <hr class="my-5">
                                    <div class="alert alert-dismissible mb-4 p-4 d-flex alert-soft-danger-message"
                                        role="alert">
                                        <div class="me-4 d-none d-md-block">
                                            <i class="feather feather-alert-triangle text-danger fs-1"></i>
                                        </div>
                                        <div>
                                            <p class="fw-bold mb-0 text-truncate-1-line">You Are Delete or
                                                Deactivating Your Account</p>
                                            <p class="text-truncate-3-line mt-2 mb-4">Two-factor
                                                authentication adds
                                                an additional layer of security to your account by requiring
                                                more than
                                                just a password to log in.</p>
                                            <a href="javascript:void(0);"
                                                class="btn btn-sm btn-danger d-inline-block">Learn more</a>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    </div>
                                    <div class="card mt-5">
                                        <div class="card-body">
                                            <h6 class="fw-bold">Delete Account</h6>
                                            <p class="fs-11 text-muted">Go to the Data & Privacy section of
                                                your
                                                profile Account. Scroll to "Your data & privacy options." Delete
                                                your
                                                Profile Account. Follow the instructions to delete your account:
                                            </p>
                                            <div class="my-4 py-2">
                                                <input type="password" class="form-control"
                                                    placeholder="Enter your password">
                                                <div class="mt-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="acDeleteDeactive">
                                                        <label class="custom-control-label c-pointer"
                                                            for="acDeleteDeactive">I confirm my account
                                                            deletations or
                                                            deactivation.</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-sm-flex gap-2">
                                                <a href="javascript:void(0);" class="btn btn-danger"
                                                    data-action-target="#acSecctingsActionMessage">Delete
                                                    Account</a>
                                                <a href="javascript:void(0);"
                                                    class="btn btn-warning mt-2 mt-sm-0 successAlertMessage">Deactiveted
                                                    Account</a>
                                            </div>
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
                            <input type="radio" class="btn-check" id="app-font-family-poppins"
                                name="font-family" value="9" data-font-family="app-font-family-poppins" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-poppins">Poppins</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-raleway"
                                name="font-family" value="10" data-font-family="app-font-family-raleway" />
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
                                name="font-family" value="19"
                                data-font-family="app-font-family-josefin-sans" />
                            <label
                                class="py-2 fs-9 fw-bold text-dark text-uppercase text-spacing-1 border border-gray-2 w-100 h-100 c-pointer position-relative options-label"
                                for="app-font-family-josefin-sans">Josefin Sans</label>
                        </div>
                        <div class="col-6 text-center single-option">
                            <input type="radio" class="btn-check" id="app-font-family-ibm-plex-sans"
                                name="font-family" value="20"
                                data-font-family="app-font-family-ibm-plex-sans" />
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
                                name="font-family" value="22"
                                data-font-family="app-font-family-roboto-slab" />
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

    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>

    <script src="{{ asset('assets/vendors/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/apexcharts.min.js') }}"></script>
    <script src="assets/vendors/js/circle-progress.min.js"></script>

    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard-init.min.js') }}"></script>

    <script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script>

</body>

</html>
