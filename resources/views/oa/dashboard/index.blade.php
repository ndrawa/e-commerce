@extends('layouts.layout')

@section('css_section')
    <style>
        .blur-bg {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 2px 6px 2px 6px;
            border-radius: 5px;
        }
    </style>
@endsection

@section('page_title')
    Dashboard
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard.index') }}
@endsection

@section('content')
    <div class="">
        <div class="content-body">
            <div class="row">
                <div class="col-sm-12">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_section')
    <script></script>
@endsection
