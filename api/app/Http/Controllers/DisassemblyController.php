<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeclaredDefects;
use Illuminate\Support\Facades\DB;
use App\Models\ScrapComponents;
use App\Models\OkComponents;
use Exception;
use PhpParser\Node\Stmt\Declare_;

class DisassemblyController extends Controller
{
    public function getDefect(Request $request) {
        try {
            $fields = $this->validate($request, [
                'label' => "required|string"
            ]);

            $data = DeclaredDefects::where('label', '=', $fields['label'])->orderBy('id', 'desc')->first();
            if($data){
                $checkForOtherLabels = $this->checkForOtherLabels($data->defect_id, $data->id);
                $defectBom = DB::table('declared_defects')
                        ->join('stations', 'declared_defects.produced_station', '=', 'stations.id')
                        ->where('declared_defects.defect_id', '=', $data->defect_id)
                        ->select("declared_defects.*", 'stations.station_number', 'stations.l2l_station')
                        ->get();
                if($checkForOtherLabels['success'] && !$checkForOtherLabels['toScan']){
                    return response()->json(['success' => true, 'moreToScan' => false, 'data' => $defectBom], 200);
                } else {
                    return response()->json(
                        [
                            'success' => true, 
                            'moreToScan' => true, 
                            'toBeScanned' => $checkForOtherLabels['toScan'], 
                            'data' => $defectBom, 
                        ], 200);
                }
            } 
            return response()->json(['success' => false, 'error' => 'no data'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()], 200);
        }
    }

    public function countTimesScanned(Request $request) {
        try {
            $fields = $this->validate($request, [
                'label' => "required|string"
            ]);
            $data = DeclaredDefects::selectRaw('count(id) as total')->where('label', '=', $fields['label'])->get();
            return response()->json(['success' => true, 'count' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()], 200);
        }
    }

    public function checkForOtherLabels($defect_id, $row_id){
        try {
            $data = DeclaredDefects::where('defect_id', '=', $defect_id)->where('id', '!=', $row_id)->get();
            if(!$data->isEmpty()) {
                $data = $data->toArray();
                $toBeScanned = [];
                foreach($data as $row) {
                    if(strlen($row['label']) > 0) {
                        array_push($toBeScanned, $row['label']);
                    }
                }
                return ['success' => true, 'toScan' => $toBeScanned];
            }
            return ['success' => true, 'toScan' => false];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()];
        }
    }

    public function saveStatus(Request $request) {
        try {
            $fields = $this->validate($request, [
                'ok' => "required|string",
                'scrap' => "required|string"
            ]);
            $ok = json_decode($fields['ok'], true);
            $scrap = json_decode($fields['scrap'], true);
            
            foreach($scrap as $component) {
                $insert = new ScrapComponents();
                $insert->declared_defect_id = $component['id'];
                $insert->save();
            }

            foreach($ok as $component) {
                $insert = new OkComponents();
                $insert->declared_defect_id = $component['id'];
                $insert->save();
            }

            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()], 200);
        }
    }
}
