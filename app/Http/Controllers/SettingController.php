<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name' => Setting::get('app_name', config('app.name')),
            'app_logo' => Setting::get('app_logo'),
            'app_favicon' => Setting::get('app_favicon'),
            'instansi_nama' => Setting::get('instansi_nama', 'Dinas Pertanian Kabupaten Muna Barat'),
            'instansi_alamat' => Setting::get('instansi_alamat'),
            'instansi_email' => Setting::get('instansi_email'),
            'instansi_telp' => Setting::get('instansi_telp'),
            'kepala_nama' => Setting::get('kepala_nama'),
            'kepala_pangkat' => Setting::get('kepala_pangkat'),
            'kepala_nip' => Setting::get('kepala_nip'),
            'footer_text' => Setting::get('footer_text', '© ' . date('Y') . ' Simaset Muna Barat'),
        ];
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', 'app_logo', 'app_favicon']);
        
        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        // Handle Logo Upload
        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('settings', 'public');
            // Delete old logo if exists
            $oldLogo = Setting::get('app_logo');
            if ($oldLogo) Storage::disk('public')->delete($oldLogo);
            Setting::set('app_logo', $path);
        }

        // Handle Favicon Upload
        if ($request->hasFile('app_favicon')) {
            $path = $request->file('app_favicon')->store('settings', 'public');
            // Delete old favicon if exists
            $oldFavicon = Setting::get('app_favicon');
            if ($oldFavicon) Storage::disk('public')->delete($oldFavicon);
            Setting::set('app_favicon', $path);
        }

        return back()->with('success', 'Pengaturan aplikasi berhasil diperbarui.');
    }
}
