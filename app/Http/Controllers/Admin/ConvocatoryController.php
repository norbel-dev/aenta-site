<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Convocatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class ConvocatoryController extends Controller
{
    public function index()
    {
        $convocatories = Convocatory::where('status', Status::EDIT_PUBLISHED)->latest()->get();
        return view('admin.convocatories.index', compact('convocatories'));
    }

    public function create()
    {
        return view('admin.convocatories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required|date',
            'date_end' => 'nullable|date|after_or_equal:date',
            'status' => 'required', new Enum(Status::class),
            'description' => 'nullable|string',
            'archivo'     => 'nullable|file|mimes:pdf,mp3,wav,mp4,mov,avi|max:10240',
        ]);


        $data = $this->fillableData($request);
        $data['image'] = $paths['image'];
        $data['thumbnail'] = $paths['thumbnail'];
        $data['slug'] = Str::slug($request['title']);
        $data['user_id'] = Auth::id();

        Convocatory::create($request->all());
        return redirect()->route('admin.convocatories.index')->with('success', 'Convocatory created successfully.');
    }

    public function show(Convocatory $convocatory)
    {
        return view('admin.convocatories.show', compact('convocatory'));
    }

    public function edit(Convocatory $convocatory)
    {
        return view('admin.convocatories.edit', compact('convocatory'));
    }

    public function update(Request $request, Convocatory $convocatory)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required|date',
            'date_end' => 'nullable|date|after_or_equal:date',
            'status' => 'required', new Enum(Status::class),
            'description' => 'nullable|string',
            'archivo'     => 'nullable|file|mimes:pdf,mp3,wav,mp4,mov,avi|max:10240',
        ]);
        $convocatory->update($request->all());
        return redirect()->route('admin.convocatories.index')->with('success', 'Convocatory updated successfully.');
    }

    public function destroy(Convocatory $convocatory)
    {
        $convocatory->delete();
        return redirect()->route('admin.convocatories.index')->with('success', 'Convocatory deleted successfully.');
    }

    protected function fillableData(Request $request): array
    {
        return $request->only((new Convocatory())->getFillable());
    }
}
