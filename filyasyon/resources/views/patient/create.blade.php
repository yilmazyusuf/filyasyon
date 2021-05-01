@extends('adminlte::layouts.app')
@section('title', 'HASTA Kaydet')

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
        $("#contacted_status").bootstrapSwitch();

        $('#is_health_personnel').on('switchChange.bootstrapSwitch', function (event, state) {
            if (state === true) {
                $('.health_personnel_profession_id_row').removeClass('d-none');
            } else {
                $('.health_personnel_profession_id_row').addClass('d-none');
            }
        });

        $('#pcr_status').on('switchChange.bootstrapSwitch', function (event, state) {
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
            if(event.selected != 'undefined'){
                if(event.selected == 1){
                    state =  true;
                }
            }
            if (state === true) {
                $('#pcr_status').bootstrapSwitch('state', false, false);
            } else {
                $('#pcr_status').bootstrapSwitch('state', true, false);
            }
        });
        $('select#contact_origin_id').on('select2:select', function (e) {
            var data = e.params.data;
            if (data.id == 1) {
                $('.contact_origin_id_row').removeClass('d-none');
            } else {
                $('.contact_origin_id_row').addClass('d-none');
            }

        });

        $('select#patient_status_id').on('select2:select', function (e) {
            var data = e.params.data;
            if (data.id == 8) {
                $('.ex_date_row').removeClass('d-none');
            } else {
                $('.ex_date_row').addClass('d-none');
            }
        });


        $('select#patient_status_id').on('select2:select', function (e) {
            var data = e.params.data;

            var healed_statusses = ["3", "1", "7", "2", "4"];
            var search = $.inArray(data.id, healed_statusses);

            if (search != -1) {
                $('.healing_date_row').removeClass('d-none');
            } else {
                $('.healing_date_row').addClass('d-none');
            }
        });

        $('#village_id').on('change', function () {
            if($(this).val() == ''){
                return;
            }
            var url = '{{ route("districts.neighborhoods", ":village_id") }}';
            url = url.replace(':village_id', $(this).val());
            laravel.ajax.send({
                url: url,
                type: 'POST',
                data: {},
                beforeSend:function () {
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
                },
                error: laravel.ajax.errorHandler
            });
        });

        $('select#village_id').val(21128); //Merkez-Merkez
        $('select#village_id').trigger('change');

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
                <h3 class="card-title">Yeni Hasta Kaydet</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <form class="form-horizontal ajax" action="{{route('patient.store')}}" method="post">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="name" class="col-sm-5 col-form-label">Hasta Adı</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tckn" class="col-sm-5 col-form-label">Hasta T.C.</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="tckn" name="tckn">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="age" class="col-sm-5 col-form-label">Yaşı</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="age" name="age">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gsm" class="col-sm-5 col-form-label">Telefon</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="gsm" name="gsm">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="village_id" class="col-sm-5 col-form-label">Mahalle/Köy</label>
                                <div class="col-sm-7">
                                    {{viewHelper(\App\ViewHelpers\SelectBox\VillagesSelectBox::class)}}
                                    <small id="emailHelp" class="form-text text-muted">Merkez mahalleler için MERKEZ-MERKEZ seçiniz.</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="neighborhood_id" class="col-sm-5 col-form-label">Mahalle</label>
                                <div class="col-sm-7 neighborhood_holder">
                                    <select class="form-control" id="neighborhood_id" name="neighborhood_id">
                                        <option>Mahalle/Köy Seçiniz</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="address" class="col-sm-5 col-form-label">Adres</label>
                                <div class="col-sm-7">
                                    <textarea class="form-control" name="address" id="address"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="contacted_status" class="col-sm-5 col-form-label">TEMASLI / PCR</label>
                                <div class="col-sm-7">
                                    <input type="checkbox" id="contacted_status" name="contacted_status"
                                           data-on-text="Evet" data-off-text="Hayir" data-on-color="success"
                                           data-off-color="danger" value="1" checked>
                                    <input type="checkbox" id="pcr_status" name="pcr_status"
                                           data-on-text="Pozitif" data-off-text="Negatif" data-on-color="success"
                                           data-off-color="danger" value="1">
                                </div>
                            </div>

                            <div class="form-group row has_mutation_id_row d-none">
                                <label for="has_mutation" class="col-sm-5 col-form-label">Mutasyon</label>
                                <div class="col-sm-7">
                                    <input type="checkbox" id="has_mutation" name="has_mutation"
                                           data-on-text="Evet" data-off-text="Hayır" data-on-color="success"
                                           data-off-color="danger" value="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bt_id" class="col-sm-5 col-form-label">BT</label>
                                <div class="col-sm-7">
                                    {{viewHelper(\App\ViewHelpers\SelectBox\BtSelectBox::class)}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="detection_date" class="col-sm-5 col-form-label">Tespit Tarihi</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="detection_date" name="detection_date">
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
                                           data-off-color="danger" value="1">
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
                                <label for="relationship_to_main_case_id" class="col-sm-5 col-form-label">Asıl Vakaya
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

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="form-group row mb-0" style="float: right">

                        <div class="col-sm-12 ">
                            <button type="submit" class="btn btn-dark ajax_btn">Kaydet</button>
                            <button type="submit" class="btn btn-info ajax_btn">Kaydet Ve Kopyala</button>
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
