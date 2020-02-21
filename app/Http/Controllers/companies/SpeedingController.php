<?php

namespace App\Http\Controllers\companies;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\SpeedModel;
use Crypt;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;


class SpeedingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['roles'] = Role::get();
        return view('companies.speedingManage.index', $data);

    }

    public function getSpeedData()
    {

        $result = SpeedModel::get();
        //dd($result);

        return Datatables::of($result)
            ->addColumn('action', function ($result) {
                return '<a href ="' . url('company/speed-management') . '/' . Crypt::encrypt($result->id) . '/edit"  class="btn btn-xs btn-warning edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
                <a data-id =' . Crypt::encrypt($result->id) . ' class="btn btn-xs btn-danger delete" style="color:#fff"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $speedData = SpeedModel::find(\Crypt::decrypt($id));
            if ($speedData) {
                $data['speedData'] = $speedData;
                return view('companies.speedingManage.edit', $data);
            }
        } catch (\Exception $e) {
            return back()->with(array('status' => 'danger', 'message' => $e->getMessage()));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($id);
        $validator = Validator::make($request->all(), array(
            'speedingValue' => 'required',
            'costValue' => 'required|numeric',
            'speedType' => 'required',

        ));
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $speedData = SpeedModel::find(\Crypt::decrypt($id));
            $updateData = array(
                "name" => $request->has('speedingValue') ? $request->speedingValue : "",
                "email" => $request->has('costValue') ? $request->costValue : "",
                "info" => $request->has('speedType') ? $request->speedType : "",
            );
            $speedData->update($updateData);
            return redirect('/company/speed-management')->with(array('status' => 'success', 'message' => 'Update record successfully.'));
        } catch (\exception $e) {
            return back()->with(array('status' => 'danger', 'message' => $e->getMessage()));
            return back()->with(array('status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.'));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
