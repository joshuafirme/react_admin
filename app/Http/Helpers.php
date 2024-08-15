<?php 

if (! function_exists('isAdmin')) {
    function isAdmin()
    {
        return in_array(auth()->user()->role_id, [1]);
    }
}

if (! function_exists('isSuperAdmin')) {
    function isSuperAdmin()
    {
        return in_array(auth()->user()->role_id, [2]);
    }
}

if (! function_exists('isAgency')) {
    function isAgency()
    {
        return in_array(auth()->user()->role_id, [4]);
    }
}

if (! function_exists('getCount')) {
    function getCount($model)
    {
        $model_data = call_user_func('App\\'.$model.'::all');
        
        $count = count($model_data); 
        
        
        return $count;
    }
}

if (! function_exists('settings')) {
    function settings()
    {
        $data = null;
        $file = "settings.json";
        if (Storage::disk('public')->exists($file)) {
            $data = json_decode(\Storage::disk('public')->get($file));
        }
        else {
            $data = json_encode([
                'app_name' => 'Your app name',
                'logo' => '',
            ]);
        }
        return $data;
    }
}


?>