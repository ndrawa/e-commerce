<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="Bandung Techno Park">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('page_title') | E-Commerce</title>
<link rel="apple-touch-icon"
    href="{{ Storage::disk('minio')->temporaryUrl('assets/logo-mini.png', Carbon\Carbon::now()->addMinutes(20)) }}">
<link rel="shortcut icon" type="image/x-icon"
    href="{{ Storage::disk('minio')->temporaryUrl('assets/logo-mini.png', Carbon\Carbon::now()->addMinutes(20)) }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
    rel="stylesheet">

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="https://content.unjani.co.id/themes/vuexy/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/vendors/css/charts/apexcharts.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/vendors/css/extensions/toastr.min.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/vendors/css/calendars/fullcalendar.min.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/vendors/css/forms/select/select2.min.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/vendors/css/pickers/flatpickr/flatpickr.min.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/vendors/css/pickers/pickadate/pickadate.css">
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('themes/vuexy/css/themes/dark-layout.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('themes/vuexy/css/themes/bordered-layout.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('themes/vuexy/css/themes/semi-dark-layout.css') }}">

<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/css/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/css/plugins/forms/form-quill-editor.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/css/plugins/extensions/ext-component-toastr.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="https://content.unjani.co.id/themes/vuexy/css/pages/app-email.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/css/plugins/forms/form-validation.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/css/plugins/extensions/ext-component-toastr.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/css/core/menu/menu-types/horizontal-menu.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/css/plugins/forms/pickers/form-flat-pickr.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/css/plugins/forms/form-validation.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/css/core/menu/menu-types/horizontal-menu.min.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/css/plugins/forms/pickers/form-pickadate.min.css">
<link rel="stylesheet" type="text/css"
    href="https://content.unjani.co.id/themes/vuexy/vendors/css/forms/wizard/bs-stepper.min.css">
{{-- <link rel="stylesheet" type="text/css" href="{{asset('themes/vuexy/css/plugins/forms/form-wizard.css') }}"> --}}

<!-- END: Page CSS-->

<!-- BEGIN: Boxicons CSS-->
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

<!-- BEGIN: Edited CSS-->
<link rel="stylesheet" type="text/css"
    href="{{ Storage::disk('minio')->temporaryUrl('assets/bootstrap.css', Carbon\Carbon::now()->addMinutes(20)) }}">
<link rel="stylesheet" type="text/css"
    href="{{ Storage::disk('minio')->temporaryUrl('assets/colors.css', Carbon\Carbon::now()->addMinutes(20)) }}">
<link rel="stylesheet" type="text/css"
    href="{{ Storage::disk('minio')->temporaryUrl('assets/components.css', Carbon\Carbon::now()->addMinutes(20)) }}">
<link rel="stylesheet" type="text/css"
    href="{{ Storage::disk('minio')->temporaryUrl('assets/form-flat-pickr.min.css', Carbon\Carbon::now()->addMinutes(20)) }}">
<link rel="stylesheet" type="text/css"
    href="{{ Storage::disk('minio')->temporaryUrl('assets/form-wizard.min.css', Carbon\Carbon::now()->addMinutes(20)) }}">
<link rel="stylesheet" type="text/css"
    href="{{ Storage::disk('minio')->temporaryUrl('assets/app-calendar.css', Carbon\Carbon::now()->addMinutes(20)) }}">

<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('styles.css') }}" />
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

<style>
    .menu-expanded .brand-logo {
        visibility: visible
    }

    .menu-collapsed .main-menu:hover .brand-logo {
        visibility: visible
    }

    .menu-collapsed .main-menu .brand-text {
        visibility: hidden
    }

    .menu-collapsed .main-menu:hover .brand-text {
        visibility: visible
    }

    select[readonly].select2-hidden-accessible+.select2-container {
        pointer-events: none;
        touch-action: none;
    }

    select[readonly].select2-hidden-accessible+.select2-container .select2-selection {
        background: #eee;
        box-shadow: none;
    }

    select[readonly].select2-hidden-accessible+.select2-container .select2-selection__arrow,
    select[readonly].select2-hidden-accessible+.select2-container .select2-selection__clear {
        display: none;
    }

    .sorting:before {
        right: 1em !important;
        content: "" !important;
    }

    .sorting:after {
        right: 1em !important;
        content: "" !important;
    }

    .sorting_asc:before {
        right: 1em !important;
        content: "" !important;
    }

    .sorting_asc:after {
        right: 1em !important;
        content: "" !important;
    }

    .sorting_desc:before {
        right: 1em !important;
        content: "" !important;
    }

    .sorting_desc:after {
        right: 1em !important;
        content: "" !important;
    }

    .dt-buttons {
        margin-top: 7.0px !important;
    }
</style>

{{-- <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css"> --}}
<!-- END: Custom CSS-->
