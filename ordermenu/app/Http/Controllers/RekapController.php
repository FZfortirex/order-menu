<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    public function grafikPenjualan(Request $request)
    {
        $tipe = $request->query('tipe', 'harian'); // default harian

        if ($tipe === 'bulanan') {
            $penjualan = Order::select(
                    DB::raw('MONTH(updated_at) as bulan'),
                    DB::raw('SUM(total_price) as total')
                )
                ->where('status', 'selesai')
                ->groupBy(DB::raw('MONTH(updated_at)'))
                ->orderBy(DB::raw('MONTH(updated_at)'))
                ->get();

            $labels = $penjualan->pluck('bulan')->map(function ($bulan) {
                return Carbon::create()->month($bulan)->locale('id')->translatedFormat('F');
            });
            $totals = $penjualan->pluck('total');
        } else {
            $penjualan = Order::select(
                    DB::raw('DATE(updated_at) as tanggal'),
                    DB::raw('SUM(total_price) as total')
                )
                ->where('status', 'selesai')
                ->groupBy(DB::raw('DATE(updated_at)'))
                ->orderBy(DB::raw('DATE(updated_at)'))
                ->get();

            $labels = $penjualan->pluck('tanggal');
            $totals = $penjualan->pluck('total');
        }

        // Deteksi apakah perangkat mobile
        $isMobile = $request->header('User-Agent') &&
                    preg_match('/Mobile|Android|iPhone|iPad/', $request->header('User-Agent'));

        // Kirim ke view sesuai device
        return view($isMobile ? 'admin.rekap-penjualan-mobile' : 'admin.rekap-penjualan-desktop', [
            'labels' => $labels,
            'totals' => $totals,
            'tipe' => $tipe,
        ]);
    }
}
