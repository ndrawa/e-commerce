@extends('layouts.layout')

@section('css_section')
    <style>
        #fixedbutton {
            position: absolute;
            right: 30px;
            bottom: 20px;
        }
    </style>
@endsection

@section('page_title')
    Produk
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('buy.items.index') }}
@endsection

@section('url_back', url('dashboard'))

@section('content')

    @foreach ($items as $item)
        @if ($item->item_stock > 0)
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-8">

                            <h4>{{ $item->item_name }}</h4>
                            {{-- table --}}
                            <table class="table table-borderless">
                                <tr>
                                    <td>Harga</td>
                                    <td>:</td>
                                    <td>{{ $item->item_price }}</td>
                                </tr>
                                <tr>
                                    <td>Stok</td>
                                    <td>:</td>
                                    <td>{{ $item->item_stock }}</td>
                                </tr>
                                <tr>
                                    <td>Kategori</td>
                                    <td>:</td>
                                    <td>
                                        @foreach ($item->categories as $key => $category)
                                            {{ $category->categories->category_name }}
                                            @if ($key != count($item->categories) - 1)
                                                <span>,</i></span>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>Deskripsi</td>
                                    <td>:</td>
                                    <td>{!! $item->item_desc !!}</td>
                                </tr>
                            </table>

                            {{-- Buy Item --}}
                            <div id="fixedbutton" class="row">
                                <form autocomplete="off" id="frm" class="row gy-1 gx-2 mt-75">
                                    @csrf
                                    <input name="item_id" id="item_id" value="{{ $item->id }}" hidden>
                                    <div class="col-8">
                                        <input id="quantity" name="quantity" class="form-control add-credit-card-mask"
                                            type="number" placeholder="Jumlah Produk" required />
                                    </div>
                                    <div class="col-4 text-center">
                                        <a class="btn btn-primary" onclick="save()">Beli</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

@endsection

@section('js_section')
    <script></script>
    <script>
        function save() {
            if ($("#frm").valid()) {
                for (var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();

                    //check ckeditor null
                    var messageLength = CKEDITOR.instances[instanceName].getData().replace(/<[^>]*>/gi, '').length;
                    if (!messageLength) {
                        alert('Harap isi kolom deskripsi!');
                        e.preventDefault();
                    }
                }
                var formData = new FormData($('#frm')[0]);

                $.ajax({
                    url: "{{ url('api/buy') }}" + '/' + $('#item_id').val() + '/' + $('#quantity').val(),
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
                            _reset();
                            location.reload();


                            //clear data
                            // if (window.location.href == "{{ route('item.add') }}") {
                            //     $('#image-preview').attr('src', "<?php echo url('images/no-preview.jpeg'); ?>");
                            //     _reset();
                            // }
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
