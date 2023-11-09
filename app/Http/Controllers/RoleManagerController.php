<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleManagerController extends Controller
{
    function role_manager() {
        $permissions = Permission::all();
        $roles = Role::all();
        $users = User::all();
        return view('admin.role.role',[
            'permissions'=>$permissions,
            'roles'=>$roles,
            'users'=>$users,
        ]);
    }
    function permission_store(Request $request) {
        Permission::create(['name' => $request->permission_name]);
        return back()->with('success',"permission added!");
    }
    function role_store(Request $request) {
        $role = Role::create(['name' => $request->role_name]);
        $role->givePermissionTo($request->permission);
        return back()->with('role_added',"Role added!");
    }
    function assign_role(Request $request) {
        $user = User::find($request->user_id);
        $user->assignRole($request->role);
        return back()->with('role_assign',"Role Assign Success!");
    }
    function remove_user_role($id) {
        $user = User::find($id);
        $user->syncRoles([]);
        return back()->with('remove_role',"Role removed!");
    }
    function delete_role($id) {
        $role = Role::find($id);
        $role->syncPermissions([]);
        Role::find($id)->delete();
        DB::table('model_has_roles')->where('role_id',$id)->delete();
        return back();
    }
    function edit_role($id) {
        $permissions = Permission::all();
        $role = Role::find($id);
        return view('admin.role.edit',[
            'permissions'=>$permissions,
            'role'=>$role,
        ]);
    }
    function role_update($id , Request $request) {
        $role = Role::find($id);
        $role->syncPermissions($request->permission);
        Role::find($id)->update([
            'name'=>$request->role_name,
        ]);
        return redirect()->route('role.manager');
    }
}
