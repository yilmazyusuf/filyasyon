@extends('adminlte::layouts.app')
@section('title', 'HASTALAR')

@push('scripts')
    <!--Custom Scripts -->

    <!-- DataTables -->
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/data_table.js?v=9') }}"></script>
    <script>

        $(document).ready(function () {
            DataTable.getPatients('{{route('patient.index.data_table')}}');

            //Tek tek hasta seciliyor
            $('#patients_data_table tbody').on('click', 'tr', function () {
                $(this).toggleClass('selected');
                setStateForDailyChecksButton();
            });

            //Tumunu sec butonuna tiklandi
            $('button.patients_select').on('click', function () {
                $('#patients_data_table tbody tr').addClass('selected');
                setStateForDailyChecksButton();
            });

            //Secimi kaldir butonuna tiklandi
            $('button.patients_unselect').on('click', function () {
                $('#patients_data_table tbody tr').removeClass('selected');
                setStateForDailyChecksButton();
            });

            //Toplu Secim butonu aktof veya pasif yapiliyor
            function setStateForDailyChecksButton() {
                @can('daily_checks')
                if ($('#patients_data_table tbody tr.selected').length >= 2) {
                    $('button.batch_daily_checks').prop('disabled', false)
                } else {
                    $('button.batch_daily_checks').prop('disabled', true)
                }
                @endcan
            }

            $('button.batch_daily_checks').on('click',function (){

                var patient_ids = $.map($("#patients_data_table tbody tr.selected"), function(li) {
                    return $(li).attr("patient_id");
                });

                if(patient_ids.length >=2 ){
                    var patientIds = patient_ids.join(",");
                    var redirect_url = '{!! route('patient.batch_daily_checks',[':patientIds']) !!}';
                    redirect_url = redirect_url.replace(':patientIds', patientIds);
                    window.location.href = redirect_url
                }

            });


        });

    </script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>


@endpush
@push('styles')
    <!--Custom Styles -->
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
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

    <!-- Main content -->
    <section class="content pt-3">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">HASTALAR</h3>

                        <div class="card-tools">
                            @can('patient_add')
                                <a href="{{route('patient.create')}}" class="btn btn-dark btn-sm">
                                    <i class="fas fa-plus"></i> Hasta Ekle
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body table-responsive">

                        <div class="btn-group" role="group" aria-label="Select, Unselect Patients">
                            <button type="button" class="btn btn btn-default btn-sm  btn-flat patients_select"><i
                                    class="fas fa-check-circle"></i> Tümünü Seç
                            </button>
                            <button type="button" class="btn btn-default btn-sm  btn-flat patients_unselect"><i
                                    class="far fa-check-circle"></i> Seçimleri Kaldır
                            </button>
                        </div>

                        <div class="btn-group" role="group" aria-label="Select, Unselect Patients">

                            @can('daily_checks')
                                <button type="button" class="btn btn-dark btn-sm btn-flat batch_daily_checks" disabled>
                                    <i class="fa fas fa-user-check"></i> Toplu Denetim Ekle
                                </button>
                            @endcan
                        </div>


                        <table id="patients_data_table"
                               class="table table-bordered table-striped table-hover  table-head-fixed text-nowrap">
                            <thead>
                            <tr>
                                <th>Adı Soyadı</th>
                                <th>T.C</th>
                                <th>Yaş</th>
                                <th>Telefon</th>
                                <th>Mahalle</th>
                                <th>Poz.-Tem.</th>
                                <th>Durumu</th>
                                <th>Son Denetim</th>
                                <th>Son Aşı</th>
                                <th>Karantina</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="btn-group" role="group" aria-label="Select, Unselect Patients">
                            <button type="button" class="btn btn btn-default btn-flat patients_select"><i
                                    class="fas fa-check-circle"></i> Tümünü Seç
                            </button>
                            <button type="button" class="btn btn-default btn-flat patients_unselect"><i
                                    class="far fa-check-circle"></i> Seçimleri Kaldır
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
    <!-- /.content -->
@endsection
