<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\HasImageUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;

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

    public function index()
    {
        return view("admin.{$this->folder}.index");
    }

    public function create()
    {
        $item = new $this->model();
        return view("admin.{$this->folder}.form", compact('item'));
    }

    public function store(Request $request)
    {
        $this->normalizeDateFields($request);
        $request->validate($this->validationRules());

        $paths = ['image' => null, 'thumbnail' => null];
        if ($request->hasFile('image')) {
            $paths = $this->uploadImage($request->file('image'), $this->folder);
        }

        $this->sanitizeRichText($request);
        $data = $this->fillableData($request);
        $data['image'] = $paths['image'];
        $data['thumbnail'] = $paths['thumbnail'];
        $data['slug'] = Str::slug($request['title']);
        $data['user_id'] = Auth::id();

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
        $this->normalizeDateFields($request);
        $request->validate($this->validationRules());
        $paths = [
            'image' => $item->image,
            'thumbnail' => $item->thumbnail,
        ];

        if ($request->hasFile('image')) {
            $this->deleteImage($item->image, $item->thumbnail);
            $paths = $this->uploadImage($request->file('image'), $this->folder);
        }

        $this->sanitizeRichText($request);
        $data = $this->fillableData($request);
        $data['image'] = $paths['image'];
        $data['thumbnail'] = $paths['thumbnail'];
        $data['slug'] = Str::slug($request['title']);
        $data['user_id'] = Auth::id();

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

    protected function normalizeDateFields(Request $request): void
    {
        foreach ($this->model::$dateRangeFields ?? [] as $field) {
            $value = $request->input($field);

            if (! is_string($value) || trim($value) === '') {
                continue;
            }

            $timestamp = strtotime($value);
            if ($timestamp !== false) {
                $request->merge([$field => date('Y-m-d', $timestamp)]);
            }
        }
    }

    protected function sanitizeRichText(Request $request): void
    {
        foreach (['content', 'description'] as $field) {
            if ($request->filled($field)) {
                $request->merge([$field => Purifier::clean($request->input($field))]);
            }
        }
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
                        ->firstOrFail();
    }
}
