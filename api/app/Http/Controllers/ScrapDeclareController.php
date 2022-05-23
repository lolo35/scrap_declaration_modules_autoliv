<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StationBomAssoc;
use App\Models\BOM;
use App\Models\DeclaredDefects;
use Illuminate\Support\Facades\DB;
use Exception;

class ScrapDeclareController extends Controller
{
    public function declareScrap(Request $request) {
        try {
            $fields = $this->validate($request, [
                'finit' => "required|string",
                'line' => "required|string",
                'defect_code' => "required|string",
                'identified_station' => "required|integer",
                'produced_station' => "required|integer",
                'label' => "nullable|string"
            ]);

            $nextId = DeclaredDefects::orderBy('defect_id', 'desc')->limit(1)->first();
            
            if($nextId) {
                $nextId = $nextId->defect_id + 1;
            } else {
                $nextId = 1;
            }

            $parts = $this->getComponent($fields['identified_station']);
            $label_parts = json_decode($fields['label'], true);
            if($parts['success']) {
                // print_r($parts['data']); exit;
                foreach($parts['data'] as $part) {
                    if(isset($label_parts[$part[0]['part_number']])){
                        $insert = new DeclaredDefects();
                        $insert->defect_id = $nextId;
                        $insert->finit = $fields['finit'];
                        $insert->part_number = $part[0]['part_number'];
                        $insert->line = $fields['line'];
                        $insert->defect_code = $fields['defect_code'];
                        $insert->identified_station = $fields['identified_station'];
                        $insert->produced_station = $fields['produced_station'];
                        $insert->quantity = 1;
                        $insert->label = $label_parts[$part[0]['part_number']];
                        $insert->save();
                    } else {
                        $insert = new DeclaredDefects();
                        $insert->defect_id = $nextId;
                        $insert->finit = $fields['finit'];
                        $insert->part_number = $part[0]['part_number'];
                        $insert->line = $fields['line'];
                        $insert->defect_code = $fields['defect_code'];
                        $insert->identified_station = $fields['identified_station'];
                        $insert->produced_station = $fields['produced_station'];
                        $insert->quantity = 1;
                        $insert->save();
                    }
                }
            }
            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()], 200);
        }
    }

    public function checkForScan(Request $request) {
        try {
            $fields = $this->validate($request, [
                'station_id' => "required|integer"
            ]);
            $data = $this->getComponentForScan($fields['station_id']);
            if($data['success']) {
                return response()->json(['success' => true, 'data' => $data['data']]);
            } else {
                return response()->json(['success' => false, 'error' => $data]);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()], 200);
        }
    }

    private function getComponentForScan($id) {
        try {
            $data = StationBomAssoc::where('station_id', '=', $id)->get()->toArray();
            $toScan = [];
            foreach($data as $row) {
                $component = $this->checkComponentForScan($row['component_id']);
                //print_r($component);
                if(boolval($component['component'][0]['islabel'])) {
                    array_push($toScan, $component['component']);
                }
            }
            return ['success' => true, 'data' => $toScan];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()];
        }
    }

    private function getComponent($id) {
        try {
            $data = StationBomAssoc::where('station_id', '=', $id)->get()->toArray();
            $components = [];
            foreach($data as $row) {
                $component = BOM::where('id', '=', $row['component_id'])->get()->toArray();
                array_push($components, $component);
            }
            return ['success' => true, 'data' => $components];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()];
        }
    }

    private function checkComponentForScan($id) {
        try {
            $component = BOM::where("id", '=', $id)->get();
            if(!$component->isEmpty()){
                $component = $component->toArray();
                return ['success' => true, 'component' => $component];
            }
            return ['success' => false, 'error' => 'no data'];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()];
        }
    }

    public function getScrapData(Request $request) {
        try {
            $fields = $this->validate($request, [
                'date' => "required|string",
                'departament' => "required|string",
                'shift' => "required|integer"
            ]);
            $shift = $this->determineShift($fields['shift']);
            if($shift['success']) {
                $start = $fields['date'] . " " . $shift['start'];
                $end = $fields['date'] . " " . $shift['end'];
                $data = DB::table("scrap_components")
                    ->join('declared_defects', 'scrap_components.declared_defect_id', '=', 'declared_defects.id')
                    ->whereBetween('declared_defects.created_at', [$start, $end])
                    ->selectRaw('declared_defects.part_number, sum(declared_defects.quantity) as total')
                    ->groupBy('declared_defects.part_number')
                    ->get();
                return response()->json(['success' => true, 'data' => $data, 'shift' => $shift], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()], 200);
        }
    }

    private function determineShift($shift) {
        try {
            switch($shift) {
                case 1 : return ['success' => true, 'start' => "06:00", 'end' => "14:30"];
                case 2 : return ['success' => true, 'start' => "14:30", 'end' => "23:00"];
                case 3 : return ['success' => true, 'start' => "23:00", 'end' => "06:00"];
            }
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()];
        }
    }
}
