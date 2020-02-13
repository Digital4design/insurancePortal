<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Stripe\Stripe;

class TestStripeController extends Controller
{
    public function __construct()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }
    /**
     * Create a new stripe user.
     * @return void
     */
    public function stripeAccountCreate()
    {
        try {
            // $name = Auth::user()->firstName . " " . Auth::user()->lastName;
            // dd($name);
            // $email = Auth::user()->email;
            $uri = $_ENV['STRIPE_URL'];
            header("location: $uri");
            dd($uri);
        } catch (\Stripe\Error\Card $e) {
            return response()->json($e->getJsonBody());
        } catch (\Stripe\Error\RateLimit $e) {
            return response()->json($e->getJsonBody());
        } catch (\Stripe\Error\InvalidRequest $e) {
            return response()->json($e->getJsonBody());
        } catch (\Stripe\Error\Authentication $e) {
            return response()->json($e->getJsonBody());
        } catch (\Stripe\Error\ApiConnection $e) {
            return response()->json($e->getJsonBody());
        } catch (\Stripe\Error\Base $e) {
            return response()->json($e->getJsonBody());
        } catch (Exception $e) {
            return response()->json($e->getJsonBody());
        }
    }
    /*
    | Authonticate user and update with code
    |*/
    public function stripeUpdate()
    {
        $code = $_REQUEST['code'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://connect.stripe.com/oauth/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "client_secret=" . getenv('STRIPE_SECRET') . "&code=$code&grant_type=authorization_code");
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        $dataSrtipe = json_decode($data);
        var_dump($dataSrtipe);
        $stripeId = $dataSrtipe->stripe_user_id;
        Auth::user()->id;
        $user_save = User::where('id', Auth::user()->id)->first();
        $user_save->stripe_acc_id = $stripeId;
        $user_save->save();
        // return response()->json(['status' => 'success', 'message' => 'Now You are varify successfully.']);
        return redirect('/admin');
        // header("location: $dashboard");
        // $dashboard = url('/dashboard');
        return response()->json(curl_exec($ch));
    }
    public function charge(Request $request)
    {
        $token = $request->stripeToken;
        if ($token) {
            $customer = \Stripe\Customer::create(array(
                "source" => $token,
                "name" => Auth::user()->name,
                "email" => Auth::user()->email,
                "description" => Auth::user()->first_name . " " . Auth::user()->last_name,
            ));
            DB::table('users')->where('id', Auth::user()->id)->update(['stripe_token' => $customer['id']]);
            return response()->json(['status' => 'success', 'message' => 'Now You are varify successfully.']);
        } else {
            return response()->json(['status' => 'danger', 'message' => 'You are not varify successfully.']);
        }
    }
}
