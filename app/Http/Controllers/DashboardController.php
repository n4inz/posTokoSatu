<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Member;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $kategori = Kategori::count();
        $produk = Produk::count();
        $supplier = Supplier::count();
        $member = Member::count();

        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');

        $data_tanggal = array();
        $data_pendapatan = array();

        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('nominal');

            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
            $data_pendapatan[] += $pendapatan;

            $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        }

        $dataPenjualan2019 = DB::table('penjualan_detail')
        ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(subtotal) as total_penjualan'))
        ->whereYear('created_at', '=', 2019)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->get();

        $totalPenjualanArray2019 = $dataPenjualan2019->pluck('total_penjualan')->toArray();

        $dataPenjualan2020 = DB::table('penjualan_detail')
        ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(subtotal) as total_penjualan'))
        ->whereYear('created_at', '=', 2020)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->get();

        $totalPenjualanArray2020 = $dataPenjualan2020->pluck('total_penjualan')->toArray();

        $dataPenjualan2021 = DB::table('penjualan_detail')
        ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(subtotal) as total_penjualan'))
        ->whereYear('created_at', '=', 2021)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->get();

        $totalPenjualanArray2021 = $dataPenjualan2021->pluck('total_penjualan')->toArray();

        $dataPenjualan2022 = DB::table('penjualan_detail')
        ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(subtotal) as total_penjualan'))
        ->whereYear('created_at', '=', 2022)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->get();

        $totalPenjualanArray2022 = $dataPenjualan2022->pluck('total_penjualan')->toArray();

        $dataPenjualan2023 = DB::table('penjualan_detail')
        ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(subtotal) as total_penjualan'))
        ->whereYear('created_at', '=', 2023)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->get();

        $totalPenjualanArray2023 = $dataPenjualan2023->pluck('total_penjualan')->toArray();

        $dataPenjualan = DB::table('penjualan_detail')
        ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(subtotal) as total_penjualan'))
        ->whereYear('created_at', '=', 2024)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->get();

        $totalPenjualanArray2024 = $dataPenjualan->pluck('total_penjualan')->toArray();



        // return $totalPenjualanArray2024;

        if (auth()->user()->level == 1) {
            return view('admin.dashboard', compact('kategori', 'produk', 'supplier', 'member', 'tanggal_awal', 'tanggal_akhir', 'data_tanggal', 'data_pendapatan' , 'totalPenjualanArray2024' , 'totalPenjualanArray2019' , 'totalPenjualanArray2020' , 'totalPenjualanArray2021' , 'totalPenjualanArray2022' , 'totalPenjualanArray2023'));
        } else {
            return view('kasir.dashboard');
        }
    }
}
