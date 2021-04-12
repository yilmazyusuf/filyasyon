@extends('adminlte::layouts.app')
@section('title', config('app.name'))

@push('scripts')
    <!--Custom Scripts -->
@endpush
@push('styles')
    <!--Custom Styles -->
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid"></div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hospital-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Hasta Sayısı</span>
                            <span class="info-box-number">10<small>%</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-procedures"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Evde</span>
                            <span class="info-box-number">10<small>%</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-viruses"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">İyileşen</span>
                            <span class="info-box-number">10<small>%</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-heartbeat"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">EX</span>
                            <span class="info-box-number">10<small>%</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Default box -->

                    <!-- /.card -->
                </div>
            </div>
        </div>


    </section>
    <!-- /.content -->
@endsection
