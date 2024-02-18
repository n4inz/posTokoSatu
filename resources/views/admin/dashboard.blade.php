@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $kategori }}</h3>

                <p>Total Kategori</p>
            </div>
            <div class="icon">
                <i class="fa fa-cube"></i>
            </div>
            <a href="{{ route('kategori.index') }}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $produk }}</h3>

                <p>Total Produk</p>
            </div>
            <div class="icon">
                <i class="fa fa-cubes"></i>
            </div>
            <a href="{{ route('produk.index') }}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $member }}</h3>

                <p>Total Member</p>
            </div>
            <div class="icon">
                <i class="fa fa-id-card"></i>
            </div>
            <a href="{{ route('member.index') }}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $supplier }}</h3>

                <p>Total Supplier</p>
            </div>
            <div class="icon">
                <i class="fa fa-truck"></i>
            </div>
            <a href="{{ route('supplier.index') }}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->
<!-- Main row -->
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Grafik Penjualan 2019 s/d 2024</h3>
                <select name="" id="change_grafik">
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                    <option value="2019">2019</option>
                </select>
                {{-- <h3 class="box-title">Grafik Penjualan {{ tanggal_indonesia($tanggal_awal, false) }} s/d {{ tanggal_indonesia($tanggal_akhir, false) }}</h3> --}}
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="salesChart" style="height: 180px;"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row (main row) -->
@endsection

@push('scripts')
<!-- ChartJS -->
<script src="{{ asset('AdminLTE-2/bower_components/chart.js/Chart.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(function() {
    // // Get context with jQuery - using jQuery's .get() method.
    // var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
    // // This will get the first returned node in the jQuery collection.
    // var salesChart = new Chart(salesChartCanvas);

    // var salesChartData = {
    //     // labels: {{ json_encode($data_tanggal) }},
    //     labels: ['2019', '2020', '2021', '2022', '2023', '2024'],

    //     datasets: [
    //         {
    //             label: 'Penjualan',
    //             // fillColor           : 'rgba(60,141,188,0.9)',
    //             // strokeColor         : 'rgba(60,141,188,0.8)',
    //             // pointColor          : '#3b8bba',
    //             // pointStrokeColor    : 'rgba(60,141,188,1)',
    //             // pointHighlightFill  : '#fff',
    //             // pointHighlightStroke: 'rgba(60,141,188,1)',
    //             // data: {{ json_encode($data_pendapatan) }}
    //             data: [20000000, 23000000, 18000000, 15000000, 30000000, 5000000],

    //         }
    //     ]
    // };

    // var salesChartOptions = {
    //     // pointDot : false,
    //     responsive : true
    // };

    // salesChart.Line(salesChartData, salesChartOptions);



});

    function generateRandomData(min, max, length) {
        var data = [];
        for (var i = 0; i < length; i++) {
            data.push(Math.floor(Math.random() * (max - min + 1)) + min);
        }
        return data;
    }

    // Objek untuk menyimpan data grafik
    // var chartData = {
    //     '2019': @json($totalPenjualanArray2019),
    //     // '2019': generateRandomData(5000000, 30000000, 12), // Data acak antara 5 juta dan 30 juta untuk setiap bulan
    //     '2020': generateRandomData(5000000, 31000000, 12),
    //     '2021': generateRandomData(6000000, 32000000, 12),
    //     '2022': generateRandomData(6000000, 33000000, 12),
    //     '2023': generateRandomData(7000000, 34000000, 12),
    //     '2024': @json($totalPenjualanArray2024)
    // };

    var chartData = {
        '2024': @json($totalPenjualanArray2024),
        '2023': @json($totalPenjualanArray2023),
        '2022': @json($totalPenjualanArray2022),
        '2021': @json($totalPenjualanArray2021),
        '2020': @json($totalPenjualanArray2020),
        '2019': @json($totalPenjualanArray2019),
    };
    
    const ctx = document.getElementById('salesChart');

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul' ,'Agus', 'Sept' ,'Okt' ,'Nov', 'Dec'],
            datasets: [{
                label: 'Penjualan',
                data: chartData['2024'], // Data untuk tahun 2019
                borderWidth: 1
            }]
        },
        
    });

    var selectElement = document.getElementById('change_grafik');
    selectElement.addEventListener('change', function() {
        var selectedYear = selectElement.value;
        myChart.data.datasets[0].data = chartData[selectedYear];
        myChart.update();
    });

</script>
@endpush