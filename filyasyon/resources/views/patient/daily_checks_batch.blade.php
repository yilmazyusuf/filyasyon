@extends('adminlte::layouts.app')
@section('title', 'Günlük Denetimler')

@push('scripts')
    <!--Custom Scripts -->

    <script src="{{ asset('vendor/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
    <!-- InputMask -->
    <script src="{{ asset('vendor/adminlte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ asset('vendor/adminlte/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

    <script>
        $('.check_hour').inputmask("99:99", {"clearIncomplete": true})
    </script>
@endpush
@push('styles')
    <!--Custom Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <style>
        .table-bordered td, .table-bordered th {
            border: 1px solid rgb(51 59 63 / 30%) !important;
        }

        .table td, .table th {

            border-top: none !important;
            border-left: none !important;
        }

        table.dataTable tbody tr.selected {
            background-color: rgb(60 141 188 / 20%) !important;
        }

        table.dataTable tbody tr:hover {
            background-color: rgb(60 141 188 / 20%) !important;
        }

        table.dataTable tbody tr {
            cursor: pointer;
        }
    </style>
@endpush
@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Main content -->
    <section class="content pt-3">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><strong>{{date('d/m/Y')}}</strong> Denetim Kaydı Ekle</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            @php
            @endphp
            <form class="form-horizontal ajax" action="{{url()->full()}}"
                  method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="check_hour_0" class="col-sm-5 col-form-label">1. Denetim</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control check_hour" id="check_hour_0"
                                           name="check_hour[0]"
                                           value="{{isset($todaysChecks[0]) ? date('H:i',strtotime($todaysChecks[0]['check_date'])) :''}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="check_hour_1" class="col-sm-5 col-form-label">2. Denetim</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control check_hour" id="check_hour_1"
                                           name="check_hour[1]"
                                           value="{{isset($todaysChecks[1]) ? date('H:i',strtotime($todaysChecks[1]['check_date'])) :''}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="check_hour_2" class="col-sm-5 col-form-label">3. Denetim</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control check_hour" id="check_hour_2"
                                           name="check_hour[2]"
                                           value="{{isset($todaysChecks[2]) ? date('H:i',strtotime($todaysChecks[2]['check_date'])) :''}}">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-9">
                            <table id="daily_checks"
                                   class="table table-bordered table-striped table-hover  table-head-fixed text-nowrap">
                                <thead>
                                <tr>
                                    <th>Hasta</th>
                                    <th>TC</th>
                                    <th>Son Denetim</th>
                                    <th>Bilgi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($patients as $patient)
                                    <tr style="background-color: @if($patient->isDailyCheckable()) rgb(61 153 112 / 20%) @else rgb(220 53 69 / 20%) @endif">
                                        <td>{{$patient->name}}</td>
                                        <td>{{$patient->tckn}}</td>
                                        <td>{{$patient->latestDailyCheck() ? \Illuminate\Support\Carbon::parse($patient->latestDailyCheck()->check_date)->format('d/m/Y H:i') : ''}}</td>
                                        <td> <p class="text-danger"> @if(!$patient->isDailyCheckable()) {{$patient->dailyCheckableBlockedMessage()}} Denetim saati uygulanmayacak. </p> @endif</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="form-group row mb-0" style="">

                        <div class="col-sm-12 ">

                            <button type="submit" class="btn btn-dark ajax_btn">Denetimleri Kaydet</button>
                            <a href="{{route('patient.index')}}" class="btn btn-default">İptal Et</a>


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
