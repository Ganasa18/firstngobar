<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\PasswordValidationRules;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller

{

    use PasswordValidationRules;

    public function login(Request $request)
    {
        // validasi input
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required',
            ]);

            // cek credential login
            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized',
                ], 'Authentication Failed', 500);
            }

            //  jika hash tidak sesuai beri error
            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password)) {
                throw new \Exception('Invalid Credential');
            }

            // jika berhasil login
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return responseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Authentication');

            // catch jika error login
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error->getMessage(),
            ], 'Authentication Failed', 500);
        }
    }


    public function register(Request $request)
    {
        try {
            
            // validasi input             
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules()
            ]);
            
            
            // membuat user baru ke table             
            User::create([
                'name' =>  $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'is_active' => $request->is_active,
                'role' => $request->role,
            ]);
            
            // dapatkan data user yang sudah dibuat             
            $user = User::where('email', $request->email)->first();
            
            // membuat token user             
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'User Registered');
        } catch (Exception $error) {

            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);

            // return response()->json(['error' => $error->getMessage()], 500);
        }
    }
}
