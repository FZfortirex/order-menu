<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrMenuController extends Controller
{
    public function index()
    {
        $jumlahMeja = 30; 
        $qrData = [];

        for ($i = 1; $i <= $jumlahMeja; $i++) {
            $url = route('qr.login', ['meja' => $i]);
            $qrCode = QrCode::size(200)->generate($url);

            $qrData[] = [
                'meja' => $i,
                'qr' => $qrCode,
                'url' => $url,
            ];
        }

        return view('qr.qr', compact('qrData'));
    }
}
