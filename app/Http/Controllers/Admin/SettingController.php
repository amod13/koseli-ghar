<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Repositories\SettingRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    protected $repo;
    public function __construct(SettingRepo $repo)
    {
        $this->middleware('check.permission');
        $this->repo = $repo;
    }

    /**
     * Display the specified setting.
     *
     * Retrieves the first setting in the database and renders the setting page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['header_title'] = 'Setting';
        $data['setting'] = $this->repo->getFirstData();
        return view('admin.page.setting.setting', ['data' => $data]);
    }

    /**
     * Update the specified setting in storage.
     *
     * Validates incoming request data and updates the site settings in the database.
     * Handles file uploads for logo and favicon, replacing existing files if necessary.
     *
     * @param \Illuminate\Http\Request $request The request object containing input data.
     * @param int $id The ID of the setting to update.
     * @return \Illuminate\Http\RedirectResponse Redirects back with a success message upon completion.
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'google_map' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_tags' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:512',
            'default_image' => 'nullable',
            'limit_title' => 'nullable|integer',
            'is_display_cart' => 'nullable|in:0,1',
            'is_display_wishlist' => 'nullable|in:0,1',
            'is_display_brand_slider' => 'nullable|in:0,1',
            'theme_color' => 'nullable',
            'hover_color' => 'nullable',
        ]);

        $setting = Setting::findOrFail($id);

        $setting->site_name = $request->site_name;
        $setting->email = $request->email;
        $setting->phone = $request->phone;
        $setting->address = $request->address;
        $setting->google_map = $request->google_map;
        $setting->facebook = $request->facebook;
        $setting->twitter = $request->twitter;
        $setting->instagram = $request->instagram;
        $setting->youtube = $request->youtube;
        $setting->tiktok = $request->tiktok;
        $setting->whatsapp = $request->whatsapp;
        $setting->meta_title = $request->meta_title;
        $setting->meta_tags = $request->meta_tags;
        $setting->meta_description = $request->meta_description;
        $setting->meta_keywords = $request->meta_keywords;
        $setting->default_image = $request->default_image;
        $setting->limit_title = $request->limit_title;
        $setting->is_display_cart = $request->is_display_cart;
        $setting->is_display_wishlist = $request->is_display_wishlist;
        $setting->is_display_brand_slider = $request->is_display_brand_slider;
        $setting->theme_color = $request->theme_color;
        $setting->hover_color = $request->hover_color;

        if ($request->hasFile('default_image')) {
            if ($setting->default_image) {
                Storage::delete('public/uploads/images/site/' . $setting->default_image);
            }
            $defaultImageName = time() . '_default_image.' . $request->default_image->extension();
            $request->default_image->move(public_path('uploads/images/site'), $defaultImageName);
            $setting->default_image = $defaultImageName;
        }

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::delete('public/uploads/images/site/' . $setting->logo);
            }
            $logoName = time() . '_logo.' . $request->logo->extension();
            $request->logo->move(public_path('uploads/images/site'), $logoName);
            $setting->logo = $logoName;
        }

        if ($request->hasFile('favicon')) {
            if ($setting->favicon) {
                Storage::delete('public/uploads/images/site/' . $setting->favicon);
            }
            $faviconName = time() . '_favicon.' . $request->favicon->extension();
            $request->favicon->move(public_path('uploads/images/site'), $faviconName);
            $setting->favicon = $faviconName;
        }

        $setting->save();

        return redirect()->back()->with('success', 'Site settings updated successfully.');
    }
}
