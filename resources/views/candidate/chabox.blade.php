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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ===== WhatsApp Style ===== */
        .chat-container {
            height: 70vh;
            border: 1px solid #ddd;
            display: flex;
            background: #f0f2f5;
        }

        /* LEFT PANEL */
        .chat-users {
            width: 30%;
            background: #ffffff;
            border-right: 1px solid #ddd;
            display: flex;
            flex-direction: column;
        }

        .chat-search {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .chat-search input {
            width: 100%;
            padding: 8px 12px;
            border-radius: 20px;
            border: 1px solid #ccc;
        }

        .user-list {
            overflow-y: auto;
            flex: 1;
        }

        .user-item {
            padding: 12px;
            cursor: pointer;
            border-bottom: 1px solid #f1f1f1;
        }

        .user-item:hover,
        .user-item.active {
            background: #e9edef;
        }

        /* RIGHT PANEL */
        .chat-box {
            width: 70%;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background: #2b3d76;
            color: #fff;
            padding: 12px;
        }

        .chat-messages {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            background: #e2e6ef;
        }

        .msg {
            max-width: 60%;
            padding: 8px 12px;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .msg-me {
            background: #dcf8c6;
            margin-left: auto;
        }

        .msg-other {
            background: #ffffff;
        }

        /* INPUT */
        .chat-input {
            padding: 10px;
            background: #f0f2f5;
            display: flex;
            gap: 10px;
        }

        .chat-input input {
            flex: 1;
            border-radius: 20px;
            border: 1px solid #ccc;
            padding: 8px 15px;
        }

        .chat-input button {
            border-radius: 50%;
            width: 40px;
            height: 40px;
        }

        /* Chat bubble base */
        .chat-bubble {
            display: inline-block;
            max-width: 70%;
            padding: 8px 10px 6px;
            border-radius: 8px;
            font-size: 15px;
            line-height: 1.4;
            position: relative;
            word-wrap: break-word;
        }

        /* Sender (me) */
        .chat-bubble.me {
            background: #a7cef0;
            border-top-right-radius: 0;
        }

        /* Receiver (other) */
        .chat-bubble.other {
            background: #f3c2c2;
            border-top-left-radius: 0;
        }

        /* Message text */
        .chat-text {
            display: block;
            color: #000;
            margin-bottom: 2px;
        }

        /* Time + tick */
        .chat-meta {
            font-size: 11px;
            color: #667781;
            text-align: right;
            white-space: nowrap;
        }

        /* Tick mark */
        .tick {
            margin-left: 4px;
            color: #4fc3f7;
            /* WhatsApp blue */
            font-size: 12px;
        }
    </style>
    <style>
        /* ===== CHAT LIST CONTAINER ===== */
        .chat-user-list {
            padding: 12px;
            background: #f5f7fb;
        }

        /* ===== CHAT USER CARD ===== */
        .chat-user-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #ffffff;
            padding: 12px 14px;
            margin-bottom: 12px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        /* Hover */
        .chat-user-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
        }

        /* Active (selected) */
        .chat-user-item.active {
            border-left: 4px solid #4f46e5;
            background: #eef2ff;
        }

        /* ===== TEXT AREA ===== */
        .chat-user-item strong {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
        }

        /* ===== MESSAGE PREVIEW ===== */
        .chat-user-item .small {
            display: block;
            font-size: 13px;
            color: #6b7280;
            margin-top: 4px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 180px;
        }

        /* ===== TIME ===== */
        .chat-user-item .float-end {
            margin-left: auto;
            font-size: 11px;
            color: #9ca3af;
            white-space: nowrap;
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
                        <h5 class="m-b-10">Chat</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Chatbox</li>
                    </ul>
                </div>

            </div>
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                    <div class="chat-container">

                        <!-- LEFT USERS -->
                        <div class="chat-users" id="chatUsers">

                            <!-- SEARCH -->
                            <div class="chat-search">

                                <input type="text" id="searchUser" placeholder="Search user...">
                            </div>

                            <!-- SEARCH RESULT LIST -->
                            <div class="user-list d-none" id="userList">
                                @foreach ($users as $user)
                                    <div class="user-item" data-id="{{ $user->id }}"
                                        data-name="{{ strtolower($user->name) }}">
                                        {{ $user->name }}
                                    </div>
                                @endforeach
                            </div>

                            <!-- NORMAL CHAT LIST -->
                            <div class="chat-user-list" id="chatUserList"></div>

                        </div>
                        <!-- RIGHT CHAT -->
                        <div class="chat-box">
                            <div class="chat-header" id="chatHeader">
                                <img id="chatHeaderImg" src="" alt="">
                                <span id="chatHeaderName">Select a user</span>
                            </div>

                            <div class="chat-messages" id="chatMessages">
                                <p class="text-center text-muted mt-5">
                                    💬 Start the conversation
                                </p>
                            </div>

                            <form id="chatForm" class="chat-input">
                                @csrf
                                <input type="hidden" id="to_id">
                                <input type="text" id="message" placeholder="Type a message..." required>
                                <button class="btn btn-primary">➤</button>
                            </form>
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

    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>

    <script src="{{ asset('assets/vendors/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/apexcharts.min.js') }}"></script>
    <script src="assets/vendors/js/circle-progress.min.js"></script>

    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard-init.min.js') }}"></script>

    <script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script>

    <script>
        function loadChatUsers(activeId = null) {
            fetch('/candidate/chat/users')
                .then(res => res.json())
                .then(users => {
                    let html = '';

                    if (users.length === 0) {
                        html = `<div class="text-muted p-3">No chats yet</div>`;
                    }

                    users.forEach(user => {
                        html += `
                        <div>
                    <div class="chat-user-item ${activeId == user.id ? 'active' : ''}"
                        data-id="${user.id}"
                        data-name="${user.name}">
                        <strong>${user.name}</strong>
                       
                        <div class="text-muted small">${user.last_message}</div>
                         <span class="float-end text-muted">${user.time ?? ''}</span>
                    </div>
                    </div>
                `;
                    });

                    document.getElementById('chatUserList').innerHTML = html;
                })
                .catch(err => console.error(err));
        }

        // initial load
        loadChatUsers();
    </script>
    {{-- <script>
        let selectedUser = null;

        document.addEventListener('click', function(e) {

            const item = e.target.closest('.chat-user-item, .user-item');
            if (!item) return;

            selectedUser = item.dataset.id;

            // set hidden input
            document.getElementById('to_id').value = selectedUser;



            // active highlight
            document.querySelectorAll('.chat-user-item, .user-item')
                .forEach(el => el.classList.remove('active'));
            item.classList.add('active');

            // load messages
            loadMessages(selectedUser);

            // hide search results
            document.getElementById('userList').classList.add('d-none');
            document.getElementById('chatUserList').classList.remove('d-none');
        });
    </script> --}}
    <script>
        function loadMessages(userId) {
            fetch(`/candidate/chat/messages/${userId}`)
                .then(res => res.text())
                .then(html => {
                    const box = document.getElementById('chatMessages');
                    box.innerHTML = html;
                    box.scrollTop = box.scrollHeight;
                })
                .catch(err => console.error('Message load error:', err));

        }
    </script>
    <script>
        document.getElementById('chatForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!selectedUser) {
                alert('Please select a user');
                return;
            }

            fetch("{{ route('candidate.chat.send') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    to_id: selectedUser,
                    message: document.getElementById('message').value
                })
            }).then(() => {
                document.getElementById('message').value = '';
                loadMessages(selectedUser);
                loadChatUsers(selectedUser);
            });
        });
    </script>
    <script>
        document.getElementById('searchUser').addEventListener('input', function() {

            const value = this.value.trim().toLowerCase();
            const userList = document.getElementById('userList');
            const chatList = document.getElementById('chatUserList');

            if (value === '') {
                userList.classList.add('d-none');
                chatList.classList.remove('d-none');
                return;
            }

            userList.classList.remove('d-none');
            chatList.classList.add('d-none');

            document.querySelectorAll('.user-item').forEach(item => {
                item.dataset.name.includes(value) ?
                    item.classList.remove('d-none') :
                    item.classList.add('d-none');
            });
        });
    </script>


    <script>
        let selectedUser = null;

        document.addEventListener('click', function(e) {

            const item = e.target.closest('.chat-user-item, .user-item');
            if (!item) return;

            selectedUser = item.dataset.id;
            document.getElementById('to_id').value = selectedUser;

            // ===== HEADER NAME =====
            document.getElementById('chatHeaderName').textContent =
                item.dataset.name || item.innerText;

            // ===== HEADER IMAGE =====
            let role = item.dataset.role || 'candidate';
            let avatar = item.dataset.avatar || 'default.png';

            document.getElementById('chatHeaderImg').src =
                `/assets/images/${role}/${avatar}`;

            // ===== ACTIVE HIGHLIGHT =====
            document.querySelectorAll('.chat-user-item, .user-item')
                .forEach(el => el.classList.remove('active'));
            item.classList.add('active');

            // ===== LOAD MESSAGES =====
            loadMessages(selectedUser);

            // ===== HIDE SEARCH =====
            document.getElementById('userList').classList.add('d-none');
            document.getElementById('chatUserList').classList.remove('d-none');
        });
    </script>
</body>

</html>
