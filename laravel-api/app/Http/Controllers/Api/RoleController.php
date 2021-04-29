<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\RoleServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(RoleServices $services)
    {
        $this->service = $services;
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'roles' => $this->service
                ->orderByDesc('id')
                ->get()
        ]);
    }


    public function store(Request $request): JsonResponse
    {
        $this->service
            ->validate($request)
            ->store($request);

        return response()->json([
            'success' => true,
            'message' => "Role Create Successful"
        ], 201);
    }


    public function show(Role $role): Role
    {
        return $role->load('permissions');
    }


    public function update(Request $request, Role $role): JsonResponse
    {
        $this->service
            ->validate($request)
            ->update($request, $role);

        return response()->json([
            'success' => true,
            'message' => "Role Update Successful"
        ], 201);
    }


    public function destroy(Role $role): JsonResponse
    {
        $this->service->deleteRole($role);

        return response()->json([
            'success' => true,
            'message' => 'Role delete successful'
        ]);
    }
}
