<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\VehicleModel;
use Crypt;
use Illuminate\Http\Request;
use Validator;
use Yajra\Datatables\Datatables;

class VehicleTypeManagementController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['roles'] = Role::get();
        return view('admin.vehicleType.index', $data);
    }
    public function userData()
    {
        $result = VehicleModel::get();
        return Datatables::of($result)
            ->addColumn('action', function ($result) {
                return '<a href ="' . url('admin/vehicle-type-management') . '/' . Crypt::encrypt($result->id) . '/edit"  class="btn btn-xs btn-primary edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
                <a data-id =' . Crypt::encrypt($result->id) . ' class="btn btn-xs btn-danger delete" style="color:#fff"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
            })->rawColumns(['action'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['roles'] = Role::get();
        return view('admin.vehicleType.create', $data);
    }
    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicles_type' => 'required|unique:vehicles|max:255',
            'vehicles_description' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $userData = VehicleModel::create([
                'vehicles_type' => strtolower($request->vehicles_type),
                'vehicles_description' => $request->vehicles_description,
            ]);
            return redirect('/admin/vehicle-type-management')->with(['status' => 'success', 'message' => 'New Vehicle Successfully created!']);
        } catch (\Exception $e) {
            return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
            return back()->with(['status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.']);
        }
    }
    /**
     * Display the specified resource.
     * @param  \App\Models\VehicleModel  $vehicleModel
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleModel $vehicleModel)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     * @param  \App\Models\VehicleModel  $vehicleModel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $user = VehicleModel::find(\Crypt::decrypt($id));
            if ($user) {
                $data['user'] = $user;
                return view('admin.vehicleType.edit', $data);
            }
        } catch (\Exception $e) {
            return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VehicleModel  $vehicleModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'vehicles_type' => 'required|unique:vehicles,vehicles_type,' . \Crypt::decrypt($id),
            'vehicles_description' => 'required',
        ];
        $messages = [
            'name.min' => 'First name should contain at least 2 characters.',
            'phone.min' => 'Phone Number should be min 10 digit.',
            'phone.numeric' => 'only digit are allowed',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $vehicleData = VehicleModel::find(\Crypt::decrypt($id));
            $updateData = array(
                "vehicles_type" => $request->has('vehicles_type') ? strtolower($request->vehicles_type) : "",
                "vehicles_description" => $request->has('vehicles_description') ? $request->vehicles_description : "",
            );
            $vehicleData->update($updateData);
            return redirect('/admin/vehicle-type-management')->with(['status' => 'success', 'message' => 'Update record successfully.']);
        } catch (\exception $e) {
            //return back()->with(['status' => 'danger', 'message' =>  $e->getMessage()]);
            return back()->with(['status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.']);
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param  \App\Models\VehicleModel  $vehicleModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        VehicleModel::find(Crypt::decrypt($id))->delete();
    }
}
