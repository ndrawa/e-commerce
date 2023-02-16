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
    Riwayat Pembelian
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('buy.items.history') }}
@endsection

@section('url_back', url('dashboard'))

@section('content')

    @foreach ($buyItems as $buyItem)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ asset('storage/' . $buyItem->items->image) }}" alt="" class="img-fluid">
                    </div>
                    <div class="col-md-8">

                        <h4>{{ $buyItem->items->item_name }}</h4>
                        {{-- table --}}
                        <table class="table table-borderless">
                            <tr>
                                <td>Harga</td>
                                <td>:</td>
                                <td>{{ $buyItem->items->item_price }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah</td>
                                <td>:</td>
                                <td>{{ $buyItem->quantity }}</td>
                            </tr>
                            <tr>
                                <td>Kategori</td>
                                <td>:</td>
                                <td>
                                    @foreach ($buyItem->items->categories as $key => $category)
                                        {{ $category->categories->category_name }}
                                        @if ($key != count($buyItem->items->categories) - 1)
                                            <span>,</span>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td>Deskripsi</td>
                                <td>:</td>
                                <td>{!! $buyItem->items->item_desc !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <a href="{{ url('buy/items/history/detail/' . $buyItem->id) }}"
                            class="btn btn-primary btn-block">Detail</a>
                    </div>
                </div>
            </div>
        </div>
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
