<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class SettingsController extends Controller
{
    private $file = "settings.json";
    
    public function index()
    {
        $data = null;

        if (Storage::disk('public')->exists($this->file)) {
            $data = json_decode(Storage::disk('public')->get($this->file));
        }
        return view('catalog.settings.index', compact('data'));
    }

    public function update(Request $request)
    {
        $logo_path = null;
        
        $data = [];
        $old_data = [];

        if (Storage::disk('public')->exists($this->file)) {
            $old_data = json_decode(Storage::disk('public')->get($this->file), true);
            $data['app_name'] = $old_data['app_name'];
            $data['logo'] = $old_data['logo'];
        }



        if ($request->app_name) {
            $data['app_name'] = $request->app_name;
        }

        if ($request['logo']) {
            $folder = "settings/logo/";
            $origName = pathinfo($request['logo']->getClientOriginalName(), PATHINFO_FILENAME);
            $file_name = $origName . "_" . uniqid().'.'.$request['logo']->extension();  
            
            $request['logo']->move(public_path($folder), $file_name);
            $logo_path = $folder . $file_name;
            $data['logo'] = $logo_path;
        }


        Storage::disk('public')->put($this->file, json_encode($data));

        return redirect()->back()->with('success', 'Settings was updated.');
    }
}
