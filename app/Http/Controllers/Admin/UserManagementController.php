<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CountryModel;
use App\Models\LicenseClassModel;
use App\Models\Role;
use App\Models\UserRoleRelation;
use App\Notifications\Users\UserCreation;
use App\Services\UserService;
use App\User;
use Auth;
use Crypt;
use Illuminate\Http\Request;
use Redirect;
use Validator;
use Yajra\Datatables\Datatables;

class UserManagementController extends Controller
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
        $user = Auth::user();
        $data['roles'] = Role::get();
        return view('admin.users.index', $data);
    }
    /**
     * Process datatables ajax request.
     * @return \Illuminate\Http\JsonResponse
     */
    public function userData()
    {
        $result = User::with(['getRole'])
            ->whereHas('roles', function ($q) {
                $q->where('name', 'user');
            })->get();
        //dd($result);
        return Datatables::of($result)
            ->addColumn('action', function ($result) {
                return '<a href ="' . url('admin/user-management') . '/' . Crypt::encrypt($result->id) . '/edit"  class="btn btn-xs btn-primary edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
                <a data-id =' . Crypt::encrypt($result->id) . ' class="btn btn-xs btn-danger delete" style="color:#fff"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
            })->make(true);
    }
    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, UserService $userService)
    {
        $data['roles'] = Role::get();
        $data['country'] = CountryModel::get();
        $data['company'] = $result = User::with(['getRole'])
            ->whereHas('roles', function ($q) {
                $q->where('name', 'company');
            })->get();
        return view('admin.users.create', $data);
    }
    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UserService $userService)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users',
            'firstName' => 'required|min:2',
            'lastName' => 'required|min:2',
            'phone' => 'required|numeric|min:10',
            'addressLine' => 'required',
            'addressCountry' => 'required',
            'driver_license_id' => 'required',
            'driver_license_class' => 'required',
            'driver_license_expiry' => 'required',
            'national_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $randomPassword = $this->randomSting(10);
        try {
            $driver_license_class = implode(",", $request->driver_license_class);
            $userData = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'phone' => $request->phone,
                "addressLine" => $request->addressLine,
                "is_active" => $request->has('is_active') ? '1' : '0',
                'password' => bcrypt($randomPassword),
                'addressCountry' => $request->addressCountry,
                'driver_license_id' => $request->driver_license_id,
                'driver_license_class' => $driver_license_class,
                'driver_license_expiry' => $request->driver_license_expiry,
                'national_id' => $request->national_id,
                'insurance_company' => $request->insurance_company,
                'ontrac_username' => $request->ontrac_username,
                'ontrac_password' => Crypt::encrypt($request->ontrac_username),
            ]);
            $roleArray = array(
                'user_id' => $userData->id,
                'role_id' => 3,
            );
            UserRoleRelation::insert($roleArray);
            $user = User::where('id', $userData->id)
                ->first();
            if ($userData) {
                $notificationData = [
                    "username" => $userData->name,
                    "message" => $userData->name,
                    "useremail" => $userData->email,
                    'userPassword' => $randomPassword,
                ];
                $user->notify(new UserCreation($notificationData));
            }
            return redirect('/admin/user-management')->with(['status' => 'success', 'message' => 'New user Successfully created!']);
        } catch (\Exception $e) {
            return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
            return back()->with(['status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.']);
        }
    }

    /**
     * Genrate a new random string .
     * @param  $length (int)
     * @return string
     */
    public function randomSting($length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        return $str;
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
            $user = User::find(\Crypt::decrypt($id));
            if ($user) {
                $data['user'] = $user;
                $data['roles'] = Role::get();
                $data['country'] = CountryModel::get();
                $data['company'] = User::with(['getRole'])
                    ->whereHas('roles', function ($q) {
                        $q->where('name', 'company');
                    })->get();
                $data['licenseClass'] = LicenseClassModel::Where('country_id', $user->addressCountry)
                    ->orderBy('license_class', 'ASC')
                    ->get();
                return view('admin.users.edit', $data);
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
        $rules = [
            'name' => 'required|min:2',
            'firstName' => 'required|min:2',
            'lastName' => 'required|min:2',
            'phone' => 'numeric|min:10',
            'addressLine' => 'required',
            'addressCountry' => 'required',
            'driver_license_id' => 'required',
            'driver_license_class' => 'required',
            'driver_license_expiry' => 'required',
            'national_id' => 'required',
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
            $driver_license_class = implode(",", $request->driver_license_class);

            $user = User::find(\Crypt::decrypt($id));
            $updateData = array(
                "name" => $request->has('name') ? $request->name : "",
                "firstName" => $request->has('firstName') ? $request->firstName : "",
                "lastName" => $request->has('lastName') ? $request->lastName : "",
                "addressLine" => $request->has('addressLine') ? $request->addressLine : "",
                "phone" => $request->has('phone') ? $request->phone : "",
                "is_active" => $request->has('is_active') ? '1' : '0',
                "addressCountry" => $request->has('addressCountry') ? $request->addressCountry : "",
                "driver_license_id" => $request->has('driver_license_id') ? $request->driver_license_id : "",
                "driver_license_class" => $request->has('driver_license_class') ? $driver_license_class : "",
                "driver_license_expiry" => $request->has('driver_license_expiry') ? $request->driver_license_expiry : "",
                "national_id" => $request->has('national_id') ? $request->national_id : "",
                "insurance_company" => $request->has('insurance_company') ? $request->insurance_company : "",
                "ontrac_username" => $request->has('ontrac_username') ? $request->ontrac_username : "",
            );
            $user->update($updateData);
            return redirect('/admin/user-management')->with(['status' => 'success', 'message' => 'Update record successfully.']);
        } catch (\exception $e) {
            //return back()->with(['status' => 'danger', 'message' =>  $e->getMessage()]);
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
        User::find(Crypt::decrypt($id))->delete();
    }
}
