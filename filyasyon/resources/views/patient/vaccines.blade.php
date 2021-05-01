@extends('adminlte::layouts.app')
@section('title', $patient->name. ' Hasta Asilari')

@push('scripts')
    <!-- InputMask -->
    <script src="{{ asset('vendor/adminlte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<script>
    $('.vaccines').inputmask('99/99/9999', {"clearIncomplete": true})
</script>
@endpush
@push('styles')
@endpush
@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Main content -->
    <section class="content pt-3">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><strong>{{$patient->name}}</strong> Hasta asilarini duzenle</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <form class="form-horizontal ajax" action="{{route('patient.vaccines.save',[$patient->id])}}"
                  method="post">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                @php
                                $vaccines = $patient->vaccines->sortBy('vaccination_date')->toArray();
                                @endphp

                                <label for="vaccines_0" class="col-sm-5 col-form-label">1. Asi Tarihi</label>
                                <div class="col-sm-7">

                                    <input type="text" class="form-control vaccines" id="vaccines_0"
                                           name="vaccines[0]"
                                           value="{{$vaccines[0]['vaccination_date'] ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="vaccines_1" class="col-sm-5 col-form-label">2. Asi Tarihi</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control vaccines" id="vaccines_1"
                                           name="vaccines[1]"
                                           value="{{$vaccines[1]['vaccination_date'] ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="vaccines_2" class="col-sm-5 col-form-label">3. Asi Tarihi</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control vaccines" id="vaccines_2"
                                           name="vaccines[2]"
                                           value="{{$vaccines[2]['vaccination_date'] ?? '' }}">
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="form-group row mb-0" style="">

                        <div class="col-sm-12 ">
                           @if($patient->patient_status_id == 8)
                                <div class="callout callout-danger">
                                    <h5>Hasta, Vefat Etti</h5>
                                    <p>Hasta vefat ettigi icin asi bilgisi girilemez</p>
                                </div>
                            @else
                                <button type="submit" class="btn btn-dark ajax_btn">Asi Bilgilerini Kaydet</button>
                                <a href="{{route('patient.index')}}" class="btn btn-default">İptal Et</a>
                            @endif

                        </div>
                    </div>


                </div>
                <!-- /.card-footer -->
            </form>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->

@endsection
