<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    @include('layouts.imports.head')
    @yield('css_section')

    <link rel="stylesheet" type="text/css"
        href="{{ Storage::disk('minio')->temporaryUrl('assets/bootstrap-extended.css', Carbon\Carbon::now()->addMinutes(20)) }}">

    <!-- Styles -->
    <style>
        .dt-checkboxes-select-all input {
            margin-top: 5.7px !important;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static menu-@yield('sidebar-size')" data-open="click"
    data-menu="vertical-menu-modern" data-col="">
    <div id="overlay">
        <div class="d-flex h-100">
            <div class="m-auto rounded-circle p-1">
                <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;">
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Header-->
    @include('layouts.header')
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    @include('layouts.sidebar')
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row mb-0">

            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    @include('layouts.imports.script')
    @yield('js_section')

    <script>
        var select = $('.select2');

        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
        select.each(function() {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                // the following code is used to disable x-scrollbar when click in select input and
                // take 100% width in responsive also
                dropdownAutoWidth: true,
                width: '100%',
                dropdownParent: $this.parent()
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(this).scrollTop(0);
        });
    </script>
</body>
<!-- END: Body-->

</html>
