<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\FuelModel;
use App\Models\Role;
use App\Models\VehicleModel;
use App\Services\UserService;
use Illuminate\Http\Request;
use Validator;

class VehicleManagementController extends Controller
{
    /**
     * Construct.
     * */
    public function __construct(Request $request)
    {
        $this->middleware(['auth', 'users']);
    }
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['roles'] = Role::get();
        return view('users.vehicleManagement.index', $data);
    }
    public function driverData(Request $request, UserService $userService)
    {
        $sessiondata = $request->session()->all();
        $requestedUrl = 'vehicle/list/?hash=' . $sessiondata['hash'];
        $result = $userService->callAPI($requestedUrl);
        return $result = json_encode($result);
    }
    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, UserService $userService)
    {
        $data['roles'] = Role::get();
        $data['vehicleData'] = VehicleModel::get();
        $data['fuelData'] = FuelModel::get();

        $sessiondata = $request->session()->all();
        $requestUrl = "tracker/list?hash=" . $sessiondata['hash'];
        $data['trackerData'] = $userService->callAPI($requestUrl);
        return view('users.vehicleManagement.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UserService $userService)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'label' => 'required|max:255|min:2',
            'model' => 'required',
            'fuel_type' => 'required',
            'type' => 'required',
            'manufacture_year' => 'required',
            'max_speed' => 'required|numeric',
            'fuel_tank_volume' => 'required|numeric',
            'reg_number' => 'required',
            'liability_insurance_policy_number' => 'required',
            'liability_insurance_valid_till' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            if ($request->tracker_id === 'nullTracker') {$tracker_id = 'null';} else { $tracker_id = $request->tracker_id;}
            // if (!empty($request->model)) {$model = $request->model;} else { $model = "";}
            // if (!empty($request->max_speed)) {$max_speed = $request->max_speed;} else { $max_speed = "";}
            // if (!empty($request->trailer)) {$trailer = $request->trailer;} else { $trailer = "";}
            // if (!empty($request->manufacture_year)) {$manufacture_year = $request->manufacture_year;} else { $manufacture_year = 'null';}
            // if (!empty($request->color)) {$color = $request->color;} else { $color = "";}
            // if (!empty($request->additional_info)) {$additional_info = $request->additional_info;} else { $additional_info = "";}
            // if (!empty($request->reg_number)) {$reg_number = $request->reg_number;} else { $reg_number = "";}
            // if (!empty($request->chassis_number)) {$chassis_number = $request->chassis_number;} else { $chassis_number = "";}
            // if (!empty($request->passengers)) {$passengers = $request->passengers;} else { $passengers = "";}
            // if (!empty($request->fuel_grade)) {$fuel_grade = $request->fuel_grade;} else { $fuel_grade = "";}

            $sessiondata = $request->session()->all();
            $hash = $sessiondata['hash'];
            $newVehicleData = '{
                "tracker_id":' . $tracker_id . ',
                "label": "' . $request->label . '",
                "max_speed": ' . $request->max_speed . ',
                "model": "' . $request->model . '",
                "type": "' . $request->type . '",
                "subtype": null,
                "garage_id": null,
                "trailer" : "' . $request->trailer . '",
                "manufacture_year" : ' . $request->manufacture_year . ',
                "color" : "' . $request->color . '",
                "additional_info" : "' . $request->additional_info . '",
                "reg_number": "' . $request->reg_number . '",
                "vin": "TMBJF25LXC6080000",
                "chassis_number": "' . $request->chassis_number . '",
                "frame_number" : "",
                "payload_weight": 32000,
                "payload_height": 1.2,
                "payload_length": 1.0,
                "payload_width": 1.0,
                "passengers": ' . $request->passengers . ',
                "gross_weight" : null,
                "fuel_type": "' . $request->fuel_type . '",
                "fuel_grade": "' . $request->fuel_grade . '",
                "norm_avg_fuel_consumption": 9.0,
                "fuel_tank_volume": ' . $request->fuel_tank_volume . ',
                "fuel_cost" : 100.3,
                "wheel_arrangement": "4x2",
                "tyre_size": "255/65 R16",
                "tyres_number": 4,
                "liability_insurance_policy_number": "' . $request->liability_insurance_policy_number . '",
                "liability_insurance_valid_till": "' . $request->liability_insurance_valid_till . '",
                "free_insurance_policy_number": "",
                "free_insurance_valid_till": null,
                "icon_id" : 55,
                "avatar_file_name": null
            }';
            // dd($newVehicleData);

            $realArray = array(
                'hash' => $hash,
                'vehicle' => $newVehicleData,
            );
            //dd($realArray);

            $requestUrl = 'vehicle/create';
            $userData = $userService->postAPI($requestUrl, $realArray);
            // dd($userData);
            if ($userData['success'] === false) {
                return back()->with(['apiErrorData' => $userData, 'status' => 'danger', 'message' => $userData['errors'][0]['error']]);
            } else {
                return redirect('/user/assets-management')->with(['status' => 'success', 'message' => 'New Vehicle Successfully created!']);
            }
        } catch (\Exception $e) {
            //return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
            return back()->with(['status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.']);
        }
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request, UserService $userService)
    {
        $sessiondata = $request->session()->all();
        $requestUrl = "tracker/list?hash=" . $sessiondata['hash'];
        $data['trackerData'] = $userService->callAPI($requestUrl);

        $requestUrl = "vehicle/read/?vehicle_id=" . $id . "&hash=" . $sessiondata['hash'];
        $userData = $userService->callAPI($requestUrl);

        $data['userData'] = $userData;
        $data['vehicleData'] = VehicleModel::get();
        $data['fuelData'] = FuelModel::get();
        return view('users.vehicleManagement.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, UserService $userService)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|max:255|min:2',
            'model' => 'required',
            'fuel_type' => 'required',
            'type' => 'required',
            'manufacture_year' => 'required',
            'max_speed' => 'required|numeric',
            'fuel_tank_volume' => 'required|numeric',
            'reg_number' => 'required',
            'liability_insurance_policy_number' => 'required',
            'liability_insurance_valid_till' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            if ($request->tracker_id === 'nullTracker') {$tracker_id = 'null';} else { $tracker_id = $request->tracker_id;}
            $sessiondata = $request->session()->all();
            $requestUrl = "vehicle/read/?vehicle_id=" . $id . "&hash=" . $sessiondata['hash'];
            $userData = $userService->callAPI($requestUrl);

            $newVehicleData = '{
                "id": ' . $id . ',
                "tracker_id":' . $tracker_id . ',
                "label": "' . $request->label . '",
                "max_speed": ' . $request->max_speed . ',
                "model": "' . $request->model . '",
                "type": "' . $request->type . '",
                "subtype": null,
                "garage_id": null,
                "trailer" : "' . $request->trailer . '",
                "manufacture_year" : ' . $request->manufacture_year . ',
                "color" : "' . $request->color . '",
                "additional_info" : "' . $request->additional_info . '",
                "reg_number": "' . $request->reg_number . '",
                "vin": "TMBJF25LXC6080000",
                "chassis_number": "' . $request->chassis_number . '",
                "frame_number" : "",
                "payload_weight": 32000,
                "payload_height": 1.2,
                "payload_length": 1.0,
                "payload_width": 1.0,
                "passengers": ' . $request->passengers . ',
                "gross_weight" : null,
                "fuel_type": "' . $request->fuel_type . '",
                "fuel_grade":  "' . $request->fuel_grade . '",
                "norm_avg_fuel_consumption": 9.0,
                "fuel_tank_volume": ' . $request->fuel_tank_volume . ',
                "fuel_cost" : 100.3,
                "wheel_arrangement": "4x2",
                "tyre_size": "255/65 R16",
                "tyres_number": 4,
                "liability_insurance_policy_number": "' . $request->liability_insurance_policy_number . '",
                "liability_insurance_valid_till": "' . $request->liability_insurance_valid_till . '",
                "free_insurance_policy_number": "",
                "free_insurance_valid_till": null,
                "icon_id" : 55,
                "avatar_file_name": null
            }';
            //dd($newVehicleData);
            $realArray = array(
                'hash' => $sessiondata['hash'],
                'vehicle' => $newVehicleData,
            );
            $requestUrl = "vehicle/update";
            $userData = $userService->postAPI($requestUrl, $realArray);
            //dd($userData);
            if ($userData['success'] === false) {
                return back()->with(['status' => 'danger', 'message' => $userData['status']['description'] . " " . $userData['errors'][0]['error']]);
            } else {
                return redirect('/user/assets-management')->with(['status' => 'success', 'message' => 'Vehicle update Successfully!']);
            }

        } catch (\Exception $e) {
            //return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
            return back()->with(['status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request, UserService $userService)
    {
        $sessiondata = $request->session()->all();
        $requestUrl = "vehicle/delete/?vehicle_id=" . $id . "&hash=" . $sessiondata['hash'];
        $data['userData'] = $userService->callAPI($requestUrl);
        return redirect('/user/assets-management')->with(['status' => 'success', 'message' => 'Vehicle delete successfully!']);
    }
}
