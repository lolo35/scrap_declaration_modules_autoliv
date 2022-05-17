<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departaments;
use Exception;

class DepartamentsController extends Controller
{
    public function getDepartaments() {
        try {
            $data = Departaments::get();
            return response()->json(['success' => true, 'departaments' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()], 200);
        }
    }
}
