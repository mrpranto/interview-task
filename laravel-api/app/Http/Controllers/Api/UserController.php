<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(UserServices $services)
    {
        $this->service = $services;
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'users' => $this->service
                ->with('profile', 'role')
                ->orderByDesc('id')
                ->get()
        ]);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        return $this->service
                ->validate($request)
                ->update($request, $user);

    }

    public function show(User $user): User
    {
        return $user->load('profile');
    }

    public function assignRole(Request $request, User $user): JsonResponse
    {
        $this->service
            ->validateAssignRole($request)
            ->assign($request, $user);

        return response()->json([
            'success' => true,
            'message' => 'Role assign successful'
        ]);
    }
}
