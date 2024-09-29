<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\APIController as Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = $request->user();
            $success['token'] =  $user->createToken('Apotek')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User berhasil login.');
        } else {
            return $this->sendError([], 'Unauthorized', 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse([], 'User berhasil logout.');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validasi error.', $validator->errors());
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $success['name'] =  $user->name;
        $success['email'] =  $user->email;
        $success['token'] =  $user->createToken('Apotek')->plainTextToken;

        return $this->sendResponse($success, 'User berhasil register.');
    }
}
