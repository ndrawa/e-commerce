@extends('layouts.landing.layout')

@section('css_section')
    <style>
        .btn:focus {
            box-shadow: none !important;
        }

        .search-menu {
            width: 200%;
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

        .card-body ul {
            padding: 0;
            list-style-type: none;
        }

        h5.aside-title {
            font-weight: bolder;
        }

        .card-body ul .cat-link {
            margin-bottom: 0.25rem !important;
            padding-bottom: 0.25rem !important;
        }
    </style>
@endsection

@section('page_title')
    Produk
@endsection

@section('content')
    <div class="header-2-2 hero">
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Slide Show -->
                <div class="container-xxl pb-5 text-center">
                    <h3>Produk</h3>
                    <a>
                        Produk yang tersedia
                    </a>
                </div>

                <div class="container-xxl pb-5">
                    @if (!empty($parCategory))
                        <div class="row">
                            <div id="category-title" class="col-sm-12 col-md-8 col-lg-9">
                                <h4>Filter : {{ $parCategory }}
                                </h4>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div id="main" class="col-sm-12 col-md-8 col-lg-9">
                            <div id="item" class="row auto-clear">
                                @if (count($items) == 0)
                                    <div class="mt-1">
                                        <label>Produk Tidak Ditemukan</label>
                                    </div>
                                @endif
                                @foreach ($items as $value)
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12 my-1">
                                        <div class="card h-100">
                                            <img src="{{ $value->image_path }}" class="card-img-top"
                                                style="object-fit:cover;
                                                width:100%;
                                                height:170px;">
                                            <div class="card-body">
                                                <h5 class="card-title">{!! $value->item_name !!}</h5>
                                                <p class="card-text">{!! Str::limit(strip_tags($value->item_desc), 160) !!}</p>
                                            </div>
                                            <div class="row card-footer">
                                                <a href="{{ url('item/' . $value->id) }}"><b>Baca Selengkapnya</b></a>
                                                <small class="text-muted mt-2">
                                                    {{ $value->updated_at ? $value->updated_at->diffForHumans() : ($value->created_at ? $value->created_at->diffForHumans() : '-') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{ $items->links('pagination::bootstrap-5') }}
                        </div>
                        <div id="sidebar" class="col-sm-12 col-md-4 col-lg-3">
                            <div id="search" class="row auto-clear">
                                <div class="col-12 my-1">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title aside-title">Cari Produk</h5>
                                            <form autocomplete="off" method="GET" action="{{ route('home.item') }}">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="search"
                                                        value="{{ request()->get('search') }}"
                                                        placeholder="Ketik Pencarian">
                                                </div>
                                                <button type="submit" class="form-control btn btn-primary mt-1">
                                                    Cari
                                                </button>
                                                @if (request()->has('search'))
                                                    <a href="{{ route('home.item') }}" class="btn btn-secondary mt-1 w-100">
                                                        Reset
                                                    </a>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="category" class="row auto-clear">
                                <div class="col-12 my-1">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title aside-title">Kategori Produk</h5>
                                            <ul>
                                                @if ($categories->count() == 0)
                                                    <li class="cat-link">
                                                        <a href="#">Tidak Ada Kategori</a>
                                                    </li>
                                                @else
                                                    @foreach ($categories as $value)
                                                        <li
                                                            class="cat-link @if (request()->get('category') == $value->id) active-text @endif">
                                                            <a
                                                                href="{{ route('home.item') . '?category=' . $value->id }}">{{ $value->category_name }}</a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                            @if (request()->has('category'))
                                                <a href="{{ route('home.item') }}" class="btn btn-secondary mt-1 w-100">
                                                    Reset
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
@section('js_section')
@endsection
