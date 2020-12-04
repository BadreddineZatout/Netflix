<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Commune;
use Illuminate\Http\Request;

class CommuneController extends Controller
{
    public function getCommune($code)
    {
        return Commune::select('id', 'NomCommune')->where('Wilaya', $code)->get();
    }
}
