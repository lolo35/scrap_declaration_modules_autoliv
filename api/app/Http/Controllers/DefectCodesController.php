<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DefectCodes;
use Exception;

class DefectCodesController extends Controller
{
    public function getDefectCodes(){
        try {
            $data = DefectCodes::get();

            return response()->json(['success' => true, 'defect_codes' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()], 200);
        }
    }
}
