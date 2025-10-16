<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Header;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class HeaderController extends Controller
{
    public function index()
    {
        $headers = Header::where('status', Status::EDIT_PUBLISHED)->latest()->get();
        return view('admin.headers.index', compact('headers'));
    }

    public function create()
    {
        return view('admin.headers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required',
            'status' => 'required', new Enum(Status::class),
            'date' => 'required|date',
        ]);

        Header::create($request->all());
        return redirect()->route('admin.headers.index')->with('success', 'Header created successfully.');
    }

    public function show(Header $header)
    {
        return view('admin.headers.show', compact('header'));
    }

    public function edit(Header $header)
    {
        return view('admin.headers.edit', compact('header'));
    }

    public function update(Request $request, Header $header)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required',
            'status' => 'required', new Enum(Status::class),
            'date' => 'required|date',
        ]);
        $header->update($request->all());
        return redirect()->route('admin.headers.index')->with('success', 'Header updated successfully.');
    }

    public function destroy(Header $header)
    {
        $header->delete();
        return redirect()->route('admin.headers.index')->with('success', 'Header deleted successfully.');
    }
}
