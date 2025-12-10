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
     * Get permissions list from selected features
     */
    private function getPermissionsFromFeatures(array $selectedFeatures): array
    {
        $features = config('permissions.features');
        $permissions = [];

        foreach ($selectedFeatures as $feature) {
            if (isset($features[$feature]['permissions'])) {
                $permissions = array_merge($permissions, $features[$feature]['permissions']);
            }
        }

        return array_unique($permissions);
    }

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
        $features = config('permissions.features');

        return view('admin.roles.create', compact('features'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'description' => 'required',
            'name' => 'required|unique:roles,name',
            'features' => 'required|array',
        ]);

        $role = Role::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);

        $permissions = $this->getPermissionsFromFeatures($request->get('features'));
        $role->syncPermissions($permissions);

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
        $features = config('permissions.features');
        $selectedFeatures = [];

        // Determine which features are selected based on current permissions
        foreach ($features as $featureKey => $featureData) {
            $featurePermissions = $featureData['permissions'];
            $hasAllPermissions = !array_diff($featurePermissions, $rolePermissions);

            if ($hasAllPermissions) {
                $selectedFeatures[] = $featureKey;
            }
        }

        return view('admin.roles.edit', compact('role', 'selectedFeatures', 'features'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Role $role, Request $request): RedirectResponse
    {
        $request->validate([
            'description' => 'required',
            'name' => 'required|unique:roles,name,' . $role->id,
            'features' => 'required|array',
        ]);

        $role->update([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);

        $permissions = $this->getPermissionsFromFeatures($request->get('features'));
        $role->syncPermissions($permissions);

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
