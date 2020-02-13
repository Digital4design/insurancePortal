<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CountryModel;
use App\Models\LicenseClassModel;
use App\Models\Role;
use Crypt;
use DB;
use Illuminate\Http\Request;
use Validator;
use Yajra\Datatables\Datatables;

class LicenseClassManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['roles'] = Role::get();
        return view('admin.licenseClass.index', $data);
    }
    public function userData()
    {
        $result = DB::table('driver_license_class')
            ->select('driver_license_class.id', 'driver_license_class.country_id', 'driver_license_class.description', 'driver_license_class.license_class', 'countries.name')
            ->join('countries', 'countries.id', '=', 'driver_license_class.country_id')
            ->get();
        return Datatables::of($result)
            ->addColumn('action', function ($result) {
                return '<a href ="' . url('admin/license-class-management') . '/' . Crypt::encrypt($result->id) . '/edit"  class="btn btn-xs btn-primary edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
                <a data-id =' . Crypt::encrypt($result->id) . ' class="btn btn-xs btn-danger delete" style="color:#fff"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
            })->rawColumns(['action'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['country'] = CountryModel::get()->toArray();
        return view('admin.licenseClass.create', $data);
    }
    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
            'license_class' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $licenseClass = LicenseClassModel::where('country_id', $request->country_id)->where('license_class', $request->license_class)->get()->toArray();
            if (!empty($licenseClass)) {
                return back()->with(['status' => 'danger', 'message' => 'Allready Added.']);
            } else {
                $userData = LicenseClassModel::create([
                    'country_id' => $request->country_id,
                    'license_class' => $request->license_class,
                    'description' => $request->description,
                ]);
                return redirect('/admin/license-class-management')->with(['status' => 'success', 'message' => 'New Driver License Country  Successfully created!']);
            }
        } catch (\Exception $e) {
            return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
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
    public function edit($id)
    {
        try {
            $user = LicenseClassModel::find(\Crypt::decrypt($id));
            if ($user) {
                $data['user'] = $user;
                $data['country'] = CountryModel::get();
                return view('admin.licenseClass.edit', $data);
            }
        } catch (\Exception $e) {
            return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }
    }
    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
            'license_class' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $user = LicenseClassModel::find(\Crypt::decrypt($id));
            $updateData = array(
                "country_id" => $request->has('country_id') ? $request->country_id : "",
                "license_class" => $request->has('license_class') ? $request->license_class : "",
                "description" => $request->has('description') ? $request->description : "",
            );
            $user->update($updateData);
            return redirect('/admin/license-class-management')->with(['status' => 'success', 'message' => 'Driver License Country update Successfully!']);
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
    public function destroy($id)
    {
        LicenseClassModel::find(Crypt::decrypt($id))->delete();
    }
}
