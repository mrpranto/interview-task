<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AuthServices extends BaseServices
{

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function validateRegister($request): AuthServices
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'min:8'],
        ]);

        return $this;
    }

    public function registerUser($request): JsonResponse
    {
        $user = $this->model::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token
        ], 201);
    }


    public function validateLogin($request): AuthServices
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'min:8'],
        ]);

        return $this;
    }


    public function getLoginResponse($request): JsonResponse
    {
        $user = $this->model::query()->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            throw ValidationException::withMessages([
                'email' => 'Invalid Credentials'
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token
        ], 201);
    }

}
