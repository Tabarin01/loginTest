<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facedes\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'device_name' => 'required',
        ]);

        FacadesLog::info("FDIOAWDOI");
        $user = User::create([
            'usernname' => $validated['name'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->save();

        $token = $user->createToken($validated['device_name'])->plainTextToken;

        FacadesLog::info($token);

        return response()->json([
            'token' => $token,
        ]);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($validated['device_name'])->plainTextToken;

        return response()->json([
            'token' => $token,
        ]);
    }
}
