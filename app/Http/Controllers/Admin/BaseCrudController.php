<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\HasImageUpload;

abstract class BaseCrudController extends BaseController
{
    use HasImageUpload;

    protected string $model;

    protected string $folder;

    protected string $permissionPrefix;

    public function __construct()
    {
        $this->applyPermissionMiddleware();
    }

    protected function applyPermissionMiddleware(): void
    {
        if (!isset($this->permissionPrefix)) {
            return;
        }

        $prefix = $this->permissionPrefix;

        $this->middleware("can:{$prefix}")->only('index');
        $this->middleware("can:{$prefix}.create")->only(['create', 'store']);
        $this->middleware("can:{$prefix}.edit")->only(['edit', 'update']);
        $this->middleware("can:{$prefix}.destroy")->only('destroy');
    }

    public function create()
    {
        $item = new $this->model();
        return view("admin.{$this->folder}.form", compact('item'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());

        $paths = ['image' => null, 'thumbnail' => null];
        if ($request->hasFile('image')) {
            $paths = $this->uploadImage($request->file('image'), $this->folder);
        }

        $data = $this->fillableData($request);
        $data['image'] = $paths['image'];
        $data['thumbnail'] = $paths['thumbnail'];
        $data['slug'] = Str::slug($request['title']);

        $this->model::create($data);

        return redirect()->back()->with('success', 'Registro creado correctamente.');
    }

    public function edit($id)
    {
        $item = $this->model::findOrFail($id);
        return view("admin.{$this->folder}.form", compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = $this->model::findOrFail($id);
        $validated = $request->validate($this->validationRules());

        $paths = [
            'image' => $item->image,
            'thumbnail' => $item->thumbnail,
        ];

        if ($request->hasFile('image')) {
            $this->deleteImage($item->image, $item->thumbnail);
            $paths = $this->uploadImage($request->file('image'), $this->folder);
        }

        $data = $this->fillableData($request);
        $data['image'] = $paths['image'];
        $data['thumbnail'] = $paths['thumbnail'];
        $data['slug'] = Str::slug($request['title']);

        $item->update($data);

        return redirect()->back()->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy($id)
    {
        $item = $this->model::findOrFail($id);
        $this->deleteImage($item->image, $item->thumbnail);
        $item->delete();

        return redirect()->back()->with('success', 'Registro eliminado correctamente.');
    }

    // ---------- Helpers ----------

    /**
     * Reglas de validación obtenidas del modelo.
     */
    protected function validationRules(): array
    {
        return $this->model::rules() ?? [];
    }

    /**
     * Filtra solo los atributos fillable definidos en el modelo.
     */
    protected function fillableData(Request $request): array
    {
        return $request->only((new $this->model())->getFillable());
    }
}
