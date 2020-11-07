<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::orderBy('name', 'ASC')->get();
        return view('users.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|min:4',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::firstOrCreate(
            [
                'email' => $request->email
            ],
            [
                'name' => $request->name,
                'password' => bcrypt($request->password),
                'status' => true
            ]
        );
        $user->assignRole($request->role);
        return redirect()->route('users.index')->with(['success', 'User: <strong>' . $user->name . '</strong> Ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
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
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email|exists:users:users,email',
            'password' => 'nullable|min:6',
        ]);

        $user = User::findOrFail($id);
        $password = !empty($request->password) ? bcrypt($request->password):$user->password;
        $user->update([
            'name' => $request->name,
            'password' => $password
        ]);
        return redirect(route('users.index'))->with(['success' => 'User: <strong>' . $user->name . '</strong> Diperbaharui']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect(route('users.index'))->with(['success' => 'User: <strong>' . $user->name . '</strong> Dihapus']);
    }

    /**
     * rolePermission
     *
     * @param Request $request
     * @return void
     */
    public function rolePermission(Request $request)
    {
        $role = $request->get('role');

        // default dua buah variable
        $permissions = null;
        $hasPermission = null;

        // ambil data role
        $roles = Role::all()->pluck('name');

        // apabila parameter role terpenuhi
        if (!empty($role)) {
            // find role
            $getRole = Role::findByName($role);

            // Query untuk mengambil permission yang telah di miliki oleh role terkait
            $hasPermission = DB::table('role_has_permissions')
                ->select('permissions.name')
                ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_id', $getRole->id)->get()->pluck('name')->all();
            
            // mengambil data permission
            $permissions = Permission::all()->pluck('name');
        }
        return view('users.role_permission', compact('roles', 'permissions', 'hasPermission'));
    }

    /**
     * add Permission
     *
     * @param Request $request
     * @return void
     */
    public function addPermission(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:permissions'
        ]);

        $permission = Permission::firstOrCreate([
            'name' => $request->name
        ]);

        return redirect()->back();
    }

    /**
     * set role permission
     */
    public function setRolePermission(Request $request, $role)
    {
        // select role berdasarkan namanya
        $role = Role::findByName($role);

        // function syncPermission akan menghapus semua permission yg dimiliki role tersebut
        // kemudian assign kembali sehingga tidak terjadi duplicate
        $role->syncPermissions($request->permission);
        return redirect()->back()->with(['success' => 'Permission to Role Saved!']);
    }

    /**
     * Roles
     */

     public function roles(Request $request, $id)
     {
         $user = User::findOrFail($id);
         $roles = Role::all()->pluck('name');
         return view('users.roles', compact('user', 'roles'));
     }

     /**
      * set Roles 
      */
    public function setRoles()
    {
        $this->validation($request, [
            'role' => 'required'
        ]);

        $user = User::findOrFail($id);
        //menggunakan syncRoles agar terlebih dahulu menghapus semua role yang dimiliki
        //kemudian di-set kembali agar tidak terjadi duplicate
        $user->syncRoles($request->role);
        return redirect()->back()->with(['success' => 'Role Sudah Di Set']);
    }
}
