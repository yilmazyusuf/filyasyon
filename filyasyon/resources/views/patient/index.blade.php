@extends('adminlte::layouts.app')
@section('title', 'HASTALAR')

@push('scripts')
    <!--Custom Scripts -->

    <!-- DataTables -->
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/data_table.js?v=4') }}"></script>
    <script>
        DataTable.getPatients('{{route('patient.index.data_table')}}');
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
                        <table id="roles_data_table"
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
                                <th>#</th>
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
