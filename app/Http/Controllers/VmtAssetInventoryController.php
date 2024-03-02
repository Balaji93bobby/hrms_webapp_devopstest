<?php

namespace App\Http\Controllers;

use App\Imports\VmtAssetsInventory;
use Illuminate\Http\Request;
use App\Models\VmtAssetInventory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class VmtAssetInventoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $assetInventories  =json_encode( VmtAssetInventory::all());
        return view('vmt_assetInventory', compact('assetInventories'));
    }

    public function fetchAll(Request $request)
    {
        return json_encode( VmtAssetInventory::all());

    }

    public function addAsset(Request $request)
    {
        $t_asset = new VmtAssetInventory;

        $t_asset->asset_name = $request->asset_name;
        $t_asset->asset_type = $request->asset_type;
        $t_asset->serial_number = $request->serial_number;
        $t_asset->warranty = $request->warranty;
        $t_asset->vendor = $request->vendor;
        $t_asset->assignee = $request->assignee;
        $t_asset->assigned_date = $request->assigned_date;
        $t_asset->asset_status = $request->asset_status;
        $t_asset->invoice = $request->invoice;
        

        $t_asset->save();

        return "Saved";

    }
    
    // function used for show bulk upload page
    public function bulkUploadAsset(){
        return view('vmt_assetInventory_bulk_upload');
    }
    // Store asset inventories as bulk upload
    public function storeBulkUploadAsset(Request $request){
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx'
        ]);
        $importDataArry = \Excel::toArray(new VmtAssetsInventory, request()->file('file'));
        return $this->storeQuickBulkUploadAsset($importDataArry);
    }

    // insert the asset inventories to database as a bulk data
    public function storeQuickBulkUploadAsset($data){
        $rules = [];
        $returnSuccessMsg = '';
        $returnFailedMsg = '';
        $addedCount = 0;
        $failedCount = 0;
        foreach($data[0] as $key => $row) {
            $date = $row['assigned_date'];
            $row['assigned_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
            $rules = [
                'asset_name' => 'required',
                'asset_type' => 'required',
                'serial_number' => 'required',
                'warranty' => 'required',
                'vendor' => 'required',
                'assignee' => 'required',
                'asset_status' => 'required',
                'assigned_date' => 'required|date',
            ];
            $messages = [
                'required' => 'The :attribute field is required.',
                'date' => 'The :attribute field date is not valid.',
            ];
            $validator = Validator::make($row, $rules, $messages);

            if ($validator->passes()) {
                $row['assigned_date'] =  date("Y-m-d", strtotime($row['assigned_date']));
                $t_asset = new VmtAssetInventory;

                $t_asset->asset_name = $row['asset_name'];
                $t_asset->asset_type = $row['asset_type'];
                $t_asset->serial_number = $row['serial_number'];
                $t_asset->warranty = $row['warranty'];
                $t_asset->vendor = $row['vendor'];
                $t_asset->assignee = $row['assignee'];
                $t_asset->assigned_date = $row['assigned_date'];
                $t_asset->asset_status = $row['asset_status'];
                $t_asset->save();
                
                if ($t_asset) {
                    $addedCount++;
                    $returnSuccessMsg .= $row['asset_name']." get added\n";
                } else {
                    $failedCount++;
                    $returnFailedMsg .= $row['asset_name']." not get added\n";
                }
            } else {
                $returnFailedMsg .= "<li>".$row['asset_name']." not get added because of error ".json_encode($validator->errors()->all());
                $returnFailedMsg .= "</li>";
                $failedCount++;
            }
        }
        $data = ['success'=> $returnSuccessMsg, 'failed'=> $returnFailedMsg, 'success_count'=> $addedCount, 'failed_count'=> $failedCount];
        return $data;
    }

    public function deleteAsset(Request $request)
    {
        $t_asset = VmtAssetInventory::find($request->id);
        $t_asset->delete();
        if ($t_asset) {
            return "200";
        } else {
            return "400";
        }

    }

    public function updateAsset(Request $request)
    {
        $t_asset = VmtAssetInventory::find($request->id);
        $t_asset->asset_name = $request->asset_name;
        $t_asset->asset_type = $request->asset_type;
        $t_asset->serial_number = $request->serial_number;
        $t_asset->warranty = $request->warranty;
        $t_asset->vendor = $request->vendor;
        $t_asset->assignee = $request->assignee;
        $t_asset->assigned_date = $request->assigned_date;
        $t_asset->invoice = $request->invoice;
        $t_asset->save();
        if ($t_asset) {
            return "200";
        } else {
            return "400";
        }

    }
}
