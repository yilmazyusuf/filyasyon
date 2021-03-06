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
            <form class="form-horizontal ajax" action="{{route('patient.daily_checks.save',[$patient->id])}}"
                  method="post">
                <div class="card-body">

                    @php
                        $todaysChecks = $patient->todaysChecks()
                    @endphp

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
                                    <th>Tarih</th>
                                    <th>1. Denetim</th>
                                    <th>2. Denetim</th>
                                    <th>3. Denetim</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($patient->groupDailyCheckByHour()  as $checkDate => $checkHour)
                                    @php
                                        $checkHours = collect($checkHour);
                                        $checkHours = $checkHours->sort()->toArray();
                                        $checkHours = array_values($checkHours);

                                    @endphp

                                    <tr>
                                        <td>{{date('d/m/Y',strtotime($checkDate))}}</td>
                                        <td>{{isset($checkHours[0]) ? \Carbon\Carbon::parse($checkHours[0])->format('H:i') : ''}}</td>
                                        <td>{{isset($checkHours[1]) ? \Carbon\Carbon::parse($checkHours[1])->format('H:i') : ''}}</td>
                                        <td>{{isset($checkHours[2]) ? \Carbon\Carbon::parse($checkHours[2])->format('H:i') : ''}}</td>

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
                            @if($patient->isDailyCheckable())
                                <button type="submit" class="btn btn-dark ajax_btn">Denetimleri Kaydet</button>
                                <a href="{{route('patient.index')}}" class="btn btn-default">İptal Et</a>
                                @else
                                    <div class="callout callout-danger">
                                        <h5>Denetim girilemez !</h5>
                                        <p>{{$patient->dailyCheckableBlockedMessage()}}</p>
                                    </div>
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
