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

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function index(Request $request): View
    {
        $search = $request->only(['keyword']);
        $items = $this->userService->search($search);

        return view('admin.users.index', compact(['items', 'search']));
    }

    public function create(): View
    {
        $item = new User();

        return view('admin.users.create', compact('item'));
    }

    public function store(UserStoreRequest $request): RedirectResponse
    {
        $attributes = $request->except(['_token']);

        $result = $this->userService->create($attributes);

        return $result
            ? redirect()->route('admin.users.index')->with('toast-success', __('admin.add_user_success'))
            : back()->with('toast-error', __('admin.add_user_fail'));
    }

    public function edit($id): View
    {
        $item = $this->userService->find($id);

        return view('admin.users.edit', compact('item'));
    }

    public function update(UserUpdateRequest $request, $id): RedirectResponse
    {
        $item = $this->userService->find($id);
        if (! $item) {
            return back()->with('toast-error', __('admin.not_found'));
        }

        $item = $this->userService->update($id, $request->all());
        if ($item) {
            return redirect()->route('admin.users.index')->with('toast-success', __('admin.update_user_success'));
        }

        return back()->with('toast-error', __('admin.update_user_fail'));
    }

    public function destroy($id): RedirectResponse
    {
        $isDestroy = $this->userService->delete($id);

        return $isDestroy
            ? redirect()->route('admin.users.index')->with('toast-success', __('admin.delete_user_success'))
            : back()->with('toast-error', __('admin.delete_user_fail'));
    }
}

