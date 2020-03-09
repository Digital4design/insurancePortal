<?php

namespace App\Http\Controllers\companies;

use App\Http\Controllers\Controller;
use App\Models\AssestModel;
use App\Models\CompanyRequestPermissionModel;
use App\Models\CountryModel;
use App\Models\LicenseClassModel;
use App\Models\PermissionPolicyHolderModel;
use App\Models\Role;
use App\Models\UserDetailsAccessModel;
use App\Models\UserRoleRelation;
use App\Notifications\Company\accessPermission;
use App\Notifications\Users\UserCreation;
use App\Services\UserService;
use App\User;
use Auth;
use Crypt;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Redirect;
use Validator;
use Yajra\Datatables\Datatables;

class UserManagementController extends Controller
{
    /**
     * construct.
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'company']);
    }
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['roles'] = Role::get();
        $data['permissionPolicy'] = PermissionPolicyHolderModel::get();
        return view('companies.users.index', $data);
    }
    /**
     * Process datatables ajax request.
     * @return \Illuminate\Http\JsonResponse
     */
    public function userData()
    {
        $result = AssestModel::where('tracker_id', '!=', '')->get();
        //dd($result);
        return Datatables::of($result)
            ->addColumn('action', function ($result) {
                return '<button type="button" class="btn btn-primary request_access" data-id=' . $result->id . '   data-toggle="modal"  data-target="#permissionModal"> Request Access</button>
                <a href ="' . url('company/user-management') . '/' . $result->id . '/show"  class="btn btn-primary request_access edit"><i class="fa ti-eye" aria-hidden="true"></i>View</a>';
            })->make(true);
    }
    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['roles'] = Role::get();
        return view('companies.users.create', $data);
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
            'email' => 'required|email|max:255|unique:users',
            'firstName' => 'required|min:2',
            'lastName' => 'required|min:2',
            'info' => 'required|min:2',
            'phone' => 'numeric|min:10',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $randomPassword = $this->randomSting(10);
        try {
            $userData = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'phone' => $request->phone,
                'info' => $request->info,
                'is_active' => $request->has('is_active') ? '1' : '0',
                'password' => bcrypt($randomPassword),
            ]);
            $roleArray = array(
                'user_id' => $userData->id,
                'role_id' => 3,
            );
            UserRoleRelation::insert($roleArray);
            $user = User::where('id', $userData->id)->first();
            if ($userData) {
                $notificationData = [
                    "username" => $userData->name,
                    "message" => $userData->name,
                    "useremail" => $userData->email,
                    'userPassword' => $randomPassword,
                ];
                $user->notify(new UserCreation($notificationData));
            }
            return redirect('/company/user-management')->with(['status' => 'success', 'message' => 'New user Successfully created!']);
        } catch (\Exception $e) {
            //return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
            return back()->with(['status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.']);
        }
    }
    /**
     * Genrate a new random string .
     * @param  $length (int)
     * @return string
     */

    public function accessRequest(Request $request)
    {
        try {
            $accessData = AssestModel::where('id', $request->requestUserId)
                ->get()
                ->toArray();

            $accessFirstData = UserDetailsAccessModel::where('assets_id', $accessData[0]['assets_id'])
                ->where('company_id', Auth::user()->id)
                ->get()
                ->toArray();
            //dd($accessData);

            if (empty($accessFirstData)) {
                $accessArray = array(
                    'user_id' => $accessData[0]['user_id'],
                    'company_id' => Auth::user()->id,
                    'assets_id' => $accessData[0]['assets_id'],
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                );
                $lastId = UserDetailsAccessModel::insertGetId($accessArray);
                //dd($lastId);

                foreach ($request->permission as $key => $permission_policy_id) {
                    CompanyRequestPermissionModel::insert(array(
                        'users_detail_id' => $lastId,
                        'permission_policy_id' => $permission_policy_id,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s"),
                    ));
                }
                $permissionPolicyData = PermissionPolicyHolderModel::whereIn('id', $request->permission)->get()->toArray();
                foreach ($permissionPolicyData as $key => $value) {
                    $perString[] = $value['permissions_name'];
                }
                $strPrer = implode(',', $perString);
                // $notifyUser = User::where('id', Auth::user()->id)->first();
                // if ($lastId > 0) {
                //     $notificationData = array(
                //         "username" => "Request for access",
                //         "message" => ucfirst(Auth::user()->name) . " has request <b>" . $strPrer . "</b> permissions for access details",
                //         "useremail" => Auth::user()->name,
                //         "companyName" => Auth::user()->name,
                //         "permission" => $strPrer,
                //     );
                //     $notifyUser->notify(new accessPermission($notificationData));
                // }
                if ($lastId > 0) {
                    return redirect('/company/user-management')->with(['status' => 'success', 'message' => 'Request send Successfully!']);
                } else {
                    return back()->with(['status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.']);
                }
            } else {
                foreach ($request->permission as $key => $permission_policy_id) {
                    $companyRequestData = CompanyRequestPermissionModel::where('users_detail_id', $accessData[0]['id'])
                        ->where('permission_policy_id', $permission_policy_id)
                        ->get()
                        ->toArray();
                    if (empty($companyRequestData)) {
                        CompanyRequestPermissionModel::insert(array(
                            'users_detail_id' => $accessData[0]['id'],
                            'permission_policy_id' => $permission_policy_id,
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ));
                    }
                }
                $permissionPolicyData = PermissionPolicyHolderModel::whereIn('id', $request->permission)->get()->toArray();
                foreach ($permissionPolicyData as $key => $value) {
                    $perString[] = $value['permissions_name'];
                }
                $strPrer = implode(',', $perString);
                $notifyUser = User::where('id', Auth::user()->id)->first();
                if ($notifyUser) {
                    $notificationData = array(
                        "username" => "Request for access",
                        "message" => ucfirst(Auth::user()->name) . " has request " . $strPrer . " permissions for access details",
                        "useremail" => Auth::user()->name,
                        "companyName" => Auth::user()->name,
                        "permission" => $strPrer,
                    );
                    $notifyUser->notify(new accessPermission($notificationData));
                }
                return redirect('/company/user-management')->with(['status' => 'success', 'message' => 'Request resend Successfully!']);
            }
        } catch (\Exception $e) {
            return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }
    }
    public function accessPermission($id)
    {
        try {
            $accessData = UserDetailsAccessModel::where('user_id', \Crypt::decrypt($id))
                ->where('company_id', Auth::user()->id)
                ->get()
                ->toArray();
            if (empty($accessData)) {
                $accessArray = array(
                    'company_id' => Auth::user()->id,
                    'user_id' => \Crypt::decrypt($id),
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                );
                $userDetails = UserDetailsAccessModel::insert($accessArray);
                $user = User::where('id', \Crypt::decrypt($id))->first();
                if ($userDetails) {
                    $notificationData = [
                        "username" => "Request for access",
                        "message" => "Request for access",
                        "useremail" => Auth::user()->name,
                        "companyName" => Auth::user()->name,
                    ];
                    $user->notify(new accessPermission($notificationData));
                }
                if ($userDetails) {
                    return redirect('/company/user-management')->with(['status' => 'success', 'message' => 'Request send Successfully!']);
                } else {
                    return back()->with(['status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.']);
                }
            } else {
                return redirect('/company/user-management')->with(['status' => 'danger', 'message' => 'Request already send']);
            }
        } catch (\Exception $e) {
            // return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
            return back()->with(['status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.']);

        }
    }
    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request, UserService $userService)
    {
        try {
            $accessData = UserDetailsAccessModel::where('user_id', \Crypt::decrypt($id))
                ->where('company_id', Auth::user()->id)
                ->where('accept_status', '1')
                ->get()
                ->toArray();
            if (!empty($accessData)) {
                $user = User::find(\Crypt::decrypt($id));
                if ($user) {
                    $login = 'user/auth?login=' . $user->ontrac_username . '&password=' . Crypt::decrypt($user->ontrac_password);
                    $userData = $userService->callAPI($login);
                    if ($userData['success'] == 'true') {
                        if (isset($userData['hash'])) {
                            $hash = $userData['hash'];
                        } else {
                            $hash = '';
                        }
                        $request->session()->put('hash', $hash);
                        $sessiondata = $request->session()->all();
                        $trackerListUrl = "tracker/list?hash=" . $sessiondata['hash'];
                        // dd($trackerListUrl);

                        $data['trackerData'] = $userService->callAPI($trackerListUrl);
                        $data['trackerData'] = $data['trackerData']['list'];
                        $tracke_id = array();
                        foreach ($data['trackerData'] as $tracker) {
                            $tracke_id[] = $tracker['id'];
                        }
                        $tracke_id = implode(',', $tracke_id);
                        // employee Data
                        $requestUrl = "employee/list?hash=" . $sessiondata['hash'];
                        $data['employeeData'] = $userService->callAPI($requestUrl);
                        $data['employeeData'] = $data['employeeData']['list'];

                        $trackerlistUrl = 'history/tracker/list?hash=' . $sessiondata['hash'] . '&trackers=[' . $tracke_id . ']&from=2020-01-01%2000:00:00&to=2020-01-02%2023:59:59&events=[%22input_change%22,%20%22security_control%22,%20%22harsh_driving%22,%22speedup%22]';
                        //dd($trackerlistUrl);
                        $data['trackerlistData'] = $userService->getTrackerList($trackerlistUrl);
                        //dd($data['trackerlistData']);

                    } else {
                        $data['employeeData'] = array();
                        $data['trackerData'] = array();
                        $data['trackerlistData'] = array();
                    }
                    $data['user'] = $user;
                    $data['roles'] = Role::get();
                    $data['permission'] = DB::table('company_request_permission')
                        ->select('company_request_permission.*', 'permission_policy_holder.permissions_name')
                        ->join('permission_policy_holder', 'permission_policy_holder.id', '=', 'company_request_permission.permission_policy_id')
                        ->where(['company_request_permission.users_detail_id' => $accessData[0]['id']])
                        ->get();
                    $data['country'] = CountryModel::where('id', $user->addressCountry)->get()->toArray();
                    $data['licenseClass'] = LicenseClassModel::where('id', $user->driver_license_class)->get()->toArray();
                    // dd($data);
                    return view('companies.users.view_user', $data);
                }
            } else {
                return redirect('/company/user-management')->with(['status' => 'danger', 'message' => 'You have not access permissions!']);
            }
        } catch (\Exception $e) {
            return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    public function testShow($id, Request $request, UserService $userService)
    {
        $trackerData = AssestModel::where('tracker_id', '!=', '')->where('id', $id)->get()->toArray();
        $userId = $trackerData[0]['user_id'];
        $userId = $trackerData[0]['user_id'];
        $tracker_id = $trackerData[0]['tracker_id'];

        $data['userId'] = $trackerData[0]['user_id'];
        $user = User::find($trackerData[0]['user_id']);
        return view('companies.users.testVeiw')->with(array('userId' => $userId,'assets_id'=>$id ,'userName' => $user['name']));
    }
    public function getTrackers($id, Request $request, UserService $userService)
    {
        $trackerData = AssestModel::where('tracker_id', '!=', '')->where('id', $id)->get()->toArray();
       

        $userId = $trackerData[0]['user_id'];
        $tracker_id = $trackerData[0]['tracker_id'];
        $assets_id = $trackerData[0]['assets_id'];
        

        $user = User::find($trackerData[0]['user_id']);
        if (!empty($trackerData)) {
            $permissionList = UserDetailsAccessModel::select('assets_id')->where('assets_id', $assets_id)->get()->toArray();
            // dd($permissionList);
            $user = User::find($trackerData[0]['user_id']);

            if ($user) {
                $data = array();

                $login = 'user/auth?login=' . $user->ontrac_username . '&password=' . Crypt::decrypt($user->ontrac_password);
                $userData = $userService->callAPI($login);
                if ($userData['success'] == 'true') {
                    if (isset($userData['hash'])) {
                        $hash = $userData['hash'];
                    } else {
                        $hash = '';
                    }
                    $request->session()->put('hash', $hash);
                    $sessiondata = $request->session()->all();
                    $trackerListUrl = "tracker/list?hash=" . $sessiondata['hash'];
                    $trackerData = $userService->callAPI($trackerListUrl);
                    
                    foreach ($trackerData['list'] as $tracker) {
                        if ($tracker_id = $tracker['id']) {
                            $data[] = $tracker;
                        } else {
                            $data[] = array();
                        }
                    }
                    //dd($data);
                    // $filter = array_filter($data['trackerData']['list'], function ($Fdata) use ($permissionList) {
                    //     return (array_filter($permissionList, function ($ldata) use ($Fdata) {
                    //         return ($Fdata['id'] == $ldata['assets_id']) ? $Fdata : [];
                    //     }));
                    // });
                    // if ($filter) {
                    //     $data = $filter;
                    // } else {
                    //     $data = array();
                    // }
                } else {
                    $data = array();
                }
                //print_r($data);
                //dd($data);
                return Datatables::of($data)
                    ->addColumn('action', function ($data) use ($userId) {
                        return '<a href ="' . url('company/user-management/') . '/' . $data['id'] . '/' . $userId . '/reportShow"  class="btn btn-primary request_access edit"><i class="fa ti-eye" aria-hidden="true"></i>Veiw Report</a>';
                    })->make(true);
            }
        } else {
            $data = array();
            return Datatables::of($data)
                ->addColumn('action', function ($data) use ($userId) {
                    return '<a href ="' . url('company/user-management/') . '/' . $data['id'] . '/' . $userId . '/reportShow"  class="btn btn-primary request_access edit"><i class="fa ti-eye" aria-hidden="true"></i>Veiw Report</a>';
                })->make(true);

        }
    }

    public function getTrackersReport($id, $user_id)
    {
        //echo $id."<br>".$user_id;die;

        return view('companies.users.testReport')->with(array('userId' => $user_id, 'trackerId' => $id));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getTrackersReportData($id, $user_id, $startData, $endDate, Request $request, UserService $userService)
    {
        $accessData = UserDetailsAccessModel::where(array('company_id' => Auth::user()->id, 'accept_status' => '1', 'user_id' => $user_id))->get()->toArray();
        if ($accessData) {
            // try {
            // Get Last Gps Point Data
            $sessiondata = $request->session()->all();
            $currentData = $startData;
            $lastData = $endDate;
            $lastGpsPointUrl = "tracker/get_last_gps_point/?tracker_id=" . $id . "&hash=" . $sessiondata['hash'];
            $data['lastGpsPointData'] = $userService->callAPI($lastGpsPointUrl);

            $data['lastGpsPointData'] = $data['lastGpsPointData']['value'];
            // Get State Data

            $getStateUrl = "tracker/get_state/?tracker_id=" . $id . "&hash=" . $sessiondata['hash'];
            $data['getStateData'] = $userService->callAPI($getStateUrl);
            $data['getStateData'] = $data['getStateData']['state'];

            // Get Readings Data
            $readingsUrl = "tracker/readings/list/?hash=" . $sessiondata['hash'] . "&tracker_id=" . $id;
            $data['getReadingsData'] = $userService->callAPI($readingsUrl);

            // Get Tracker List Data
            $userData = User::find($user_id);
            $trackerlistUrl = 'history/tracker/list?hash=' . $sessiondata["hash"] . '&trackers=[' . $id . ']&from=' . $currentData . '%2000:00:00&to=' . $lastData . '%2023:59:59';
            // dd($trackerlistUrl);
            $data['trackerlistData'] = $userService->getTrackerList($trackerlistUrl);
            if (!empty($data['trackerlistData']['list'])) {
                $data['trackerlistData'] = array_reverse($data['trackerlistData']['list']);
                $data['trackerlistData'] = $data['trackerlistData'][0];
                $lat = $data['trackerlistData']['location']['lat'];
                $log = $data['trackerlistData']['location']['lng'];
                $location = $lat . ',' . $log;
            } else {
                $location = '';
            }
            // Get Odometer Data
            $odometerUrl = "tracker/counter/read/?tracker_id=" . $id . "&hash=" . $sessiondata['hash'] . "&type=odometer";
            $data['odometerData'] = $userService->getTrackerList($odometerUrl);
            if ($data['odometerData']['success'] == true) {
                $data['odometerData'] = $data['odometerData']['value']['multiplier'];
            } else {
                $data['odometerData'] = 0;
            }
            $dateArray = $this->getDatesFromRange($currentData, $lastData, $format = 'Y-m-d');
            // Get Mileage Data
            $requestUrl = "tracker/stats/mileage/read/?hash=" . $sessiondata['hash'] . "&trackers=[" . $id . "]&from=" . $currentData . "%2000:00:00&to=" . $lastData . "%2023:59:59";
            $data['mileageData'] = $userService->callAPI($requestUrl);
            $sum = 0;
            foreach ($data['mileageData']['result'] as $key => $mileageD) {
                $sum += $mileageD[$currentData]['mileage'];
            }
            // Get User Access Details
            $harshUrl = 'history/tracker/list?hash=' . $sessiondata["hash"] . '&trackers=[' . $id . ']&from=2020-02-08%2008:00:00&to=2020-02-10%2023:59:59&events=["harsh_driving","speedup"]';
            $data['harshData'] = $userService->callAPI($harshUrl);

            if ($data['harshData']['success'] == true) {
                $harshD = array();
                $harD = array();

                foreach ($data['harshData']['list'] as $key => $harsh) {
                    if ($harsh['event'] == 'speedup') {
                        array_push($harshD, $harsh);
                    }
                    // if ($harsh['event'] == 'harsh_driving') {
                    //     array_push($$harD, $harsh);
                    // }
                }
            }
            $data['speeding'] = DB::table('speeding')
                ->where(['company_id' => Auth::user()->id])
                ->get();
            $count = count($harshD);
            //dd($harD);

            // dd($data['speeding']);

            if ($count > 0) {
                if ($count == 1) {
                    $rating = '9';
                } else if ($count == 5) {
                    $rating = '5';
                } else if ($count >= 10) {
                    $rating = '0';
                } else {
                    $rating = $count;
                }
            } else {
                $rating = '10';
            }
            $data['permission'] = DB::table('company_request_permission')
                ->select('company_request_permission.*', 'permission_policy_holder.permissions_name')
                ->join('permission_policy_holder', 'permission_policy_holder.id', '=', 'company_request_permission.permission_policy_id')
                ->where(['company_request_permission.users_detail_id' => $accessData[0]['id']])
                ->get();

            $data['permissionData'] = DB::table('permission_list')
                ->select('permission_list.*', 'permission_policy_holder.permissions_name')
                ->join('permission_policy_holder', 'permission_policy_holder.id', '=', 'permission_list.permission_id')
                ->where(['permission_list.access_id' => $accessData[0]['id']])
                ->get();
            // dd($data['permissionData']);

            foreach ($data['permissionData'] as $key => $permission) {
                //dd($permission);
                if ($permission->permissions_name == "Location") {
                    $location = $location;
                    // if ($permission->accept_status == "1") {
                    //     $location = $location;
                    // } else {
                    //     $location = $location;
                    // }
                } else if ($permission->permissions_name == "Odometer") {
                    $odometerData = $data['odometerData'];
                    // if ($permission->accept_status == "1") {
                    //     $odometerData = $data['odometerData'];
                    // } else {
                    //     $odometerData = 'Odometer No Permission';
                    // }
                } else if ($permission->permissions_name == "Violations") {
                    $retaing = $rating;
                    // if ($permission->accept_status == "1") {
                    //     $retaing = $rating;
                    // } else {
                    //     $retaing = $rating;
                    // }
                } else if ($permission->permissions_name == "Mileage") {
                    $milage = $data['lastGpsPointData']['mileage'];
                    if ($milage) {
                        $milage = $milage;
                    } else {
                        $milage = 'Mileage No Permission';
                    }
                } else {

                }
            }
            $result = array(
                array(
                    'userData' => $userData['name'],
                    //'mileage' => $milage,
                    'rating' => 0,

                    //'rating' => $retaing,
                    'mileageDa' => $sum,
                    'odometer' => $odometerData,
                ),
            );
        } else {
            $result = array();
        }
        //dd($result);
        return Datatables::of($result)->addColumn('action', function ($result) use ($location) {
            return '<a href="https://www.google.com/maps/dir//' . $location . '" target="_blank"><i class="mdi mdi-map-marker"></i> Map</a>';
        })->make(true);
    }

    public function getTrackerData($id, $user_id, Request $request, UserService $userService)
    {
        $accessData = UserDetailsAccessModel::where(['company_id' => Auth::user()->id, 'accept_status' => '1', 'user_id' => $user_id])->get()->toArray();
        if ($accessData) {
            // try {
            // Get Last Gps Point Data
            $sessiondata = $request->session()->all();
            $currentData = date('Y-m-d');
            $lastData = date("Y-m-t", strtotime($currentData));
            $lastGpsPointUrl = "tracker/get_last_gps_point/?tracker_id=" . $id . "&hash=" . $sessiondata['hash'];
            $data['lastGpsPointData'] = $userService->callAPI($lastGpsPointUrl);

            $data['lastGpsPointData'] = $data['lastGpsPointData']['value'];
            // Get State Data

            $getStateUrl = "tracker/get_state/?tracker_id=" . $id . "&hash=" . $sessiondata['hash'];
            $data['getStateData'] = $userService->callAPI($getStateUrl);
            $data['getStateData'] = $data['getStateData']['state'];

            // Get Readings Data
            $readingsUrl = "tracker/readings/list/?hash=" . $sessiondata['hash'] . "&tracker_id=" . $id;
            $data['getReadingsData'] = $userService->callAPI($readingsUrl);

            // Get Tracker List Data
            $userData = User::find($user_id);
            $trackerlistUrl = 'history/tracker/list?hash=' . $sessiondata["hash"] . '&trackers=[' . $id . ']&from=2020-02-04%2000:00:00&to=2020-02-05%2023:59:59';
            $data['trackerlistData'] = $userService->getTrackerList($trackerlistUrl);
            if (!empty($data['trackerlistData']['list'])) {
                $data['trackerlistData'] = array_reverse($data['trackerlistData']['list']);
                $data['trackerlistData'] = $data['trackerlistData'][0];
                $lat = $data['trackerlistData']['location']['lat'];
                $log = $data['trackerlistData']['location']['lng'];
                $location = $lat . ',' . $log;
            } else {
                $location = '';
            }
            // Get Odometer Data
            $odometerUrl = "tracker/counter/read/?tracker_id=" . $id . "&hash=" . $sessiondata['hash'] . "&type=odometer";
            $data['odometerData'] = $userService->getTrackerList($odometerUrl);
            if ($data['odometerData']['success'] == true) {
                $data['odometerData'] = $data['odometerData']['value']['multiplier'];
            } else {
                $data['odometerData'] = 0;
            }
            $dateArray = $this->getDatesFromRange($currentData, $lastData, $format = 'Y-m-d');
            // Get Mileage Data
            $requestUrl = "tracker/stats/mileage/read/?hash=" . $sessiondata['hash'] . "&trackers=[" . $id . "]&from=" . $currentData . "%2000:00:00&to=" . $lastData . "%2023:59:59";
            $data['mileageData'] = $userService->callAPI($requestUrl);
            $sum = 0;
            foreach ($data['mileageData']['result'] as $key => $mileageD) {
                $sum += $mileageD[$currentData]['mileage'];
            }
            // Get User Access Details
            $harshUrl = 'history/tracker/list?hash=' . $sessiondata["hash"] . '&trackers=[' . $id . ']&from=2020-02-08%2008:00:00&to=2020-02-10%2023:59:59&events=["harsh_driving","speedup"]';
            $data['harshData'] = $userService->callAPI($harshUrl);

            if ($data['harshData']['success'] == true) {
                $harshD = array();
                foreach ($data['harshData']['list'] as $key => $harsh) {
                    if ($harsh['event'] == 'speedup') {
                        array_push($harshD, $harsh);
                    }
                }
            }
            $count = count($harshD);
            if ($count > 0) {
                if ($count == 1) {
                    $rating = '9/10';
                } else if ($count == 5) {
                    $rating = '5/10';
                } else if ($count >= 10) {
                    $rating = '0/10';
                } else {
                    $rating = $count . '/10';
                }
            } else {
                $rating = $count . '/10';
            }
            $data['permission'] = DB::table('company_request_permission')
                ->select('company_request_permission.*', 'permission_policy_holder.permissions_name')
                ->join('permission_policy_holder', 'permission_policy_holder.id', '=', 'company_request_permission.permission_policy_id')
                ->where(['company_request_permission.users_detail_id' => $accessData[0]['id']])
                ->get();
            foreach ($data['permission'] as $key => $permission) {
                if ($permission->permissions_name == "Location") {
                    if ($permission->accept_status == "1") {
                        $location = $location;
                    } else {
                        $location = $location;
                    }
                } else if ($permission->permissions_name == "Odometer") {
                    if ($permission->accept_status == "1") {
                        $odometerData = $data['odometerData'];
                    } else {
                        $odometerData = 'Odometer No Permission';
                    }
                } else if ($permission->permissions_name == "Violations") {
                    if ($permission->accept_status == "1") {
                        $retaing = $rating;
                    } else {
                        $retaing = $rating;
                    }
                } else if ($permission->permissions_name == "Mileage") {
                    if ($permission->accept_status == "1") {
                        $milage = $data['lastGpsPointData']['mileage'];
                    } else {
                        $milage = 'Mileage No Permission';
                    }
                } else {

                }
            }
            $result = array(array(
                'userData' => $userData['name'],
                'mileage' => $milage,
                'rating' => $retaing,
                'mileageDa' => $sum,
                'odometer' => $odometerData,
            ),
            );
        } else {
            $result = array();
        }
        return Datatables::of($result)->addColumn('action', function ($result) use ($location) {
            return '<a href="https://www.google.com/maps/dir//' . $location . '" target="_blank"><i class="mdi mdi-map-marker"></i> Map</a>';
        })->make(true);
    }
    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     **/
    public function edit($id)
    {
        try {
            $user = User::find(\Crypt::decrypt($id));
            if ($user) {
                $data['user'] = $user;
                $data['roles'] = Role::get();
                return view('companies.users.edit', $data);
            }
        } catch (\Exception $e) {
            // return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
            return back()->with(['status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.']);
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
        $rules = array(
            'name' => 'required|min:2',
            'firstName' => 'required|min:2',
            'lastName' => 'required|min:2',
            'info' => 'required|min:2',
            'phone' => 'numeric|min:10',
        );
        $messages = array(
            'name.min' => 'First name should contain at least 2 characters.',
            'phone.min' => 'Phone Number should be min 10 digit.',
            'phone.numeric' => 'only digit are allowed',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $user = User::find(\Crypt::decrypt($id));
            $updateData = array(
                "name" => $request->has('name') ? $request->name : "",
                "firstName" => $request->has('firstName') ? $request->firstName : "",
                "lastName" => $request->has('lastName') ? $request->lastName : "",
                "info" => $request->has('info') ? $request->info : "",
                "phone" => $request->has('phone') ? $request->phone : "",
                "is_active" => $request->has('is_active') ? '1' : '0',
            );
            $user->update($updateData);
            return redirect('/company/user-management')->with(['status' => 'success', 'message' => 'Update record successfully.']);
        } catch (\exception $e) {
            //return back()->with(['status' => 'danger', 'message' =>  $e->getMessage()]);
            return back()->with(['status' => 'danger', 'message' => 'Some thing went wrong! Please try again later.']);
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * */
    public function destroy($id)
    {
        User::find(Crypt::decrypt($id))->delete();
    }
    /**
     * Generate random String
     * */
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
     * Generate random String
     *
     *
     * */

    public function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {
        // Declare an empty array
        $array = array();
        // Variable that store the date interval of period 1 day
        $interval = new DateInterval('P1D');
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
        // Use loop to store date into array
        foreach ($period as $date) {
            $array[] = $date->format($format);
        }
        // Return the array elements
        return $array;
    }
}
