@extends('layouts.layout')

@section('css_section')

@endsection

@section('page_title')
    Kelola Produk
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('master.item.index') }}
@endsection

@section('url_back', url('dashboard'))

@section('content')
    <div class="card">
        <div class="card-header">
            <a data-action="collapse" class="d-flex align-items-center justify-content-center rotate">
                {{-- <i class="bx bx-calendar-edit me-50" style="font-size: 20px;"></i> --}}
                <span class="w-100 fw-bolder" style="font-size: 15px; cursor: pointer;">
                    Kategori Produk
                </span>
            </a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse" class="rotate"><i data-feather="chevron-down"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse" aria-expanded="false">
            <hr class="my-0" style="height: 2.5px; background-color: #F8F8F8;">
            <div class="accordion-body mt-0 pt-0">
                <div class="table-responsive" id="tableCategory">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive" id="tableItem">
            <table class="table table-striped" id="table2">
                <thead>
                    <tr>
                        <th style="min-width: 70px;">Tanggal</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                        <th>Kategori Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th width="10%">Detail</th>
                        <th width="12%">Aksi</th>
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
                    <h1 class="text-center mb-1" id="frmbox-title">Tambah Kategori</h1>
                    <form autocomplete="off" id="frm" class="row gy-1 gx-2 mt-75">
                        @csrf
                        <div class="col-12">
                            <div class="input-group input-group-merge">
                                <input name="inp[id]" id="id" hidden>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bolder">Kategori</label>
                            <div class="input-group input-group-merge">
                                <input id="category_name" name="inp[category_name]"
                                    class="form-control add-credit-card-mask" type="text" placeholder="Kategori Item"
                                    required />
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-primary me-1 mt-1" onclick="save()">Simpan</a>
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
        var tableCategory = $('#table1');
        var tableItem = $('#table2'),
            select = $('.select2')
        // List datatable
        $(function() {
            tableItem = tableItem.DataTable({
                ajax: {
                    url: "{{ url('api/item/dt') }}",
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                    data: 'updated_at',
                    name: 'updated_at'
                }, {
                    data: 'item_name',
                    name: 'item_name'
                }, {
                    data: 'item_desc',
                    name: 'item_desc'
                }, {
                    data: 'image',
                    name: 'image'
                }, {
                    data: 'categories',
                    name: 'categories'
                }, {
                    data: 'item_price',
                    name: 'item_price'
                }, {
                    data: 'item_stock',
                    name: 'item_stock'
                }, {
                    data: 'detail',
                    name: 'detail',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }, {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }, ],
                order: [
                    [0, 'asc']
                ],
                buttons: []
            });

            tableCategory = tableCategory.DataTable({
                ajax: {
                    url: "{{ url('api/category/dt') }}",
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                    data: 'category_name',
                    name: 'category_name'
                }, {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }, ],
                order: [
                    [0, 'asc']
                ],
                buttons: [],
            });

            $('.dataTables_filter input[type=search]').attr('placeholder', 'Pencarian').attr('class',
                'form-control form-control-sm');
            $('.dataTables_filter select[name=table_length]').attr('class', 'form-select form-select-sm');
            $('#tableCategory').find('.dt-buttons').append(
                '<button class="btn btn-primary btn-sm" style="height: 30px; width: auto;" onclick="add()">Tambah Baru</button>'
            );
            $('#tableItem').find('.dt-buttons').append(
                '<a href="{{ route('item.add') }}"><button class="btn btn-primary btn-sm" style="height: 30px; width: auto;" onclick="">Tambah Baru</button></a>'
            );
        })

        function add() {
            _reset();
            $("#frmbox-title").html('Tambah Kategori');
            $("#frmbox").modal('show');
        }

        function save() {
            if ($("#frm").valid()) {
                var formData = new FormData($('#frm')[0]);

                $.ajax({
                    url: '{{ url('api/category') }}',
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
                            tableCategory.draw();
                            tableItem.draw();
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
                url: '{{ url('api/category/') }}' + '/' + id,
                type: 'get',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(e) {
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

                    $("#frmbox-title").html('Ubah Kategori');
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
                cancelButtonText: 'Kembali',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('api/category/') }}' + '/' + id,
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
                                tableCategory.draw();
                                tableItem.draw();
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

        function delItem(id) {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data Akan Dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Kembali',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('api/item/') }}' + '/' + id,
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
                                tableItem.draw();
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
        }
    </script>

@endsection
