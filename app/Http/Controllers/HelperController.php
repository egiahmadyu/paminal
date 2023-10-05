<?php

namespace App\Http\Controllers;

use App\Models\Pangkat;
use App\Models\Unit;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function getAllPangkat()
    {
        $data['pangkat'] = Pangkat::orderBy('id')->get();
        return response()->json([
            'status' => 200,
            'data' => $data,
        ]);
    }

    public function getUnit($den_bag)
    {
        $data['unit'] = Unit::where('datasemen', $den_bag)->get();
        return response()->json([
            'status' => 200,
            'data' => $data,
            'den' => $den_bag
        ]);
    }
}
