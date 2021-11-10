<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Pusher\PushNotifications\PushNotifications;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        if(!Auth::attempt($request->only(['email','password']),true)) {
            return redirect()->back()->withError('Failed to authenticate the credential given, Please try again.');
        }

        $user = Auth::user();

        if($user->isClient()) {
            return redirect()->route('client.home');
        }

        if($user->isStaff() || $user->isAdmin()) {
            return redirect()->route('staff.home');
        }

        return abort(500);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        if(!$request->expectsJson()) {
            return redirect()->route('login');
        }

        return response()->json([
            'message' => 'Sucessfully logout'
        ]);
    }

    public function token(Request $request, PushNotifications $beamsClient)
    {
        $userID = "user_id_".$request->user()->id;
        $userIDInQueryParam = $request->user_id;

        if ($userID != $userIDInQueryParam) {
            return response('Authentication request error', 401);
        } else {
            $beamsToken = $beamsClient->generateToken($userID);
            return response()->json($beamsToken);
        }
    }

    public function register(Request $request)
    {
        $file = $request->file('avatar');
        $avatar = url('dist/img/avatar.png');

        if(!is_null($file)) {
            $avatar = url('dist/img/'.$file->getClientOriginalName());
            $file->move(public_path('dist/img'),$file->getClientOriginalName());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'CLIENT',
            'password' => Hash::make($request->password),
            'avatar' => $avatar
        ]);

        $user->detail()->create([
            'pet_name' => $request->pet_name,
            'pet_category' => $request->pet_category,
            'address' => $request->address,
            'contact_number' => $request->contact_number
        ]);

        Auth::loginUsingId($user->id);

        return redirect()->route('client.home');
    }
}
