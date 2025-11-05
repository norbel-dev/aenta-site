<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\HasImageUpload;
use Illuminate\Database\Eloquent\Model;

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

    public function create()
    {
        $item = new $this->model();
        return view("admin.{$this->folder}.form", compact('item'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());
        $request['published_at'] = date('Y-m-d', strtotime($request['published_at']));

        $paths = ['image' => null, 'thumbnail' => null];
        if ($request->hasFile('image')) {
            $paths = $this->uploadImage($request->file('image'), $this->folder);
        }

        $data = $this->fillableData($request);
        $data['image'] = $paths['image'];
        $data['thumbnail'] = $paths['thumbnail'];
        $data['slug'] = Str::slug($request['title']);

        $this->model::create($data);

        return redirect()->back()->with('info', 'Registro creado correctamente.');
    }

    public function show($item)
    {
        $item = $this->resolveModel($item);
        return view("admin.{$this->folder}.show", compact('item'));
    }

    public function edit($item)
    {
        $item = $this->resolveModel($item);
        return view("admin.{$this->folder}.form", compact('item'));
    }

    public function update(Request $request, $item)
    {
        $item = $this->resolveModel($item);
        //dd($request['published_at']);
        $request['published_at'] = date('Y-m-d', strtotime($request->published_at));
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

        return redirect()->back()->with('info', 'Registro actualizado correctamente.');
    }

    public function destroy($item)
    {
        $item = $this->resolveModel($item);
        $this->deleteImage($item->image, $item->thumbnail);
        $item->delete();

        return redirect()->back()->with('info', 'Registro eliminado correctamente.');
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

    /**
     * Protección de las rutas.
     */
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

    /**
     * Instancia el modelo correcto.
     */
    protected function resolveModel($identifier)
    {
        if ($identifier instanceof $this->model){
            return $identifier;
        }
        $instance = new $this->model;
        return $instance->where('slug', $identifier)
                        ->orWhere('id', $identifier)
                        ->firstOrFail();
    }
}
