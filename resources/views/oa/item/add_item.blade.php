@extends('layouts.layout')

@section('css_section')

@endsection

@section('page_title')
    Tambah Produk
@endsection

@php
    $url = url()->current();
    $exp = explode('/', $url);
    $url = array_slice($exp, 3);
@endphp

@section('breadcrumbs')
    @if (end($url) == 'add')
        {{ Breadcrumbs::render('master.item.add') }}
    @else
        {{ Breadcrumbs::render('master.item.edit') }}
    @endif
@endsection

@section('url_back', url('master/item'))

@section('content')
    <div class="card">
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                <div class="px-sm-5 mx-50 pb-5">
                    <form autocomplete="off" id="frm" class="row gy-1 gx-2 mt-75">
                        @csrf
                        <div class="col-12">
                            <div class="input-group input-group-merge">
                                <input name="inp[id]" id="id" hidden value="{{ $item->id }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bolder">Nama</label>
                            <div class="input-group input-group-merge">
                                <input id="item_name" name="inp[item_name]" class="form-control add-credit-card-mask"
                                    type="text" value="{{ $item->item_name }}" placeholder="Nama Item" required />
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bolder">Gambar Utama</label>
                            <input type="hidden" name="hidden_image" id="hidden_image" value="{{ $item->image }}" />
                            <div class="input-group input-group-merge">
                                <input id="image" name="inp[image]" class="form-control add-credit-card-mask"
                                    type="file" accept="image/*" value="{{ $item->image }}"
                                    @if (!$item->image) required @endif />
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bolder">Preview Gambar</label>
                            <div class="form-group">
                                @php
                                    $driver = env('FILESYSTEM_DISK');
                                    if (!empty($item->image)) {
                                        $storage_url = ($driver ?? 'public') == 'minio' ? Storage::temporaryUrl($item->image, Carbon\Carbon::now()->addMinutes(20)) : Storage::url($item->image);
                                    }
                                @endphp
                                <img id="image-preview"
                                    src="{{ !empty($item->image) ? $storage_url : url('images/no-preview.jpeg') }}"
                                    style="max-height: 200px; width: auto;" />
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bolder">Harga</label>
                            <div class="input-group input-group-merge">
                                <input id="item_price" name="inp[item_price]" class="form-control add-credit-card-mask"
                                    type="number" value="{{ $item->item_price }}" placeholder="Harga Produk" required />
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bolder">Jumlah</label>
                            <div class="input-group input-group-merge">
                                <input id="item_stock" name="inp[item_stock]" class="form-control add-credit-card-mask"
                                    type="number" value="{{ $item->item_stock }}" placeholder="Jumlah Produk" required />
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="wysiwyg-editor" class="form-label fw-bolder">Deskripsi</label>
                            <div class="form-group">
                                <textarea class="form-control" id="desc-editor" name="inp[item_desc]" required>{{ $item->item_desc }}</textarea>
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label fw-bolder">Kategori Item</label>
                            <select multiple name="category_ids[]" id="category_id" class="select2"
                                data-rule-required="true" data-msg-required="Please select an item!">
                                @foreach ($categories as $value)
                                    <option value="{{ $value->id }}"
                                        @foreach ($item->categories as $category)
                                            @if ($value->id == $category->category_id)
                                                selected
                                            @endif @endforeach>
                                        {{ $value->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="mt-25 form-label d-block" for="">*Ketik dan tekan Enter untuk menambahkan
                                kategori produk baru</label>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-primary me-1 mt-1" onclick="save()">Simpan</a>
                            <a class="btn btn-outline-secondary mt-1" href="{{ url('master/item') }}">
                                Batalkan
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_section')
    <script>
        var select = $('.select2');

        $(function() {
            select = $(select).select2({
                placeholder: "Pilih Kategori Item",
                tags: true,
                dropdownParent: $("#frm")
            }).on("change", function(e) {
                $(this).valid(); //jquery validation script validate on change
            }).on("select2:open", function() { //correct validation classes (has=*)
                if ($(this).parents("[class*='has-']").length) { //copies the classes
                    var classNames = $(this).parents("[class*='has-']")[0].className.split(/\s+/);

                    for (var i = 0; i < classNames.length; ++i) {
                        if (classNames[i].match("has-")) {
                            $("body > .select2-container").addClass(classNames[i]);
                        }
                    }
                } else { //removes any existing classes
                    $("body > .select2-container").removeClass(function(index, css) {
                        return (css.match(/(^|\s)has-\S+/g) || []).join(' ');
                    });
                }
            });
        })
    </script>
    <script type="text/javascript">
        var editor = CKEDITOR.replace('inp[item_desc]', {
            filebrowserUploadUrl: "{{ route('ckeditor.image-upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            language: 'en',
            extraPlugins: 'notification'
        });
        editor.on('required', function(evt) {
            editor.showNotification('This field is required.', 'warning');
            evt.cancel();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(e) {
            $('#image').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
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
                    url: '{{ url('api/item') }}',
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
                            window.location = '{{ url('master/item') }}';


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
