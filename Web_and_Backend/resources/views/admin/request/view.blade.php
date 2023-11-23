@extends('admin.template')
@section('main')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
        Quản lý Ride Requests
        <small>Bảng điều khiển</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(LOGIN_USER_TYPE.'/dashboard') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li class="active">Ride Requests</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header" style="height: 54px;">
                        <!-- <h3 class="box-title"> Quản lý Ride Requests </h3> -->
                    </div>
                    <div class="box-body">
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
    <link rel="stylesheet" href="{{ url('css/buttons.dataTables.css') }}">
    <script src="{{ url('js/dataTables.buttons.js') }}"></script>
    <script src="{{ url('js/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}
@endpush