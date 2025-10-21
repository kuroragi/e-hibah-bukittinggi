<?php

namespace App\Http\Controllers;

use App\Models\NphdConfig;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function nphd(){
        $configs = NphdConfig::all();
        return view('pages.nphd.config', [
            'configs' => $configs
        ]);
    }
}
