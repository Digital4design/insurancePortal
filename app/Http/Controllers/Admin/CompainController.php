<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\Compain;
use Validator;


class CompainController extends Controller
{
    public function __construct()
    {
        //dd("Hello Here");
    }
    public function compainData($id)
    {
        $result = Compain::where('masjid_id', $id)->get();
        return Datatables::of($result)
            ->addColumn('action', function ($result) {
                $deleteIcon = "<a data-id ='" . $result->id . "' class='btn btn-xs btn btn-danger delete' style='color:#fff'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
                return '<a href ="#" data-toggle="modal" data-target="#editMasjidCompain" data-id="' . $result->id . '"  class="btn waves-effect waves-light btn-xs btn-info editCompain" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ' . $deleteIcon;
            })->make(true);
    }
    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->all());
    }
    /*Recursive Function */
    public function recursive($compainsSlug)
    {
        $compainsData = Compain::where('compains_slug', $compainsSlug)->get();
        if (count($compainsData) > 0) {
            return $this->recursive($compainsData[0]->compains_slug . "-" . rand(10, 1000));
        } else {
            return $compainsSlug;
        }
    }
    public function slugify($compainsSlug)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $compainsSlug);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        if ($text) {
            return $this->recursive($text);
        } else {
            return $text;
        }
    }
    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'compainName' => 'required|min:2',
            'compainDesc' => 'required|min:2',
            'compainLogo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        try {
            $slugName = $this->slugify($request->compainName);
            $compainData = Compain::create([
                'masjid_id' => $request->masjidId,
                'compainName' => $request->compainName,
                'compainDesc' => $request->compainDesc,
                'is_active' => $request->is_active,
            ]);
            if ($request->compainLogo != "") {
                $compain_save = Compain::where('id', $compainData->id)->first();
                if ($compain_save->compainLogo != "") {
                    if (file_exists(public_path('/uploads/CompainLogo/' . $compain_save->compainLogo))) {
                        $del_previous_pic = unlink(public_path('/uploads/CompainLogo/' . $compain_save->compainLogo));
                    }
                }
                $file = $request->file('compainLogo');
                $filename = 'compainLogo-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move('public/uploads/CompainLogo', $filename);
                $compain_save->compainLogo = $filename;
                $compain_save->save();
            }
            return response()->json(['status' => 'success', 'message' => 'New Compain is added successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'danger', 'message' => $e->getMessage()]);
            //return response()->json(['status' => 'danger', 'message' =>  'Something went wrong. Please try again later.']);
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
        $result = Compain::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $result]);
    }
    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_compainName' => 'required|min:2',
            'edit_compainDesc' => 'required|min:2',
            'edit_is_active' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        try {
            $compainUpdate = Compain::where('id', $request->compainId)->first();
            $compainUpdate->compainName = $request->edit_compainName;
            $compainUpdate->compainDesc = $request->edit_compainDesc;
            $compainUpdate->is_active = $request->edit_is_active;
            $compainUpdate->save();
            if ($request->compainLogo != "") {
                $compain_save = Compain::where('id', $request->compainId)->first();
                $file = $request->file('compainLogo');
                $filename = 'compainLogo-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move('public/uploads/CompainLogo', $filename);
                $compain_save->compainLogo = $filename;
                $compain_save->save();
                if ($compainUpdate->compainLogo != "") {
                    if (file_exists(public_path('/uploads/CompainLogo/' . $compainUpdate->compainLogo))) {
                        $del_previous_pic = unlink(public_path('/uploads/CompainLogo/' . $compainUpdate->compainLogo));
                    }
                }
            }
            return response()->json(['status' => 'success', 'message' => 'Compain update successfully']);
        } catch (\Exception $e) {
            // return response()->json(['status' => 'danger', 'message' => $e->getMessage()]);
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong. Please try again later.']);
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Compain::find($id)->delete();
    }
}
