<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
class PassportAuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'username'  => 'required|min:4',
            'firstname' => 'required|min:4',
            'image'     => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:20483',
            'email'     => 'required|email',
            'password'  => 'required|min:8',
        ]);
        
        $image_path = $request->file('image')->store('image', 'public');
 
        $user = User::create([
            'username'      => $request->username,
            'firstname'     => $request->firstname,
            'lastname'      => $request->lastname,
            'dateofbirth'   => $request->dateofbirth,
            'phonenumber'   => $request->phonenumber,
            'image'         => $image_path,
            'email'         => $request->email,
            'password'      => bcrypt($request->password)
        ]);
       
        $token = $user->createToken('LaravelAuthApp')->accessToken;        

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }
 
    /**
     * Login
     */
    public function login(Request $request)
    {
        $data = [
            'email'     => $request->email,
            'password'  => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json([
                'success' => true,
                'token' => $token
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }   
}