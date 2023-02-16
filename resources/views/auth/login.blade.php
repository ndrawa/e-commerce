<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    @section('page_title')
        Login
    @endsection
    @include('layouts.imports.head')

    <style>
        .main {
            /* padding: 6rem 8rem; */
            padding: 4rem 2rem;
        }

        .a4 {
            width: 21cm;
        }

        .th-custom {
            background-color: white !important;
            color: #5e5873;
        }

        .table> :not(caption)>*>* {
            border-bottom-width: 2px;
        }

        .custom-border-bottom {
            border-bottom-width: 1.5px;
        }

        .no-border {
            border-bottom-width: 0px !important;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body>
    <div id="overlay">
        <div class="d-flex h-100">
            <div class="m-auto rounded-circle p-1">
                <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;">
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN: Content-->
    <div id="main-container" class="w-100 h-100">
        <div class="row w-100 h-100">
            <div class="col-lg-6 p-3 py-5 d-flex flex-column">
                <div class="w-100 h-100 px-4 mx-auto d-flex flex-column" style="max-width: 500px">
                    <div class="my-auto">
                        <h1 style="font-weight: 700" class="mb-2 text-primary">Selamat Datang!</h1>
                        <p class="mb-1">
                            <strong>Selamat Datang</strong>, Harap Masuk Menggunakan Akun Anda Untuk
                            Melanjutkan
                        </p>

                        <form id="frm" class="row gy-1 gx-2 mt-75 form-validate">
                            @csrf
                            <div class="col-12">
                                <label class="form-label fw-bolder">Email</label>
                                <div class="input-group input-group-merge">
                                    <input id="email" name="email" class="form-control add-credit-card-mask"
                                        type="text" placeholder="Email" required />
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bolder">Password</label>
                                <div class="input-group input-group-merge">
                                    <input id="password" name="password" class="form-control add-credit-card-mask"
                                        type="password" placeholder="Password" required />
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary w-100 " style="font-size: 14px">
                                    <span style="font-weight: 700">Login</span>
                                </button>
                            </div>

                            <div>
                                <a href="{{ route('register') }}" class="btn btn-outline-danger w-100 "
                                    style="font-size: 14px">
                                    <span style="font-weight: 700">Registrasi</span>
                                </a>
                            </div>

                            <div class="d-flex align-items-center justify-content-center">
                                <label class="fw-bold my-1">Atau</label>
                            </div>
                            <div>
                                <a href="{{ url('/') }}" class="btn btn-secondary w-100 " style="font-size: 14px">
                                    <span style="font-weight: 700">Kembali</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 p-3 hidden-xs"
                style="background:#FAEFF1;box-shadow: 3px 20px 30px rgba(0, 0, 0, .16);">
                <div class="d-flex flex-column w-100 h-100">
                    <div class="d-flex flex-column mx-auto h-100" style="max-width: 800px">
                        <div class="d-flex flex-column mt-auto align-items-center">
                            <div class="my-auto ">
                                <img class="w-100" src="">
                            </div>
                            <div class="text-center mt-5" style="max-width: 500px">
                                <h1 class="h4" style="font-weight: 700;color:#163485">
                                </h1>
                                <p class="mb-3 text-secondary" style="">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

    @include('layouts.imports.script')
    <script>
        $('#frm').submit(function(e) {
            e.preventDefault()
            login()
        })

        function login() {
            if ($("#frm").valid()) {
                var formData = new FormData($('#frm')[0]);

                $.ajax({
                    url: '{{ url('api/login') }}',
                    type: 'post',
                    data: formData,
                    contentType: false, //untuk upload image
                    processData: false, //untuk upload image
                    timeout: 300000, // sets timeout to 3 seconds
                    dataType: 'json',
                    success: function(e) {
                        if (e.status == 'success') {
                            window.location.href = "{{ url('dashboard') }}";
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: e.message,
                            })
                        }
                    }
                });
            }
        }
    </script>

</body>
<!-- END: Body-->

</html>
