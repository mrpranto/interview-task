<?php


namespace App\Services;


use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserServices extends BaseServices
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function validate($request): UserServices
    {
        $request->validate([

            'phone' => 'required|max:255',
            'city' => 'nullable|max:255',
            'district' => 'nullable|max:255',
            'address' => 'nullable',

        ]);

        return $this;
    }

    public function update($request, $user): JsonResponse
    {
        if ($user->profile) {
            $user->profile()->update([

                'phone' => $request->phone,
                'city' => $request->city,
                'district' => $request->district,
                'address' => $request->address,

            ]);

        }else{

            Profile::query()->create([

                'user_id' => $user->id,
                'phone' => $request->phone,
                'city' => $request->city,
                'district' => $request->district,
                'address' => $request->address,
            ]);
        }

        return response()->json([

            'success' => true,
            'user' => $user->load('profile')

        ], 201);
    }


    public function validateAssignRole($request): UserServices
    {
        $request->validate([
            'role_id' => 'required|exists:App\Models\Role,id',
        ]);

        return $this;
    }


    public function assign($request, $user): bool
    {
        $user->update([
            'role_id' => $request->role_id
        ]);

        return true;
    }
}
