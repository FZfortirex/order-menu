<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'number_phone' => 'nullable|string|max:20',
            'password' => 'nullable|string',
            'role' => 'in:customer',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'number_phone' => $request->number_phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'my_points' => 0
        ]);

        return redirect()->back()->with('success', 'Akun pelanggan berhasil dibuat!');
    }


    public function destroy($id)
{
    // Temukan pelanggan berdasarkan ID
    $customer = User::where('role', 'customer')->find($id);

    if ($customer) {
        // Hapus pelanggan
        $customer->delete();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 400);
}

}
