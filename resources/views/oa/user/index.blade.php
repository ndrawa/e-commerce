@extends('layouts.layout')

@section('css_section')
    <style>
        .disable-form,
        .disable-form:focus,
        .disable-form:hover {
            background-color: #efefef !important;
            opacity: 1;
            cursor: default;
        }
    </style>
@endsection

@section('page_title')
    Kelola Profile
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('master.admin.index') }}
@endsection

@section('url_back', url('dashboard'))

@section('content')
    <div class="card p-3">
        <div class="table-responsive">
            {{-- titile --}}
            <span class="fw-bolder fs-3">Kelola Profile</span>
            <form autocomplete="off" id="frm" class="row gy-1 gx-2 mt-75">
                @csrf
                <div class="col-12">
                    <div class="input-group input-group-merge">
                        <input name="inp[id]" id="id" value="{{ $user->id }}" hidden>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bolder">Username</label>
                    <div class="input-group input-group-merge">
                        <input id="username" name="inp[username]" value="{{ $user->username }}"
                            class="form-control add-credit-card-mask" type="text" placeholder="Username" />
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bolder">Nama</label>
                    <div class="input-group input-group-merge">
                        <input id="name" name="inp[name]" value="{{ $user->name }}"
                            class="form-control add-credit-card-mask" type="text" placeholder="Nama" />
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bolder">Email</label>
                    <div class="input-group input-group-merge">
                        <input id="email" name="inp[email]" value="{{ $user->email }}"
                            class="form-control add-credit-card-mask" type="email" placeholder="Email" />
                    </div>
                </div>
                <div class="col-12" id="hidden_password">
                    <label class="form-label fw-bolder">Password</label>
                    <div class="input-group input-group-merge">
                        <input id="password" name="inp[password]" class="form-control add-credit-card-mask" type="text"
                            placeholder="Password" />
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bolder">Konfirmasi Password</label>
                    <div class="input-group input-group-merge">
                        <input id="password" name="password" class="form-control add-credit-card-mask" type="text"
                            placeholder="Konfirmasi Password" />
                    </div>
                </div>
                <div class="col-12 text-center">
                    <a class="btn btn-primary me-1 mt-1" onclick="save()">Simpan</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js_section')
    <script>
        function save() {
            if ($("#frm").valid()) {
                var formData = new FormData($('#frm')[0]);

                $.ajax({
                    url: '{{ url('api/user') }}',
                    type: 'post',
                    data: formData,
                    contentType: false, //untuk upload image
                    processData: false, //untuk upload image
                    timeout: 300000, // sets timeout to 3 seconds
                    dataType: 'json',
                    success: function(e) {
                        if (e.status == 'success') {
                            // alert(e.message)
                            $("#frmbox").modal('hide');
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'bottom-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });

                            Toast.fire({
                                icon: 'success',
                                title: e.message
                            });
                            location.reload();
                        } else {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'bottom-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });

                            Toast.fire({
                                icon: 'error',
                                title: e.message
                            });
                            // alert(e.message);
                        }
                    }
                });
            }

        }
    </script>
@endsection
