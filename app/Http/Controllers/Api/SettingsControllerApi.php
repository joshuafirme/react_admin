<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Storage;

class SettingsControllerApi extends ResponseController
{
    private $file = "settings.json";
    public function settings()
    {
        $data = null;

        if (Storage::disk('public')->exists($this->file)) {
            $data = json_decode(Storage::disk('public')->get($this->file));
        }
        if ($data) {
            return $this->sendResponse($data);
        } else {
            $error = "Sorry! Data not found.";
            return $this->sendError($error, 401);
        }
    }
}
