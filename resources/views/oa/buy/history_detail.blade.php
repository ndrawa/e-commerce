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

{{-- @section('breadcrumbs')
    {{ Breadcrumbs::render('buy.items.history.detail') }}
@endsection --}}

@section('url_back', url('dashboard'))

@section('content')
    <div class="card pt-3 px-2">
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                {{-- Show Detail --}}
                <div class="container-xxl pb-4 pt-0">
                    <h3>{{ $buyItem->items->item_name }}</h3>
                    <p class="fw-bold mb-50">
                        @foreach ($buyItem->items->categories as $key => $category)
                            <a href="{{ route('home.item') . '?category=' . $category->category_id }}"><span
                                    class="badge rounded-pill bg-secondary">{{ App\Models\Category::find($category->category_id)->category_name }}
                                </span></a>
                        @endforeach
                    </p>
                    <small>Pembelian dilakukan <span
                            class="fw-bold">{{ $buyItem->updated_at ? $buyItem->updated_at->diffForHumans() : ($buyItem->created_at ? $buyItem->created_at->diffForHumans() : '-') }}</span></small>
                    <div class="row">
                        <div class="col-md-12">
                            <img class="rounded" style='float:left; max-height: auto; width:50%; margin:20px 27px 10px 0px;'
                                src="{{ $buyItem->items->image_path }}" />
                            <p> {!! $buyItem->items->item_desc !!} </p>
                            <p> Harga : <span class="fw-bold">Rp.
                                    {{ number_format($buyItem->items->item_price, 0, ',', '.') }}
                                </span></p>
                            <p> Jumlah : <span class="fw-bold">{{ $buyItem->quantity }}</span></p>
                            <p> Total : <span class="fw-bold">Rp.
                                    {{ number_format($buyItem->items->item_price * $buyItem->quantity, 0, ',', '.') }}
                                </span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
