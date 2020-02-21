<?php

namespace App\Http\Controllers\companies;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Validator;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth', 'company']);
    }
    public function index()
    {
        $user_data = User::with(['getRole'])
            ->whereHas('roles', function ($q) {
                $q->where('name', 'user');
            })->get()->count();
        $masjid_data = User::with(['getRole'])
            ->whereHas('roles', function ($q) {
                $q->where('name', 'company');
            })->get()->count();
        return view('companies.dashboard.index')->with(
            array(
                'user_data' => $user_data,
                'masjid_data' => $masjid_data,
            )
        );
    }
    /**
     * Show the Admin Profile.
     * */
    public function myAccount()
    {
        $user_data = User::where('id', Auth::user()->id)->first();
        return view('companies.dashboard.profileSetting')->with(array('user_data' => $user_data));
    }
    /**
     * Show the Admin editAccount.
     * */
    public function editAccount(Request $request)
    {
        $rules = array(
            'name' => 'required|unique:users|max:255',
            'info' => 'required|min:2',
            'phone' => 'numeric|min:10',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $save_profile = User::find(Auth::user()->id);
            $save_profile->name = $request->name;
            $save_profile->firstName = $request->firstName;
            $save_profile->lastName = $request->lastName;
            $save_profile->phone = $request->phone;
            $save_profile->info = $request->info;
            $save_profile->save();
            /*
            if($request->profile_picture !=""){
            $user_save = User::find(Auth::user()->id);
            if($user_save->profile_photo !=""){
            if (file_exists(public_path('/userProfile/'.$user_save->profile_photo)))
            {
            $del_previous_pic = unlink(public_path('/userProfile/'.$user_save->profile_photo));
            }
            }
            $file = $request->file('profile_picture');
            $filename = 'admin-picture-'.time().'.'.$file->getClientOriginalExtension();
            $file->move('public/userProfile',$filename);

            $user_save->profile_photo = $filename;
            $user_save->save();
            }
             */
            return redirect('/company/profile')->with(array('status' => 'success', 'message' => 'Profile details updated successfully!'));
        } catch (\Exception $e) {
            return redirect('/company/profile')->with(array('status' => 'danger', 'message' => 'Something went wrong. Please try again later.'));
            //return back()->with(array('status' => 'danger' , 'message' =>$e->getMessage()));
        }
    }

    public function userProfileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'info' => 'required|min:2',
            'phone' => 'numeric|min:10',
        ));
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $save_profile = User::find(Auth::user()->id);
            $save_profile->name = $request->name;
            $save_profile->phone = $request->phone;
            $save_profile->info = $request->info;
            $save_profile->save();
            /*
            if($request->hasFile('profile_picture'))
            {
            $user = User::find(Auth::user()->id);
            $file = $request->file('profile_picture');
            $filename = 'admin-'.time().'.'.$file->getClientOriginalExtension();
            $file->move('public/images/profile_pictures/',$filename);
            $user->profile_picture = $filename;
            $user->save();
            }
             */
            return redirect('/company/profile')->with(array('status' => 'success', 'message' => 'Profile details updated successfully!'));
        } catch (\Exception $e) {
            return back()->with(array('status' => 'danger', 'message' => $e->getMessage()));
        }
    }
}
