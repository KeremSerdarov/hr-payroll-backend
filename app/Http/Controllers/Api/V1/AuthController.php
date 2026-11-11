<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['E-poçta ýa-da parol nädogry.'],
            ]);
        }

        abort_unless($user->role === 'employee', 403, 'Bu API diňe işgärler üçin.');

        $employee = $user->employee()->with(['user', 'department'])->firstOrFail();
        $token = $user->createToken('employee-api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'employee' => EmployeeResource::make($employee)->resolve($request),
        ]);
    }

    public function logout(Request $request)
    {
        // Diňe şu token pozulýar; beýleki enjamlardaky tokenler galýar.
        $token = $request->user()->currentAccessToken();
        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }

        return response()->json(['message' => 'Ulgamdan çykdyňyz.']);
    }

    public function me(Request $request)
    {
        $employee = $request->user()->employee()->with(['user', 'department'])->firstOrFail();

        return EmployeeResource::make($employee);
    }
}
