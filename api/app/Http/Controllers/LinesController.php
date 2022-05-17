<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Lines;

class LinesController extends Controller
{
    public function getLines(Request $request){
        try {
            $fields = $this->validate($request, [
                'zone' => "required|string"
            ]);

            $data = Lines::where("zone", '=', $fields['zone'])->get();
            return response()->json(['success' => true, 'lines' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()], 200);
        }
    }
}
