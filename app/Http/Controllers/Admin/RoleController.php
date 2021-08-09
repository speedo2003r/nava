<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\Create;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    protected $roleRepo;

    public function __construct(Role $role)
    {
        $this->roleRepo = $role;
    }

    /***************************  get all roles  **************************/
    public function index()
    {
        $roles = $this->roleRepo->get();
        return view('admin.roles.index', compact('roles'));
    }

    /***************************  get all roles  **************************/
    public function create()
    {
        return view('admin.roles.create');
    }

    /***************************  get all roles  **************************/
    public function store(Create $request)
    {


        $role = $this->roleRepo->create($request->all());

        $permissions = [];
        foreach ($request->permissions ?? [] as $permission)
            $permissions[]['permission'] = $permission;

        $role->permissions()->createMany($permissions);

        return redirect(route('admin.roles.index'))->with('success', 'تم الاضافه بنجاح');
    }

    /***************************  get all roles  **************************/
    public function edit($id)
    {
        $role = Role::find($id);
        return view('admin.roles.edit', compact('role'));
    }

    /***************************  get all roles  **************************/
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
        ]);
        $role->permissions()->delete();
        $permissions = [];
        foreach ($request->permissions ?? [] as $permission)
            $permissions[]['permission'] = $permission;

        $role->permissions()->createMany($permissions);

        return redirect(route('admin.roles.index'))->with('success', 'تم التحديث بنجاح');
    }

    /***************************  destroy  **************************/
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete($role['id']);
        return redirect(route('admin.roles.index'))->with('success', 'تم الحذف بنجاح');
    }
}
