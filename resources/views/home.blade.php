@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body" id="app">
                    <app></app>
                </div>
            </div>
        </div>
    </div>
</div>
    <router-view></router-view>
@endsection
