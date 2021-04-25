@extends('adminlte::layouts.app')
@section('title', 'HASTA: '.$patient->name)

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
        $('#detection_date').inputmask("99/99/2021", {"clearIncomplete": true})
        $('#ex_date').inputmask("99/99/9999", {"clearIncomplete": true})
        $('#healing_date').inputmask("99/99/2021", {"clearIncomplete": true})
        $('#gsm').inputmask("0(999) 999 9999", {"clearIncomplete": true})
        $('#age').inputmask("99", {"clearIncomplete": true})
        $('#tckn').inputmask("99999999999", {"clearIncomplete": true})

        $("#is_health_personnel").bootstrapSwitch();
        $("#has_mutation").bootstrapSwitch();
        $("#pcr_status").bootstrapSwitch();
        var contactedSwitch = $("#contacted_status").bootstrapSwitch();

        $(document).ready(function () {

            $('select#contact_origin_id').on('select2:select', function (e) {
                var data = e.params.data;
                if (data.id == 1) {
                    $('.contact_origin_id_row').removeClass('d-none');
                } else {
                    $('.contact_origin_id_row').addClass('d-none');
                }
            });

            var contact_origin_id = {'id': {{$patient->contact_origin_id}}};
            $('select#contact_origin_id').trigger({
                type: 'select2:select',
                params: {
                    data: contact_origin_id
                }
            });

            $('select#patient_status_id').on('select2:select', function (e) {
                var data = e.params.data;
                if (data.id == 8) {
                    $('.ex_date_row').removeClass('d-none');
                } else {
                    $('.ex_date_row').addClass('d-none');
                }

                var healed_statusses = ["7"]; //Iyilesti
                var search = $.inArray(data.id, healed_statusses);
                if (search != -1) {
                    $('.healing_date_row').removeClass('d-none');
                } else {
                    $('.healing_date_row').addClass('d-none');
                }
            });

            var patient_status_id = {'id': "{{$patient->patient_status_id}}"};
            $('select#patient_status_id').trigger({
                type: 'select2:select',
                params: {
                    data: patient_status_id
                }
            });

            $('#is_health_personnel').on('switchChange.bootstrapSwitch', function (event, state) {
                //Selected
                if (event.selected != 'undefined') {
                    if (event.selected == 1) {
                        state = true;
                    }
                }
                if (state === true) {
                    $('.health_personnel_profession_id_row').removeClass('d-none');
                } else {
                    $('.health_personnel_profession_id_row').addClass('d-none');
                }
            });

            $('#pcr_status').on('switchChange.bootstrapSwitch', function (event, state) {
                //Selected
                if (event.selected != 'undefined') {
                    if (event.selected == 1) {
                        state = true;
                    }
                }
                if (state === true) {
                    $('.has_mutation_id_row').removeClass('d-none');
                    $('#contacted_status').bootstrapSwitch('state', false, false);
                } else {
                    $('.has_mutation_id_row').addClass('d-none');
                    $('#contacted_status').bootstrapSwitch('state', true, false);
                }
            });
            $('#contacted_status').on('switchChange.bootstrapSwitch', function (event, state) {
                //Selected
                if (event.selected != 'undefined') {
                    if (event.selected == 1) {
                        state = true;
                    }
                }
                if (state === true) {
                    $('#pcr_status').bootstrapSwitch('state', false, false);
                } else {
                    $('#pcr_status').bootstrapSwitch('state', true, false);
                }
            });

            $('input#extended_qurantine_end_days').on('keyup change paste',function (){
                if($(this).val() != ''){
                    $('.extended_qurantine_end_days_btn').prop('disabled',false)
                }else {
                    $('.extended_qurantine_end_days_btn').prop('disabled',true)

                }

                var patient_status = $('select#patient_status_id');
                if(patient_status.val() == 7){

                    $(patient_status).val("").trigger('change');
                    $(patient_status).trigger({
                        type: 'select2:select',
                        params: {
                            data: ''
                        }
                    });
                }
            });

            var is_health_personnel = "{{$patient->is_health_personnel}}";
            $('#is_health_personnel').trigger({
                type: 'switchChange.bootstrapSwitch',
                selected: is_health_personnel
            });


            var pcr_status = "{{$patient->pcr_status}}";
            $('#pcr_status').trigger({
                type: 'switchChange.bootstrapSwitch',
                selected: pcr_status
            });

        });

        $('#village_id').on('change', function () {
            if ($(this).val() == '') {
                return;
            }
            var url = '{{ route("districts.neighborhoods", ":village_id") }}';
            url = url.replace(':village_id', $(this).val());
            laravel.ajax.send({
                url: url,
                type: 'POST',
                data: {},
                beforeSend: function () {
                    $('select#neighborhood_id option:first').text('Mahalleler getiriliyor...');
                    // @todo select2 text degismiyor
                },
                success: function (data) {
                    $(function () {
                        $('.select2bs4').select2({
                            theme: 'bootstrap4'
                        })
                    });
                    $('.neighborhood_holder').html(data.neighborhoods);
                    var selected = $('select#neighborhood_id option[value="' + {{$patient->neighborhood_id}} + '"]');
                    if (selected.length == 1) {
                        $('select#neighborhood_id').val({{$patient->neighborhood_id}});
                        $('select#neighborhood_id').trigger('change');

                    }
                },
                error: laravel.ajax.errorHandler
            });
        });

        $('select#village_id').val({{$patient->village_id}});
        $('select#village_id').trigger('change');

    </script>

    <script src="{{ asset('js/jquery.formautofill.js') }}"></script>
    <script>
        $("#patient_edit").autofill({!! $patient->toJson() !!});
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
        <form class="form-horizontal ajax" action="{{route('patient.update',$patient->id)}}" method="post"
              id="patient_edit"
              name="patient_edit">
            @method('PUT')
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Hasta: <strong>{{$patient->name}}</strong></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="" data-original-title="Kucult">
                                    <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"
                                        data-toggle="tooltip" title="" data-original-title="Kapat">
                                    <i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">Hasta Adı</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tckn" class="col-sm-3 col-form-label">Hasta T.C.</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="tckn" name="tckn">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="age" class="col-sm-3 col-form-label">Yaşı</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="age" name="age">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="gsm" class="col-sm-3 col-form-label">Telefon</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="gsm" name="gsm">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="detection_date" class="col-sm-3 col-form-label">Tespit Tarihi</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="detection_date"
                                               name="detection_date">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bt_id" class="col-sm-3 col-form-label">BT</label>
                                    <div class="col-sm-7">
                                        {{viewHelper(\App\ViewHelpers\SelectBox\BtSelectBox::class)}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="village_id" class="col-sm-3 col-form-label">Mahalle/Köy</label>
                                    <div class="col-sm-7">
                                        {{viewHelper(\App\ViewHelpers\SelectBox\VillagesSelectBox::class)}}
                                        <small id="emailHelp" class="form-text text-muted">Merkez mahalleler için
                                            MERKEZ-MERKEZ seçiniz.</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="neighborhood_id" class="col-sm-3 col-form-label">Mahalle</label>
                                    <div class="col-sm-7 neighborhood_holder">
                                        <select class="form-control" id="neighborhood_id" name="neighborhood_id">
                                            <option>Mahalle/Köy Seçiniz</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-3 col-form-label">Adres</label>
                                    <div class="col-sm-7">
                                        <textarea class="form-control" name="address" id="address"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group row mb-0" style="float: right">

                                <div class="col-sm-12 ">
                                    <button type="submit" class="btn btn-dark ajax_btn">Hasta Güncelle</button>
                                    <a href="{{route('patient.index')}}" class="btn btn-default">İptal Et</a>
                                </div>
                            </div>


                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-procedures"></i></span> Hasta Detayi</h3>
                            <div class="card-tools">
                                @if(auth()->user()->can('vaccines'))
                                    <a class="btn btn-flat btn-dark btn-sm"
                                       href="{{route('patient.vaccines', [$patient->id])}}" data-toggle="tooltip"
                                       data-placement="top" title="" data-original-title="Aşılar">
                                        <i class="fa fas fa-syringe"></i> Aşılar</a>
                                @endif
                                @if(auth()->user()->can('daily_checks'))
                                    <a class="btn btn-flat btn-dark btn-sm"
                                       href="{{route('patient.daily_checks', [$patient->id])}}" data-toggle="tooltip"
                                       data-placement="top" title="" data-original-title="Denetimler">
                                        <i class="fa fas fa-user-check"></i> Denetimler</a>
                                @endif
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="contacted_status" class="col-sm-5 col-form-label">TEMASLI / PCR</label>
                                    <div class="col-sm-7">
                                        <input type="checkbox" id="contacted_status" name="contacted_status"
                                               data-on-text="Evet" data-off-text="Hayir" data-on-color="success"
                                               data-off-color="danger"
                                               value="1" {{$patient->contacted_status ?'checked':0}}>

                                        <input type="checkbox" id="pcr_status" name="pcr_status"
                                               data-on-text="pozitif" data-off-text="negatif" data-on-color="success"
                                               data-off-color="danger" value="1" {{$patient->pcr_status ?'checked':''}}>
                                    </div>
                                </div>
                                <div class="form-group row  has_mutation_id_row d-none">
                                    <label for="has_mutation" class="col-sm-5 col-form-label">Mutasyon</label>
                                    <div class="col-sm-7">
                                        <input type="checkbox" id="has_mutation" name="has_mutation"
                                               data-on-text="Evet" data-off-text="Hayır" data-on-color="success"
                                               data-off-color="danger"
                                               value="1" {{$patient->has_mutation ?'checked':''}}>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="contact_place_id" class="col-sm-5 col-form-label">Temas Yeri</label>
                                    <div class="col-sm-7">
                                        {{viewHelper(\App\ViewHelpers\SelectBox\ContactPlaceSelectBox::class)}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="is_health_personnel" class="col-sm-5 col-form-label">Sağlık Personeli mi
                                        ?</label>
                                    <div class="col-sm-7">
                                        <input type="checkbox" id="is_health_personnel" name="is_health_personnel"
                                               data-on-text="Evet" data-off-text="Hayır" data-on-color="success"
                                               data-off-color="danger"
                                               value="1" {{$patient->is_health_personnel ?'checked':''}}>
                                    </div>
                                </div>
                                <div class="form-group row health_personnel_profession_id_row d-none">
                                    <label for="health_personnel_profession_id" class="col-sm-5 col-form-label">Sağlık
                                        Personeli İse Görevi</label>
                                    <div class="col-sm-7">
                                        {{viewHelper(\App\ViewHelpers\SelectBox\HealthPersonnelProfessionSelectBox::class)}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="contact_origin_id" class="col-sm-5 col-form-label">Temas Orjin</label>
                                    <div class="col-sm-7">
                                        {{viewHelper(\App\ViewHelpers\SelectBox\ContactOriginSelectBox::class)}}
                                    </div>
                                </div>
                                <div class="form-group row contact_origin_id_row d-none">
                                    <label for="contact_origin_patient_id" class="col-sm-5 col-form-label">Asıl Vaka Adı
                                        Soyadı</label>
                                    <div class="col-sm-7">
                                        {{viewHelper(\App\ViewHelpers\SelectBox\PatientsListSelectBox::class)}}
                                    </div>
                                </div>
                                <div class="form-group row contact_origin_id_row d-none">
                                    <label for="relationship_to_main_case_id" class="col-sm-5 col-form-label">Asıl
                                        Vakaya
                                        Yakınlık</label>
                                    <div class="col-sm-7">
                                        {{viewHelper(\App\ViewHelpers\SelectBox\RelationshipToMainCaseSelectBox::class)}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="contacted_count" class="col-sm-5 col-form-label">Temaslı Sayısı</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" id="contacted_count"
                                               name="contacted_count">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="contacted_pcr_positive_count" class="col-sm-5 col-form-label">Temaslılardan
                                        PCR Pozitif Sayısı</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" id="contacted_pcr_positive_count"
                                               name="contacted_pcr_positive_count">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="patient_status_id" class="col-sm-5 col-form-label">Durumu</label>
                                    <div class="col-sm-7">
                                        {{viewHelper(\App\ViewHelpers\SelectBox\PatientStatusSelectBox::class)}}
                                    </div>
                                </div>
                                <div class="form-group row ex_date_row d-none">
                                    <label for="ex_date" class="col-sm-5 col-form-label">EX Tarihi</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="ex_date" name="ex_date">
                                    </div>
                                </div>
                                <div class="form-group healing_date_row row d-none">
                                    <label for="healing_date" class="col-sm-5 col-form-label">İyileşme Tarihi</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="healing_date" name="healing_date">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="workplace" class="col-sm-5 col-form-label">İş Yeri</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="workplace" name="workplace">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="main_case_workplace" class="col-sm-5 col-form-label">Varsa Asıl Vaka İş
                                        Yeri</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="main_case_workplace"
                                               name="main_case_workplace">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="description" class="col-sm-5 col-form-label">Açıklama</label>
                                    <div class="col-sm-7">
                                        <textarea class="form-control" name="description" id="description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group row mb-0" style="float: right">

                                <div class="col-sm-12 ">
                                    <button type="submit" class="btn btn-dark ajax_btn">Hasta Güncelle</button>
                                    <a href="{{route('patient.index')}}" class="btn btn-default">İptal Et</a>
                                </div>
                            </div>


                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title"><span class="fa fa-calendar-alt"></span> Karantina Süreci</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="" data-original-title="Kucult">
                                    <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"
                                        data-toggle="tooltip" title="" data-original-title="Kapat">
                                    <i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($patient->isQuarantineCompleted === true)
                                <div class="alert alert-success alert-dismissible">
                                    Karantina Süresi Tamamlandı
                                </div>
                            @endif

                            <div class="info-box bg-warning">
                                <span class="info-box-icon">{{$patient->quarantinePeriod}} Gün</span>

                                <div class="info-box-content">
                                    <span
                                        class="info-box-number">{{\Carbon\Carbon::parse($patient->quarantine_start_date)->formatLocalized('%d %B %Y %A')}}</span>
                                    <span
                                        class="info-box-number">{{\Carbon\Carbon::parse($patient->quarantine_end_date)->formatLocalized('%d %B %Y %A')}}</span>

                                    <div class="progress" style="height: 15px">
                                        <div class="progress-bar"
                                             style="width: {{$patient->quarantinePeriodCurrentPercent}}%"></div>
                                    </div>
                                    @if($patient->isQuarantineCompleted === false)
                                        <span class="progress-description">Bitmesine <strong>{{$patient->quarantinePeriodToEnd}} Gün</strong> Kaldı</span>
                                    @endif
                                </div>
                                <!-- /.info-box-content -->
                            </div>

                        </div>
                        <div class="card-footer">
                            <form action="#" method="post">
                                <div class="input-group">
                                    <input type="number" name="extended_qurantine_end_days"  id="extended_qurantine_end_days" placeholder="Gün" class="form-control">
                                    <span class="input-group-append">
                                      <button type="submit" class="btn btn-warning extended_qurantine_end_days_btn" disabled>Karantina Süresini Uzat</button>
                                    </span>
                                </div>
                            </form>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->

@endsection
