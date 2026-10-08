<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'items' => Item::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // 10MB limit
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('attachments', 'public');
            $validated['file_path'] = $path;
        }

        // Remove the temporary file instance before database insertion
        unset($validated['file']);

        Item::create($validated);

        return redirect()->back()->with('message', 'Item created successfully.');
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('file')) {
            // Delete existing file from storage if it exists
            if ($item->file_path && Storage::disk('public')->exists($item->file_path)) {
                Storage::disk('public')->delete($item->file_path);
            }

            $path = $request->file('file')->store('attachments', 'public');
            $validated['file_path'] = $path;
        }

        // Remove the temporary file instance before updating database
        unset($validated['file']);

        $item->update($validated);

        return redirect()->back()->with('message', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        // Delete attached file from storage before removing record
        if ($item->file_path && Storage::disk('public')->exists($item->file_path)) {
            Storage::disk('public')->delete($item->file_path);
        }

        $item->delete();

        return redirect()->back()->with('message', 'Item deleted successfully.');
    }
}