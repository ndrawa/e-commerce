<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    @include('layouts.imports.head')
    @yield('css_section')

    <!-- Styles -->
    <style>
        .main-content {
            padding: 0rem 5rem 0rem
        }

        @media screen and (max-width: 990px) {

            .main-content {
                padding: 0rem 0.5rem 0rem
            }
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body>

    <!-- BEGIN: Header-->
    @include('layouts.landing.header')
    <!-- END: Header-->

    <!-- BEGIN: Content-->
    <div class="main-content container-xxl mt-2" style="min-height:47%">
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END: Content-->

    @include('layouts.imports.script')
    @yield('js_section')

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $(this).scrollTop(0);
        });
    </script>
</body>
<!-- END: Body-->

</html>
