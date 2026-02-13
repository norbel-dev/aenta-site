<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Center;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    public function index()
    {
        $centers = Center::all();
        return view('admin.centers.index', compact('centers'));
    }

    public function show(Center $center)
    {
        return view('admin.centers.show', compact('center'));
    }

    public function create()
    {
        return view('admin.centers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
        ]);

        Center::create($request->all());
        return redirect()->route('admin.centers.index')->with('success', 'Center created successfully.');
    }

    public function edit(Center $center)
    {
        return view('admin.centers.edit', compact('center'));
    }

    public function update(Request $request, Center $center)
    {
        $center->update($request->all());
        return redirect()->route('admin.centers.index')->with('success', 'Center updated successfully.');
    }

    public function destroy(Center $center)
    {
        $center->delete();
        return redirect()->route('admin.centers.index')->with('success', 'Center deleted successfully.');
    }
}
