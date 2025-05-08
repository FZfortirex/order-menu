<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        // Simpan review ke database
        $review = new Review();
        $review->menu_id = $validated['menu_id'];
        $review->user_id = auth()->id(); // Menggunakan ID user yang sedang login
        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];
        $review->save();

        // Mengambil data review terbaru
        $newReview = $review->load('user'); // Load relasi user untuk nama

        // Hitung rata-rata rating menu setelah review
        $averageRating = $review->menu->reviews()->avg('rating');

        // Mengirimkan response JSON agar dapat ditampilkan di frontend
        return response()->json([
            'success' => true,
            'review' => [
                'user_name' => $newReview->user->name,
                'user_initial' => strtoupper(substr($newReview->user->name, 0, 1)),
                'rating' => $newReview->rating,
                'comment' => $newReview->comment,
            ],
            'average_rating' => $averageRating,  // Rating rata-rata baru
            'review_count' => $newReview->menu->reviews()->count(), // Jumlah review
        ]);
    }

    public function show($id)
    {
        // Ambil menu beserta relasi review dan user
        $menu = Menu::with(['reviews.user'])->findOrFail($id);
        
        // Hitung rata-rata rating menu
        $menu->average_rating = $menu->reviews->avg('rating');

        $user = auth()->user();

        return view('user.review', compact('menu', 'user'));
    }

    public function destroy(Review $review)
    {
        $user = auth()->user();

        if ($user->id  !== $review->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $review->delete();

        return response()->json(['success' => true]);
    }
}
