<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    ////////////  All Permissions /////////////////
    public function AllPermission(){
        $permissions = Permission::all();
        return view('backend.pages.permission.all_permission', compact('permissions'));
    }

    public function AddPermission(){
        return view('backend.pages.permission.add_permission');
    }

    public function StorePermission(Request $request){
        $role = Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission Inserted Sucessfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);

    }

    public function EditPermission($id){
        $permission = Permission::findOrFail($id);
        return view('backend.pages.permission.edit_permission', compact('permission'));
    }

    public function UpdatePermission(Request $request){
        $permission_id = $request->id;

        Permission::findOrFail($permission_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission Updated Sucessfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);
    }

    public function DeletePermission($id){
        Permission::findOrFail($id)->delete();
        
        $notification = array(
            'message' => 'Permission Deleted Sucessfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }




    ///////// All Roles /////////////////////

    public function AllRoles(){
        $roles = Role::all();
        return view('backend.pages.roles.all_roles', compact('roles'));
    }

    public function AddRoles(){
        return view('backend.pages.roles.add_roles');
    }

    public function StoreRoles(Request $request){
        $role = Role::create([
            'name' => $request->name,
        
        ]);

        $notification = array(
            'message' => 'Roles Inserted Sucessfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);

    }

    public function EditRoles($id){
        $roles = Role::findOrFail($id);
        return view('backend.pages.roles.edit_roles', compact('roles'));
    }

    public function UpdateRoles(Request $request){
        $role_id = $request->id;
        Role::findOrFail($role_id)->update([
            'name' => $request->name,
            
        ]);

        $notification = array(
            'message' => 'Roles Updated Sucessfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);
    }

    public function DeleteRoles($id){

        Role::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Roles Deleted Sucessfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    /////// Add role permisson //////

    public function AddRolesPermission(){
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = User::getPermissionGroups();

       
        return view('backend.pages.roles.add_roles_permission', compact('roles', 'permissions', 'permission_groups'));
    }

    public function RolePermissionStore(Request $request){
        $data = array();
        $permissions = $request->permission;

        foreach ($permissions as $item) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;

            DB::table('role_has_permissions')->insert($data);
        }

        $notification = array(
            'message' => 'Role Permission Added Sucessfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);

    }

}
