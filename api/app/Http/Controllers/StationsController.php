<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stations;
use Exception;

class StationsController extends Controller
{
    public function getStations(Request $request) {
        try {
            $fields = $this->validate($request, [
                'part_id' => "required|integer",
                'line_id' => "required|integer"
            ]);
            $data = Stations::where('part_id', '=', $fields['part_id'])->where('line_id', '=', $fields['line_id'])->get();
            return response()->json(['success' => true, 'stations' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'line' => $e->getMessage(), 'file' => $e->getFile()], 200);
        }
    }
}
