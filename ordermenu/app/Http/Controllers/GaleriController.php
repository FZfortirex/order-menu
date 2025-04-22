<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index(Request $request)
{
    $galeri = Galeri::all(); // ambil semua data foto

    $isMobile = $request->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', $request->header('User-Agent'));

    return view($isMobile ? 'user.galeri-mobile' : 'user.galeri-desktop', compact('galeri'));
}

    public function create()
    {
        return view('galeri-create');
    }

    public function destroy($id)
    {
        $foto = Galeri::findOrFail($id);

        // Hapus file dari storage
        $filePath = storage_path('app/public/galeri/' . $foto->nama_file);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Hapus data dari database
        $foto->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $file = $request->file('foto');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->storeAs('public/galeri', $filename);

        Galeri::create([
            'nama_file' => $filename,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Foto berhasil diunggah!');
    }
}
