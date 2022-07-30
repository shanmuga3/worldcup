<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\RolesDataTable;
use App\Models\Role;
use App\Models\Permission;
use Lang;

class RoleController extends Controller
{
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->view_data['main_title'] = Lang::get('admin_messages.admin_users.manage_roles_privilege');
        $this->view_data['active_menu'] = 'roles';
        $this->view_data['sub_title'] = Lang::get('admin_messages.admin_users.admin_roles');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render('admin.roles.view',$this->view_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->view_data['sub_title'] = Lang::get('admin_messages.admin_users.add_role');
        $this->view_data['result'] = new Role;
        $this->view_data['permissions'] = Permission::get();
        $this->view_data['old_permissions'] = array();
        return view('admin.roles.add', $this->view_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);
        
        $role = Role::create([
            'name' => $request->name,
            'display_name' => ucwords(str_replace('_', ' ', $request->name)),
            'description' => $request->description
        ]);

        $permission = $request->permission;
        $permissions = Permission::whereIn('id',$permission)->get();

        $role->permissions()->sync($permissions);
        
        flashMessage('success',Lang::get('admin_messages.common.success'),Lang::get('admin_messages.common.successfully_added'));
        return redirect()->route('admin.roles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->view_data['sub_title'] = Lang::get('admin_messages.admin_users.edit_role');
        $this->view_data['result'] = Role::findOrFail($id);
        $this->view_data['permissions'] = Permission::get();
        $this->view_data['old_permissions'] = \DB::table('permission_role')->where('role_id',$id)->pluck('permission_id')->toArray();
        return view('admin.roles.edit', $this->view_data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateRequest($request,$id);
        
        $role = Role::find($id);
        $role->name = $request->name;
        $role->display_name = ucwords(str_replace('_', ' ', $request->name));
        $role->description = $request->description;
        $role->save();

        $permission = $request->permission;
        $permissions = Permission::whereIn('id',$permission)->get();

        $role->permissions()->sync($permissions);

        flashMessage('success',Lang::get('admin_messages.common.success'),Lang::get('admin_messages.common.successfully_updated'));

        return redirect()->route('admin.roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $can_destroy = $this->canDestroy($id);
        
        if(!$can_destroy['status']) {
            flashMessage('danger',Lang::get('admin_messages.common.failed'),$can_destroy['status_message']);
            return redirect()->route('admin.roles');
        }
        
        try {
            $role = Role::find($id);
            $role->users()->sync([]);
            $role->permissions()->sync([]);
            $role->forceDelete();
            
            flashMessage('success',Lang::get('admin_messages.common.success'),Lang::get('admin_messages.common.successfully_deleted'));
        }
        catch (\Exception $e) {
            flashMessage('danger',Lang::get('admin_messages.common.failed'),$e->getMessage());
        }

        return redirect()->route('admin.roles');
    }

    /**
     * Check the specified resource Can be deleted or not.
     *
     * @param  Illuminate\Http\Request $request_data
     * @param  Int $id
     * @return Array
     */
    protected function validateRequest($request_data, $id = '')
    {
        $rules = array(
            'name' => 'required',
            'description' => 'required',
            'permission' => 'required'
        );
        $attributes = array(
            'name' => Lang::get('admin_messages.fields.name'),
            'description' => Lang::get('admin_messages.fields.description'),
            'permission' => Lang::get('admin_messages.fields.permission'),
        );

        $this->validate($request_data,$rules,[],$attributes);
    }

    /**
     * Check the specified resource Can be deleted or not.
     *
     * @param  int  $id
     * @return Array
     */
    protected function canDestroy($id)
    {
        $admin_count = \DB::table('role_user')->where('role_id',$id)->count();
        if($admin_count == 0) {
            return ['status' => true,'status_message' => ''];
        }
        return ['status' => false, 'status_message' => Lang::get('admin_messages.errors.some_user_used_role')];

    }
}
