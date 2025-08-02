<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Menu;
use Illuminate\Http\Request;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::with('menu')->get(); 
        foreach ($banners as $banner) {
            $banner->has_image = !empty($banner->image);
        }
        $menus = Menu::all(); 
        return view('admin.banner', compact('banners', 'menus'));
    }


    public function storeOrUpdate(Request $request)
    {
        $clearIds = $request->input('clear_banner', []);

        foreach (range(1, 4) as $i) {
            $menuId = $request->input("menu_id_$i");
            $menuName = $request->input("menu_name_$i");

            $data = [];

            if (in_array($i, $clearIds)) {
                // Bersihkan image dan menu_id
                $banner = Banner::find($i);
                if ($banner && $banner->image && file_exists(public_path($banner->image))) {
                    unlink(public_path($banner->image));
                }

                $data = ['image' => null, 'menu_id' => null];
            } else {
                // Update image
                if (!$menuId && $menuName) {
                    $menu = Menu::firstOrCreate(['name' => $menuName]);
                    $menuId = $menu->id;
                }

                if ($menuId) {
                    $data['menu_id'] = $menuId;
                }

                if ($request->hasFile("image_$i")) {
                    $image = $request->file("image_$i");
                    $imageName = 'banner_' . $i . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images'), $imageName);
                    $data['image'] = 'images/' . $imageName;
                }
            }

            // Simpan atau update berdasarkan ID
            Banner::updateOrCreate(['id' => $i], $data);
        }

        return redirect()->back()->with('success', 'Semua banner berhasil disimpan');
    }
}