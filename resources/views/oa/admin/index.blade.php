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
    Kelola Admin
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('master.admin.index') }}
@endsection

@section('url_back', url('dashboard'))

@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Keterangan</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- add new card modal  -->
    <div class="modal fade" id="frmbox" tabindex="-1" aria-labelledby="frmbox-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-sm-5 mx-50 pb-5">
                    <h1 class="text-center mb-1" id="frmbox-title">Tambah Admin</h1>
                    <form autocomplete="off" id="frm" class="row gy-1 gx-2 mt-75">
                        @csrf
                        <div class="col-12">
                            <div class="input-group input-group-merge">
                                <input name="inp[id]" id="id" hidden>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bolder">Username</label>
                            <div class="input-group input-group-merge">
                                <input id="username" name="inp[username]" class="form-control add-credit-card-mask"
                                    type="text" placeholder="Username" required />
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bolder">Nama</label>
                            <div class="input-group input-group-merge">
                                <input id="name" name="inp[name]" class="form-control add-credit-card-mask"
                                    type="text" placeholder="Nama" required />
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bolder">Email</label>
                            <div class="input-group input-group-merge">
                                <input id="email" name="inp[email]" class="form-control add-credit-card-mask"
                                    type="email" placeholder="Email" required />
                            </div>
                        </div>
                        <div class="col-12" id="hidden_password">
                            <label class="form-label fw-bolder">Password</label>
                            <div class="input-group input-group-merge">
                                <input id="password" name="inp[password]" class="form-control add-credit-card-mask"
                                    type="text" placeholder="Password" required />
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bolder">Konfirmasi Password</label>
                            <div class="input-group input-group-merge">
                                <input id="password" name="password" class="form-control add-credit-card-mask"
                                    type="text" placeholder="Konfirmasi Password" required />
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-primary me-1 mt-1" onclick="save()">Submit</a>
                            <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal"
                                aria-label="Close">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ add new card modal  -->

@endsection

@section('js_section')
    <script>
        var dTable = $('#table');

        // List datatable
        $(function() {
            dTable = dTable.DataTable({
                ajax: {
                    url: "{{ url('api/admin/dt') }}",
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'id_user',
                        name: 'id_user',
                        orderable: false,
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: false,
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                ],
                buttons: []
            });

            $('.dataTables_filter input[type=search]').attr('placeholder', 'Pencarian').attr('class',
                'form-control form-control-sm');
            $('.dataTables_filter select[name=table_length]').attr('class', 'form-select form-select-sm');
            $('.dt-buttons').append(
                '<button class="btn btn-primary btn-sm" style="height: 30px; width: auto;" onclick="add()">Tambah Baru</button>'
            );
        })

        function add() {
            _reset();
            $("#frmbox").modal('show');
        }

        function save() {
            if ($("#frm").valid()) {
                var formData = new FormData($('#frm')[0]);

                $.ajax({
                    url: '{{ url('api/admin') }}',
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
                            dTable.draw();
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

        function edit(id) {
            _reset();
            $.ajax({
                url: '{{ url('api/admin/') }}' + "/" + id,
                type: 'get',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(e) {
                    const data = {
                        id: e.id_user,
                        text: e.user_name
                    };

                    const newOption = new Option(data.text, data.id, false, false);
                    $('#id_user').prop("selected", false).append(newOption).parent().trigger('change');
                    $('#id_user').next().find('.select2-selection').addClass('disable-form');
                    $('#id_user').attr('readonly', true);

                    $.each(e, function(key, value) {
                        if ($('#' + key).hasClass("select2")) {
                            $('#' + key).val(value).trigger('change');
                            // $('#' + key).attr('disabled', true);
                        } else if ($('input[type=radio]').hasClass(key)) {
                            if (value != "") {
                                $("input[name='inp[" + key + "]'][value='" + value + "']").prop(
                                    'checked', true);
                                $.uniform.update();
                            }
                        } else if ($('input[type=checkbox]').hasClass(key)) {
                            if (value != null) {
                                var temp = value.split('; ');
                                for (var i = 0; i < temp.length; i++) {
                                    $("input[name='inp[" + key + "][]'][value='" + temp[i] + "']").prop(
                                        'checked', true);
                                }
                                $.uniform.update();
                            }
                        } else {
                            $('#' + key).val(value);
                        }
                    });

                    $("#frmbox").modal('show');
                }
            });

        }

        function del(id) {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data Akan Dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('api/admin/') }}' + "/" + id,
                        type: 'delete',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(e) {
                            if (e.status == 'success') {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'bottom-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal
                                            .resumeTimer)
                                    }
                                });

                                Toast.fire({
                                    icon: 'success',
                                    title: e.message
                                });
                                dTable.draw();
                            } else {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'bottom-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal
                                            .resumeTimer)
                                    }
                                });

                                Toast.fire({
                                    icon: 'error',
                                    title: e.message
                                });
                            }
                        }
                    });
                }
            })
            _reset();
        }
    </script>
@endsection
