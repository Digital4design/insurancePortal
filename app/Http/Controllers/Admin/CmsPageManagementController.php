<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\CmsPages;
use Validator;
use Redirect;
use Crypt;



class CmsPageManagementController extends Controller
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
        $data = array();
        return view('admin.pages.index', $data);
    }

    public function pageData()
    {
        $result = CmsPages::orderBy('created_at', 'DESC')->get();
        return Datatables::of($result)
            ->addColumn('action', function ($result) {
                return '<a href ="' . env('APP_URL') . 'admin/page-management/' . Crypt::encrypt($result->id) . '/edit"  class="btn btn-xs btn-primary edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </a>
            | <a href ="' . env('FRONTEND_URL') . $result->page_slug . '" target="_blank" class="btn btn-xs btn-warning view"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
            | <a data-id =' . Crypt::encrypt($result->id) . ' class="btn btn-xs btn-danger delete" style="color:#fff"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
            })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        return view('admin.pages.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:2',
            'page_slug' => 'required|unique:cms_pages',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $pageData = CmsPages::create([
                'name' => $request->name,
                'page_slug' => $request->page_slug,
                'content' => $request->content,
                "status" => $request->has('status') ? 'Active' : 'Disable',
            ]);
            return redirect('/admin/page-management')->with(['status' => 'success', 'message' => 'New page successfully created!']);
        } catch (\Exception $e) {
            // return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
            return back()->with(['status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.']);
        }
    }

    /**
     * Display the specified resource.
     * @param  \App\Models\CmsPages  $cmsPages
     * @return \Illuminate\Http\Response
     */
    public function show(CmsPages $cmsPages, $id)
    {
        try {
            $pageData = CmsPages::find(Crypt::decrypt($id));
            if ($pageData) {
                $data['pageData'] = $pageData;
                return view('admin.pages.view', $data);
            } else {
                return back()->with(['status' => 'danger', 'message' => 'Requested page not found!']);
            }
        } catch (\Exception $e) {
            return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }
    }
    /**
     * Show the form for editing the specified resource.
     * @param  \App\Models\CmsPages  $cmsPages
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $pageData = CmsPages::find(Crypt::decrypt($id));
            if ($pageData) {
                $data['pageData'] = $pageData;
                return view('admin.pages.edit', $data);
            } else {
                return back()->with(['status' => 'danger', 'message' => 'Requested page not found!']);
            }
        } catch (\Exception $e) {
            return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }
    }
    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CmsPages  $cmsPages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $pageData = CmsPages::find(\Crypt::decrypt($id));
            $updateData = array(
                "name" => $request->has('name') ? $request->name : "",
                "content" => $request->has('content') ? $request->content : "",
                "status" => $request->has('status') ? 'Active' : 'Disable',
            );
            $pageData->update($updateData);
            return redirect('/admin/page-management')->with(['status' => 'success', 'message' => 'Update record successfully.']);
        } catch (\exception $e) {
            return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
            // return back()->with(['status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param  \App\Models\CmsPages  $cmsPages
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CmsPages::find(Crypt::decrypt($id))->delete();
    }
}
