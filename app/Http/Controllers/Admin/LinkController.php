<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::where('status', Status::EDIT_PUBLISHED)->latest()->get();
        return view('admin.links.index', compact('links'));
    }

    public function create()
    {
        return view('admin.links.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'image' => 'required',
            'status' => 'required', new Enum(Status::class),
        ]);

        Link::create($request->all());
        return redirect()->route('admin.links.index')->with('success', 'Link created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        return view('admin.links.show', compact('link'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link)
    {
        return view('admin.links.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Link $link)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'image' => 'required',
            'status' => 'required', new Enum(Status::class),
        ]);
        $link->update($request->all());
        return redirect()->route('admin.links.index')->with('success', 'Link updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        $link->delete();
        return redirect()->route('admin.links.index')->with('success', 'Link deleted successfully.');
    }
}
