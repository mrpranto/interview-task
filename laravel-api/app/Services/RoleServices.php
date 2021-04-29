<?php


namespace App\Services;


use App\Models\Role;
use App\Models\User;

class RoleServices extends BaseServices
{

    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    public function validate($request): RoleServices
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        return $this;
    }

    public function store($request): bool
    {
       $this->model::query()->create([
            'name' => $request->name,
            'description' => $request->description
        ]);

       return true;
    }

    public function update($request, $role): bool
    {
        $role->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

       return true;
    }

    public function deleteRole($role): bool
    {
        $users = User::query()->where('role_id', $role->id)->pluck('id');

        User::query()
            ->whereIn('id', $users)
            ->update([
                'role_id' => null
            ]);

        $role->delete();

        return true;
    }

}
