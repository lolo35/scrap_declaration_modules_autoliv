<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parts;
use Exception;

class PartsController extends Controller
{
    public function getParts(Request $request) {
        try {
            $fields = $this->validate($request, [
                'line' => "string|required"
            ]);

            $data = Parts::where('line', '=', $fields['line'])->get();
            return response()->json(['success' => true, 'parts' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()], 200);
        }
    }
}
