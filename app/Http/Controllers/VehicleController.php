<?php
namespace App\Http\Controllers;
require 'vendor/autoload.php';
// use Zend\Barcode\Barcode;
// use Zend\Barcode\Object\Image;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\VehicleDocuments;
use App\Models\VehicleModel;
use App\Models\barcode;
use App\Models\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class VehicleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        session()->flash('module', 'vehicle');
        $this->middleware('auth');
    }

    /* Front - Vehicle List */
    public function index()
    {
        $user_id =  Auth::user()->id;
        $Vehicle = new Vehicle();
        $vehicle_list = $Vehicle->where('user_id',$user_id)->with(['VehicleBrand','VehicleModel'])->orderBy('id','DESC')->get();
        return view('front.vehicle.list',compact('vehicle_list'));
    }
    /* Front - Add Vehicle */
    public function add()
    {
        $vehicleData = new Vehicle;
        $title = "Add";
        $actionUrl = "{{ route('store.vehicle') }}";
        return view('front.vehicle.add',compact('vehicleData','title','actionUrl'));
    }
    /* Front - Store Vehicle */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules =  [
            'owner_name' => 'required',
            'brand' => 'required',
            'model' => 'required|unique:vehicles',
            'user_id' => 'required',
            'mobile_number' => 'required',
            'vehicle_no' => 'required|unique:vehicles',
            'vehicle_type' => 'required',
            'emergency_name1' => 'required',
            'relation_emg1' => 'required',
            'emergency_number1' => 'required',
            'vehicle_documents.*' => 'file',
            'barcode' => 'required|unique:vehicles',
        ];

        $validatedData = $request->validate($rules);
        $PostData = $request->all();
        $PostData['vehicle_no'] = strtoupper($request->vehicle_no);
        if($PostData['model'] == 'other'){
            $ModelData['brand_id'] = $request->brand;
            $ModelData['name'] = $request->model_name;
            $vehicleModel = VehicleModel::create($ModelData);
            $PostData['model'] = $vehicleModel->id;
        }

        $vehicleDocuments = $request->file('vehicle_documents');

        $activeBarcode = barcode::where('barcode',$request->input('barcode'))->where('status',1)->get();

        if($activeBarcode->isEmpty()) {
            session()->flash('error', 'Barcode not found.');
            return redirect()->back();
            // return redirect()->route('vehicles');
        }

        $existingVehicle = Vehicle::where('vehicle_no', $request->input('vehicle_no'))->first();
        if ($existingVehicle) {
            session()->flash('error', 'This vehicle is already registered.');
            return redirect()->route('vehicles');
        }

        if (!file_exists(VEHICLE_IMG_DIR)) {
            mkdir(VEHICLE_IMG_DIR, 0777, true);
        }

        if (!file_exists(VEHICLE_DIR)) {
            mkdir(VEHICLE_DIR, 0777, true);
        }

        if ($request->hasFile('image')) {
            $uploadedImages = $_FILES['image'];
            $images = $request->file('image');
            $vehicleImages = [];
            foreach($images as $key => $image){
                $destinationPath = VEHICLE_IMG_DIR;

                $originalName = $image->getClientOriginalName();
                $fileName = pathinfo($originalName, PATHINFO_FILENAME);

                $vehicleImage = $PostData['user_id'].'_'.$fileName.'_'.date('YmdHis').'.'.$image->getClientOriginalExtension();
                $image->move($destinationPath, $vehicleImage);
                $vehicleImages[] = $vehicleImage;
            }
            $vehicleImages_str = implode(",",$vehicleImages);
            $request = $request->except('image');
            $PostData['image'] = $vehicleImages_str;
        }
        unset($PostData['vehicle_documents']);
        // pre($PostData);exit;
        $vehicle = Vehicle::create($PostData);

        $logData['user_id'] = Auth::user()->id;
        $logData['vehicle_no'] = $PostData['vehicle_no'];
        $logData['barcode'] = $PostData['barcode'];
        $logData['type'] = "add_vehicle";
        $logData['data'] = json_encode($PostData);
        Log::create($logData);

        if (!empty($vehicleDocuments)) {
            foreach ($vehicleDocuments as $documentType => $doc) {
                $destinationPath = VEHICLE_DIR;
                $vehicleDoc = $documentType.'_'.$PostData['user_id'].'_'.date('YmdHis').'.'.$doc->getClientOriginalExtension();
                $doc->move($destinationPath, $vehicleDoc);
                VehicleDocuments::create([
                    'vehicle_id' => $vehicle->id,
                    'type' => $documentType,
                    'name' => $vehicleDoc,
                ]);
            }
        }

        if($vehicle) {
            session()->flash('success', 'Vehicle successfully Added.');
        } else {
            session()->flash('error', 'Vehicle Not Added');
        }
        return redirect()->route('vehicle.details');
        // return response()->json(['redirect' => route('vehicles')]);
        // return redirect()->route('my_account');
    }

    public function store_ajax(Request $request)
    {
        // dd($request->all());
        $rules =  [
            'barcode' => 'required|unique:vehicles',
            'owner_name' => 'required',
            'model' => 'required',
            'user_id' => 'required',
            'mobile_number' => 'required',
            'vehicle_no' => 'required',
            'vehicle_type' => 'required',
            'vehicle_documents.*' => 'file',
        ];
        $validatedData = $request->validate($rules);
        $PostData = $request->all();

        $existingVehicle = Vehicle::where('vehicle_no', $request->input('vehicle_no'))->first();
        if ($existingVehicle) {
            session()->flash('error', 'This vehicle is already registered.');
            return response()->json(['redirect' => route('vehicles')]);
        }

        if (!file_exists(VEHICLE_IMG_DIR)) {
            mkdir(VEHICLE_IMG_DIR, 0777, true);
        }

        if (!file_exists(VEHICLE_DIR)) {
            mkdir(VEHICLE_DIR, 0777, true);
        }
        $vehicleDocuments = $request->file('vehicle_documents');

        if ($request->hasFile('image')) {
            $uploadedImages = $_FILES['image'];
            $images = $request->file('image');
            $vehicleImages = [];
            foreach($images as $key => $image){
                $destinationPath = VEHICLE_IMG_DIR;
                $vehicleImage = date('YmdHis').$key.'.'.$image->getClientOriginalExtension();
                $image->move($destinationPath, $vehicleImage);
                $vehicleImages[] = $vehicleImage;
            }
            $vehicleImages_str = implode(",",$vehicleImages);
            $request = $request->except('image');
            $PostData['image'] = $vehicleImages_str;
        }

        $vehicle = Vehicle::create($PostData);
        if (!empty($vehicleDocuments)) {
            foreach ($vehicleDocuments as $key => $doc) {
                $destinationPath = VEHICLE_DIR;
                $vehicleDoc = date('YmdHis') . $key . '.' . $doc->getClientOriginalExtension();
                $doc->move($destinationPath, $vehicleDoc);
                VehicleDocuments::create([
                    'vehicle_id' => $vehicle->id,
                    'name' => $vehicleDoc,
                ]);
            }
        }

        if($vehicle) {
            session()->flash('success', 'Vehicle successfully Added.');
        } else {
            session()->flash('error', 'Vehicle Not Added');
        }
        return response()->json(['redirect' => route('vehicles')]);
    }
    /* Front - Edit Page */
    public function edit($id)
    {
        // $vehicle_list = $Vehicle->where('user_id',$user_id)->with(['VehicleBrand','VehicleModel'])->orderBy('id','DESC')->get();
        $id = Crypt::decrypt($id);
        $vehicleData = Vehicle::find($id);
        $title = "Update";
        $actionUrl = "{{ route('update.vehicle') }}";

        $VehicleDocuments = [];
        foreach($vehicleData->VehicleDocuments as $doc){
            $VehicleDocuments[$doc['type']] = $doc['name'];
        }

        return view('front.vehicle.add',compact('vehicleData','VehicleDocuments','title','actionUrl'));
    }
    /* Front - Update Vehicle */
    public function update(Request $request)
    {

        // Validate the request data
        $rules =  [
            'owner_name' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'user_id' => 'required',
            'mobile_number' => 'required',
            'vehicle_no' => 'required',
            'vehicle_type' => 'required',
            'emergency_name1' => 'required',
            'relation_emg1' => 'required',
            'emergency_number1' => 'required',
            'vehicle_documents.*' => 'file',
            'barcode' => 'required',
        ];

        $id = $request->input('id');

        $rules['model'] = 'required|unique:vehicles,model,' . $id;
        $rules['vehicle_no'] = 'required|unique:vehicles,vehicle_no,' . $id;

        $rules['barcode'] = 'required|unique:vehicles,barcode,' . $id . ',id';

        $validatedData = $request->validate($rules);

        $activeBarcode = barcode::where('barcode',$request->input('barcode'))->where('status',1)->get();

        if($activeBarcode->isEmpty()) {
            session()->flash('error', 'Barcode not found.');
            return redirect()->back();
            // return redirect()->route('vehicles');
        }

        // Get the existing vehicle record
        $existingVehicle = Vehicle::find($id);

        if (!$existingVehicle) {
            session()->flash('error', 'Vehicle not found.');
            // return response()->json(['redirect' => route('vehicles')]);
            return redirect()->route('vehicles');
        }

        // Check if the vehicle number is already registered for a different record
        if ($request->input('vehicle_no') !== $existingVehicle->vehicle_no) {
            $duplicateVehicle = Vehicle::where('vehicle_no', $request->input('vehicle_no'))->first();
            if ($duplicateVehicle) {
                session()->flash('error', 'This vehicle number is already registered.');
                // return response()->json(['redirect' => route('vehicles')]);
                return redirect()->route('vehicles');
            }
        }

        // Update the existing vehicle record with the new data
        $PostData = $request->all();
        $PostData['vehicle_no'] = strtoupper($request->vehicle_no);
        if($PostData['model'] == 'other'){
            $ModelData['brand_id'] = $request->brand;
            $ModelData['name'] = $request->model_name;
            $vehicleModel = VehicleModel::create($ModelData);
            $PostData['model'] = $vehicleModel->id;
        }

        if ($request->hasFile('image')) {
            // Handle image upload and update
            $uploadedImages = $_FILES['image'];
            $images = $request->file('image');
            $vehicleImages = [];
            foreach ($images as $key => $image) {
                $destinationPath = VEHICLE_IMG_DIR;
                $originalName = $image->getClientOriginalName();
                $fileName = pathinfo($originalName, PATHINFO_FILENAME);
                $vehicleImage = $PostData['user_id'].'_'.$fileName.'_'.date('YmdHis').'.'.$image->getClientOriginalExtension();
                $image->move($destinationPath, $vehicleImage);
                $vehicleImages[] = $vehicleImage;
            }
            $vehicleImages_str = implode(",", $vehicleImages);
            $PostData['image'] = $vehicleImages_str;
            if(!empty($existingVehicle->image)){
                $PostData['image'] = $existingVehicle->image.','.$vehicleImages_str;
            }else{
                $PostData['image'] = $vehicleImages_str;
            }
        }
        $logData['user_id'] = Auth::user()->id;
        $logData['vehicle_no'] = $PostData['vehicle_no'];
        $logData['barcode'] = $PostData['barcode'];
        $logData['type'] = "update_vehicle";
        $logData['data'] = json_encode($PostData);
        Log::create($logData);
        // Update the existing record with the new data
        $existingVehicle->update($PostData);
        // Handle vehicle documents
        $vehicleDocuments = $request->file('vehicle_documents');
        if (!empty($vehicleDocuments)) {
            foreach ($vehicleDocuments as $documentType => $doc) {
                $destinationPath = VEHICLE_DIR;
                $vehicleDoc = $documentType.'_'.$PostData['user_id'].'_'.date('YmdHis').'.'.$doc->getClientOriginalExtension();
                $doc->move($destinationPath, $vehicleDoc);
                // VehicleDocuments::create([
                //     'vehicle_id' => $existingVehicle->id,
                //     'type' => $documentType,
                //     'name' => $vehicleDoc,
                // ]);
                VehicleDocuments::updateOrCreate(
                    ['vehicle_id' => $existingVehicle->id, 'type' => $documentType],
                    ['name' => $vehicleDoc]
                );
            }
        }
        session()->flash('success', 'Vehicle successfully updated.');
        // return response()->json(['redirect' => route('vehicles')]);
        return redirect()->route('vehicle.details');
    }
    /* Front - Vehicle Barcode Check */
    public function checkBarcode(Request $request)
    {
        $postData = $request->all();

        if(isset($postData['id']) && !empty($postData['id'])){
            $usedbarcode = vehicle::where('barcode', $postData['barcode'])->where('id', '!=', $postData['id'])->first();
        }else{
            $usedbarcode = vehicle::where('barcode', $postData['barcode'])->first();
        }

        if($usedbarcode) {
            return response()->json(['exists' => true,'msg'=> "Barcode is already used"]);
        }else {
            $checkbarcode = barcode::where('barcode', $postData['barcode'])->where('status',1)->first();
            if($checkbarcode){
                return response()->json(['exists' => false]);
            }else{
                return response()->json(['exists' => true,'msg'=> "Barcode Not Found"]);
            }
        }
    }

    public function checkBarcode1(Request $request)
    {
        $barcode = $request->input('barcode');
        $usedbarcode = vehicle::where('barcode', $barcode)->first();
        if ($usedbarcode) {
            $message = "Barcode Not Found";
            $isValid = false;
        } else {
            $checkbarcode = barcode::where('barcode', $barcode)->where('status',1)->first();
            if($checkbarcode){
                $message = "Barcode Already Taken";
                $isValid = false;
            }else{
                $message = "Custom validation message from the database";
                $isValid = true;
            }
        }
        return response()->json(['valid' => $isValid, 'message' => $message]);
    }
    /*Front - Model Listing */
    public function getModels(Request $request)
    {
        $brandId = $request->input('brand_id');
        $Models = VehicleModel::where('brand_id',$brandId)->get();
        return response()->json($Models);
    }
    /* Front - vehicle delete with image and document */
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        $VehicleDocuments = $vehicle->VehicleDocuments;
        foreach ($VehicleDocuments as $documents) {
            if(file_exists(VEHICLE_DIR.$documents->name)){
                unlink(VEHICLE_DIR.$documents->name);
                $documents->delete();
            }
        }
        if(!empty($vehicle->image)){
            $images = explode(',',$vehicle->image);
            foreach ($images as $img) {
                if(file_exists(VEHICLE_IMG_DIR.$img)){
                    unlink(VEHICLE_IMG_DIR.$img);
                }
            }
        }

        $logData['user_id'] = Auth::user()->id;
        $logData['vehicle_no'] = $vehicle->vehicle_no;
        $logData['barcode'] = $vehicle->barcode;
        $logData['type'] = "delete_vehicle";
        $logData['data'] = json_encode($vehicle);
        Log::create($logData);

        $vehicle->delete();
        return response()->json(['message' => 'Vehicle deleted successfully']);
    }
    /* Image delete */
    public function destroyImg(Request $request)
    {
        $image_name  = $request->name;
        $id  = $request->id;
        $vehicle = Vehicle::find($id);
        // pre($vehicle->image);exit;
        if(!empty($vehicle->image)){
            if (stripos($vehicle->image, ',') !== false) {
                $images = explode(',',$vehicle->image);
                foreach ($images as $key => $img) {
                    if($img == $image_name){
                        unset($images[$key]);
                        unlink(VEHICLE_IMG_DIR.$img);
                    }
                }
                // pre(implode(',',$images));exit;
                $vehicle->image = implode(',',$images);
                $vehicle->save();
            } else {
                unlink(VEHICLE_IMG_DIR.$vehicle->image);
                $vehicle->image = '';
                $vehicle->save();
            }
        }
        return response()->json(['message' => 'Image Vehicle deleted successfully']);
    }

    /* Admin - Vehicle Listing */
    public function vehiclesList(Request $request)
    {
        if ($request->ajax()) {

            $toDate ='';
            $fromDate ='';
            if($request->input('date_range') !=''){
                $dtRangeArr=explode(' to ', $request->input('date_range'));
                $fromDate=(isset($dtRangeArr[0]))?$dtRangeArr[0]:'';
                $toDate=(isset($dtRangeArr[1]))?$dtRangeArr[1]:'';
            }

            $wherestr = "vehicles.id !=''";
            if($fromDate!='' && $toDate ==''){
                $wherestr .= "AND DATE(vehicles.created_at) ='".$fromDate."' ";
            }
            else if($fromDate!='' && $toDate !='')
            {
                $wherestr .= "AND DATE(vehicles.created_at) >='".$fromDate."' ";
            }

            if($toDate!=''){
                $wherestr .= " AND DATE(vehicles.created_at) <='".$toDate."' ";
            }

            $Data = Vehicle::with('VehicleBrand','VehicleModel')->whereRaw($wherestr)
                            ->orderBy('created_at', 'desc')
                            ->get();

            return DataTables($Data)
                ->addColumn('owner_name', function ($Data) {
                    return ucwords($Data->owner_name);
                })
                ->addColumn('created_at', function ($Data) {
                    return $Data->created_at;
                })
                ->addColumn('company', function ($Data) {
                    return ($Data->VehicleBrand->name ?? "") .' '. ($Data->VehicleModel->name ?? "");
                })
                ->addColumn('action', function ($data) {
                    // $url = url('admin/or', $data->id);
                    $action_line = '<a class="action_icon view_vehicle" data-id="' . $data->id . '" title="View"><i class="fa fa-eye"></i></a>';
                    return $action_line;
                })
                ->rawColumns(['company','action'])
                ->make(true);
        }
        return view('admin.vehicles');
    }
    /* Admin - vehicle Filter */
    public function filter(Request $request)
    {
        $VehicleData = Vehicle::latest()->get();
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $data = $VehicleData->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }
        return response()->json($data);
    }
    /* Front - Vehicle INfo */
    public function info($id)
    {
        $id =  Crypt::decrypt($id);
        $vehicle = Vehicle::find($id);
        $VehicleDocuments = [];
        foreach($vehicle->VehicleDocuments as $doc){
            $VehicleDocuments[$doc['type']] = $doc['name'];
        }
        return view('front.vehicle.info',compact('vehicle','VehicleDocuments'));
    }

    public function view(string $id)
    {
        $VehicleData = Vehicle::where('id',$id)->first();
        $page = view('admin.vehicle.view',compact('VehicleData'))->render();
        return response()->json(['page' => $page]);
    }

    public function vehicleDetails()
    {
        session()->flash('module', 'vehicle-details');
        $user_id =  Auth::user()->id;
        $Vehicle = new Vehicle();
        $vehicle_list = $Vehicle->where('user_id',$user_id)->with(['VehicleBrand','VehicleModel'])->orderBy('id','DESC')->get();
        return view('front.vehicle.vehicle-details', compact('vehicle_list'));
    }

    public function CheckModel(Request $request)
    {
        $postData = $request->all();
        $usedbarcode = VehicleModel::where('name', $postData['name'])->where('brand_id', $postData['brand_id'])->first();
        if($usedbarcode) {
            return response()->json(['exists' => true,'msg'=> "Model is already used"]);
        }else{
            return response()->json();
        }
    }

}
