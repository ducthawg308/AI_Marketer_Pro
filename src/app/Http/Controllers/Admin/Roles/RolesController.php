<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function __construct() {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(config('const.per_page'));

        return view('admin.roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * config('const.per_page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permissions = Permission::get();

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'description' => 'required',
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);

        $role->syncPermissions($request->get('permission'));

        return redirect()->route('admin.roles.index')
            ->with('toast-success', __('admin.add_role_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): View
    {
        $rolePermissions = $role->permissions;

        return view('admin.roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $permissions = Permission::get();

        return view('admin.roles.edit', compact('role', 'rolePermissions', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Role $role, Request $request): RedirectResponse
    {
        $request->validate([
            'description' => 'required',
            'name' => 'required|unique:roles,name,' . $role->id,
            'permission' => 'required',
        ]);

        $role->update([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);
        $role->syncPermissions($request->get('permission'));

        return redirect()->route('admin.roles.index')
            ->with('toast-success', __('admin.update_role_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('toast-success', __('admin.delete_role_success'));
    }
}
