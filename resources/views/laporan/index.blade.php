@extends('layouts.master')

@section('title')
    Laporan Pendapatan {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }}
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Laporan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="updatePeriode()" class="btn btn-info btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Ubah Periode</button>
                
                <select id="select-day" class="btn btn-info btn-xs btn-flat" name="" id="">
                    <option value="">--Pilih--</option>
                    <option value="harian">Harian</option>
                    <option value="bulanan">Bulanan</option>
                    <option value="tahunan">Tahunan</option>
                </select>
                <a href="{{ route('laporan.export_pdf', [$tanggalAwal, $tanggalAkhir]) }}" target="_blank" class="btn btn-success btn-xs btn-flat"><i class="fa fa-file-excel-o"></i> Export PDF</a>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Kode barang</th>
                        <th>Penjualan</th>
                        <th>Pembelian</th>
                        <th>Pengeluaran</th>
                        <th>Pendapatan</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('laporan.form')
@endsection

@push('scripts')
<script src="{{ asset('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('laporan.data', [$tanggalAwal, $tanggalAkhir]) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {data: 'kode_barang'},
                {data: 'penjualan'},
                {data: 'pembelian'},
                {data: 'pengeluaran'},
                {data: 'pendapatan'}
            ],
            dom: 'Brt',
            bSort: false,
            bPaginate: false,
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });

    function updatePeriode() {
        $('#modal-form').modal('show');
    }


    $('#select-day').change(function() {
    var val = $(this).val();
    var currentDate = new Date().toISOString().split('T')[0]; // Mendapatkan tanggal saat ini dalam format "YYYY-MM-DD"
    var newUrl = 'http://toko-bangunan.navbar.my.id/laporan?';

    if (val == 'harian') {
        newUrl += 'tanggal_awal=' + currentDate + '&tanggal_akhir=' + currentDate;
    } else if (val == 'bulanan') {
        var today = new Date();
        var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
        var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        var firstDayFormatted = firstDayOfMonth.toISOString().split('T')[0];
        var lastDayFormatted = lastDayOfMonth.toISOString().split('T')[0];
        newUrl += 'tanggal_awal=' + firstDayFormatted + '&tanggal_akhir=' + lastDayFormatted;
    } else if (val == 'tahunan') {
        var today = new Date();
        var firstDayOfYear = new Date(today.getFullYear(), 0, 1);
        var lastDayOfYear = new Date(today.getFullYear(), 11, 31);
        var firstDayFormatted = firstDayOfYear.toISOString().split('T')[0];
        var lastDayFormatted = lastDayOfYear.toISOString().split('T')[0];
        newUrl += 'tanggal_awal=' + firstDayFormatted + '&tanggal_akhir=' + lastDayFormatted;
    }

    // Redirect ke URL baru
    window.location.href = newUrl;
});
</script>
@endpush