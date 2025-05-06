<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan model Customer ada

class AccountController extends Controller
{
    public function index()
    {
        // Ambil semua pelanggan
        $customers = User::where('role', 'customer')->get();
        $totalCustomers = $customers->count();


        // Kirim data ke view
        return view('accounts.accounts-desktop', compact('customers', 'totalCustomers'));
    }

    public function create()
    {
        // Menampilkan form untuk membuat akun pelanggan
        return view('accounts.create-account-desktop');
    }

    public function store(Request $request)
    {
        // Validasi data form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kode_akses' => 'required|string|max:255|unique:customers',
        ]);

        // Menyimpan data akun pelanggan ke database
        Customer::create([
            'name' => $validated['name'],
            'kode_akses' => $validated['kode_akses'],
        ]);

        // Redirect setelah berhasil menyimpan data
        return redirect()->route('accounts.index')->with('success', 'Akun berhasil dibuat!');

    }

    public function destroy($id)
{
    // Temukan pelanggan berdasarkan ID
    $customer = Customer::find($id);

    if ($customer) {
        // Hapus pelanggan
        $customer->delete();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 400);
}

}
