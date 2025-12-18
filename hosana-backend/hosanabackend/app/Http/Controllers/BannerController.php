<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
        public function index()
    {
        $banners = Banner::paginate(5); 
        return response()->json($banners);
    }

 
    public function store(Request $request)
    {
        $request->validate([
            'banner' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('banner')->store('banners', 'public');

        $banner = Banner::create([
            'banner' => $path
        ]);

        return response()->json($banner, 201);
    }

    public function show($id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['message' => 'Banner not found'], 404);
        }

        return response()->json($banner);
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('banner')) {
            Storage::disk('public')->delete($banner->banner);

            $path = $request->file('banner')->store('banners', 'public');
            $banner->banner = $path;
        }

        $banner->save();

        return response()->json([
            'message' => 'Banner updated successfully',
            'banner' => $banner
        ]);
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        Storage::disk('public')->delete($banner->banner);
        $banner->delete();

        return response()->json(['message' => 'Banner deleted successfully']);
    }
}
