@extends('layouts.landing.layout')

@section('css_section')
@endsection

@section('page_title')
    Item Detail
@endsection

@section('content')
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            {{-- Show Detail --}}
            <div class="container-xxl pb-4 pt-0">
                <h3>{{ $item->item_name }}</h3>
                <p class="fw-bold mb-50">
                    @foreach ($item->categories as $key => $category)
                        <a href="{{ route('home.item') . '?category=' . $category->category_id }}"><span
                                class="badge rounded-pill bg-secondary">{{ App\Models\Category::find($category->category_id)->category_name }}
                            </span></a>
                    @endforeach
                </p>
                <small>Terakhir diperbarui <span
                        class="fw-bold">{{ $item->updated_at ? $item->updated_at->diffForHumans() : ($item->created_at ? $item->created_at->diffForHumans() : '-') }}</span></small>
                <div class="row">
                    <div class="col-md-12">
                        <img class="rounded" style='float:left; max-height: auto; width:50%; margin:20px 27px 10px 0px;'
                            src="{{ $item->image_path }}" />
                        <p> {!! $item->item_desc !!} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
