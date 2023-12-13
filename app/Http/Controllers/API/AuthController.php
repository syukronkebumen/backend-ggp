<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string|min:6',
            ]);
            $credentials = $request->only('email', 'password');
            $token = Auth::attempt($credentials);
            
            if (!$token) {
                return response()->json([
                    'success' => false,
                    'data' => '',
                    'message' => 'Unauthorized',
                ], 401);
            }
    
            $data['email'] = $request->email;
            $data['token'] = $token;
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Berhasil Login'
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'Berhasil Register'
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_user()
    {
        try {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'Berhasil get user'
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function logout()
    {
        try {
            $auth = Auth::logout();
            return response()->json([
                'success' => true,
                'data' => $auth,
                'message' => 'Berhasil logout'
            ]);     
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function refresh()
    {
        try {
            return response()->json([
                'user' => Auth::user(),
                'authorisation' => [
                    'token' => Auth::refresh(),
                    'type' => 'bearer',
                ]
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function successResponse($data, $message){
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message
        ]);
    }
}
