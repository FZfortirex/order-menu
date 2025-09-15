<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 

class TableController extends Controller
{
    public function index()
    {
        $jumlahMeja = 30; 
        $tableData = [];

        for ($i = 1; $i <= $jumlahMeja; $i++) {
            // Ambil user berdasarkan nomor meja (misal nomor_phone dipakai untuk simpan nomor meja)
            $user = User::where('name', (string) $i)->first();

            // Default status kosong
            $status = 'Kosong';

            if ($user && $user->session_expired_at !== null) {
                $status = 'Terisi';
            }

            $tableData[] = [
                'meja' => $i,
                'status' => $status,
                'user' => $user,
            ];
        }

        return view('admin.admin-table', compact('tableData'));
    }

    public function kosongkan($id)
    {
        $user = User::where('name', (string) $id)->first();

        if ($user) {
            $user->session_expired_at = null;
            $user->save();
        }

        return redirect()->route('admin.table')->with('success', "Meja $id berhasil dikosongkan.");
    }
}
