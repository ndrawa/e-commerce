@extends('layouts.landing.layout')

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
    Beranda
@endsection

@section('content')
    <div class="header-2-2 hero">
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                <div class="card container-xxl my-3">
                    <div class="py-2 text-center">
                        <h3>Aplikasi E-commerce</h3>
                        <div class="desc mt-1">
                            <p>Ini adalah aplikasi e-commerce yang dibuat dengan Laravel 9 dan Bootstrap</p>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="container-xxl mt-3 text-center">

                </div>
            </div>
        </div>
    </div>
@endsection
