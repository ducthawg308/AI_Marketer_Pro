<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\AiPrompt;
use Illuminate\Http\Request;

class PromptController extends Controller
{
    public function index()
    {
        $prompts = AiPrompt::query()
            ->orderBy('group')
            ->orderBy('name')
            ->get();

        return view('admin.prompts.index', compact('prompts'));
    }

    public function edit(AiPrompt $prompt)
    {
        return view('admin.prompts.edit', compact('prompt'));
    }

    public function update(Request $request, AiPrompt $prompt)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'content' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $prompt->update($validated);

        return redirect()->route('admin.prompts.index')
            ->with('success', 'Prompt updated successfully.');
    }
}
