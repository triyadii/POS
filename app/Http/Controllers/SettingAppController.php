<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SettingApp;

use Illuminate\Support\Facades\Log;


class SettingAppController extends Controller
{
    public function edit()
    {
        $setting = SettingApp::first(); // Ambil data pertama
        return view('backend.setting_app.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        Log::info('Memulai update setting...');
    
        $setting = SettingApp::first();
    
        $request->validate([
            'logo_black' => 'nullable|mimes:png,jpg,jpeg,svg|max:2048',
            'logo_white' => 'nullable|mimes:png,jpg,jpeg,svg|max:2048',
            'logo_mobile' => 'nullable|mimes:png,jpg,jpeg,svg|max:2048',
            'favicon'    => 'nullable|mimes:png,ico|max:1024',
            'footer'     => 'nullable|string',
        ]);
    
        try {
            // Logo Black
            if ($request->hasFile('logo_black')) {
                if ($setting->logo_black && Storage::disk('public')->exists($setting->logo_black)) {
                    Storage::disk('public')->delete($setting->logo_black);
                }
                $ext = $request->file('logo_black')->getClientOriginalExtension();
                $filename = 'logo_black_' . time() . '.' . $ext;
                $path = $request->file('logo_black')->storeAs('settings', $filename, 'public');
                $setting->logo_black = $path;
                Log::info('Logo Black disimpan ke: ' . $path);
            }
    
            // Logo White
            if ($request->hasFile('logo_white')) {
                if ($setting->logo_white && Storage::disk('public')->exists($setting->logo_white)) {
                    Storage::disk('public')->delete($setting->logo_white);
                }
                $ext = $request->file('logo_white')->getClientOriginalExtension();
                $filename = 'logo_white_' . time() . '.' . $ext;
                $path = $request->file('logo_white')->storeAs('settings', $filename, 'public');
                $setting->logo_white = $path;
                Log::info('Logo White disimpan ke: ' . $path);
            }
    
            // Logo Mobile
            if ($request->hasFile('logo_mobile')) {
                if ($setting->logo_mobile && Storage::disk('public')->exists($setting->logo_mobile)) {
                    Storage::disk('public')->delete($setting->logo_mobile);
                }
                $ext = $request->file('logo_mobile')->getClientOriginalExtension();
                $filename = 'logo_mobile_' . time() . '.' . $ext;
                $path = $request->file('logo_mobile')->storeAs('settings', $filename, 'public');
                $setting->logo_mobile = $path;
                Log::info('Logo Mobile disimpan ke: ' . $path);
            }
    
            // Favicon
            if ($request->hasFile('favicon')) {
                if ($setting->favicon && Storage::disk('public')->exists($setting->favicon)) {
                    Storage::disk('public')->delete($setting->favicon);
                }
                $ext = $request->file('favicon')->getClientOriginalExtension();
                $filename = 'favicon_' . time() . '.' . $ext;
                $path = $request->file('favicon')->storeAs('settings', $filename, 'public');
                $setting->favicon = $path;
                Log::info('Favicon disimpan ke: ' . $path);
            }
    
            // Footer text
            $setting->footer = $request->footer;
            $setting->save();
    
            Log::info('Setting berhasil diperbarui:', $setting->toArray());
    
            return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui setting: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    

}
