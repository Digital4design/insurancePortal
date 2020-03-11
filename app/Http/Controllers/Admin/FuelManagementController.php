<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\FuelModel;
use App\Models\Role;
use Validator;
use Crypt;


class FuelManagementController extends Controller
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
        return view('admin.fuelsType.index', $data);
    }
    public function userData()
    {
        $result = FuelModel::get();
        return Datatables::of($result)
        ->addColumn('action', function ($result) {
            return '<a href ="' . url('admin/fuel-type-management') . '/' . Crypt::encrypt($result->id) . '/edit"  class="btn btn-xs btn-primary edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
            <a data-id =' . Crypt::encrypt($result->id) . ' class="btn btn-xs btn-danger delete" style="color:#fff"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
        })->rawColumns(['action'])->make(true);
    }
    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     **/
    public function create(Request $request)
    {
        $data['roles'] = Role::get();
        return view('admin.fuelsType.create', $data);
    }
    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fuels_type' => 'required|unique:fuels|max:255',
            'fuels_description' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $userData = FuelModel::create([
                'fuels_type' => strtolower($request->fuels_type),
                'fuels_description' => $request->fuels_description,
            ]);
            return redirect('/admin/fuel-type-management')->with(['status' => 'success', 'message' => 'New Vehicle Successfully created!']);
        } catch (\Exception $e) {
            return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
            return back()->with(['status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.']);
        }
    }
    /**
     * Display the specified resource.
     * @param  \App\Models\FuelModel  $fuelModel
     * @return \Illuminate\Http\Response
     */
    public function show(FuelModel $fuelModel)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     * @param  \App\Models\FuelModel  $fuelModel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $user = FuelModel::find(\Crypt::decrypt($id));
            if ($user) {
                $data['user'] = $user;
                return view('admin.fuelsType.edit', $data);
            }
        } catch (\Exception $e) {
            return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FuelModel  $fuelModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'fuels_type' => 'required|unique:fuels,fuels_type,' . \Crypt::decrypt($id),
            'fuels_description' => 'required',
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
            $vehicleData = FuelModel::find(\Crypt::decrypt($id));
            $updateData = array(
                "fuels_type" => $request->has('fuels_type') ? strtolower($request->fuels_type) : "",
                "fuels_description" => $request->has('fuels_description') ? $request->fuels_description : "",
            );
            $vehicleData->update($updateData);
            return redirect('/admin/fuel-type-management')->with(['status' => 'success', 'message' => 'Update record successfully.']);
        } catch (\exception $e) {
            //return back()->with(['status' => 'danger', 'message' =>  $e->getMessage()]);
            return back()->with(['status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.']);
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param  \App\Models\FuelModel  $fuelModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FuelModel::find(Crypt::decrypt($id))->delete();
    }
}
