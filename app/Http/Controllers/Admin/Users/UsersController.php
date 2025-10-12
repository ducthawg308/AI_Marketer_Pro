<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UserStoreRequest;
use App\Http\Requests\Admin\Users\UserUpdateRequest;
use App\Models\User;
use App\Services\Admin\Users\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function __construct(private UserService $userService) {}

    /**
     * Display all users
     */
    public function index(Request $request): View
    {
        $search = $request->only(['keyword']);
        $users = $this->userService->search($search);

        return view('admin.users.index', compact(['users', 'search']));
    }

    /**
     * Show form for creating user
     */
    public function create(): View
    {
        return view('admin.users.create', [
            'roles' => Role::all(),
        ]);
    }

    /**
     * Store a newly created user
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        // For demo purposes only. When creating user or inviting a user
        // you should create a generated random password and email it to the user
        $userNew = $this->userService->create($request->all());

        return redirect()->route('admin.users.index')->with('toast-success', __('admin.add_user_success'));
    }

    /**
     * Show user data
     */
    public function show(User $user): View
    {
        return view('admin.users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Edit user data
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('id')->toArray(),
            'roles' => Role::latest()->get(),
        ]);
    }

    /**
     * Update user data
     */
    public function update(User $user, UserUpdateRequest $request): RedirectResponse
    {
        // dd($request->all());
        $userUpdate = $this->userService->update($user->id, $request->validated());

        return redirect()->route('admin.users.index')
            ->with('toast-success', __('admin.update_user_success'));
    }

    /**
     * Delete user data
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('toast-success', __('admin.delete_user_success'));
    }
}
