@extends('adminlte::layouts.app')
@section('title', 'Raporlar')

@push('scripts')
    <!--Custom Scripts -->

    <!-- DataTables -->
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/buttons.print.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/buttons.html5.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/buttons.flash.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/buttons.colVis.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/jszip.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/vfs_fonts.js') }}"></script>

    <script src="{{ asset('js/data_table.js?v=11') }}"></script>
    <script>
        $(document).ready(function () {
            DataTable.getReports('{{route('report.index.data_table')}}');
        });

    </script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>


@endpush
@push('styles')
    <!--Custom Styles -->
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
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

                    <div class="card-body table-responsive">

                        <table id="patients_data_table"
                               class="table table-bordered table-striped table-hover  table-head-fixed text-nowrap">
                            <thead>
                            <tr>
                                <th>Adı Soyadı</th>
                                <th>T.C</th>
                                <th>Yaş</th>
                                <th>Telefon</th>
                                <th>Mahalle/Köy</th>
                                <th>Mahalle</th>
                                <th>Poz.-Tem.</th>
                                <th>Durumu</th>
                                <th>Son Denetim</th>
                                <th>Son Aşı</th>
                                <th>Karantina</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>

    </section>
    <!-- /.content -->
@endsection
