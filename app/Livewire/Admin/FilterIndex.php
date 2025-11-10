<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class FilterIndex extends Component
{
    use WithPagination;

    public string $model;
    public string $routePrefix = '';
    public array $filters = [];
    public array $filterable = [];

    protected $paginationTheme = 'bootstrap';

    public function mount(string $model, string $routePrefix = '')
    {
        $this->model = $model;
        $this->routePrefix = $routePrefix;
        $this->filterable = $model::$filterable ?? [];

        // Si el filterable define selects con 'enum', auto-carga opciones
        foreach ($this->filterable as $field => &$meta) {
            if (($meta['type'] ?? '') === 'select' && empty($meta['options']) && !empty($meta['enum'])) {
                $enumClass = $meta['enum'];
                if (method_exists($enumClass, 'options')) {
                    $meta['options'] = $enumClass::options();
                } elseif (method_exists($enumClass, 'cases')) {
                    // Fallback genérico
                    $opts = [];
                    foreach ($enumClass::cases() as $case) {
                        $label = $case->name;
                        if (method_exists($case, 'label')) {
                            $label = $case->label();
                        }
                        $opts[$case->value] = $label;
                    }
                    $meta['options'] = $opts;
                }
            }
        }
        unset($meta);

        // Inicializar filtros planos (sin puntos)
        foreach ($this->filterable as $field => $meta) {
            $this->filters[$field] = '';
        }
    }

    public function updating($field)
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = User::find(Auth::id());
        $model = $this->model;
        $query = $model::query();
        if (!($user->isAdmin() || $user->isSuperAdmin())){
            $query = $query->where('user_id', Auth::id());
        }

        // 🔍 Aplica todos los filtros dinámicamente
        foreach ($this->filters as $field => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            $meta = $this->filterable[$field] ?? [];
            $type = $meta['type'] ?? 'text';

            if ($type === 'relation') {
                if ($field === 'autor') {
                    $query->whereHas('user', function (Builder $q) use ($value) {
                        $q->where('name', 'like', '%' . $value . '%');
                    });
                } else {
                    // Si quieres soportar otras relaciones configurables:
                    // espera meta['relation'] y meta['target']
                    if (!empty($meta['relation']) && !empty($meta['target'])) {
                        $relation = $meta['relation'];
                        $target = $meta['target'];
                        $query->whereHas($relation, function (Builder $q) use ($target, $value) {
                            $q->where($target, 'like', '%' . $value . '%');
                        });
                    }
                }
            } else {
                // Tipos comunes
                switch ($type) {
                    case 'text':
                        $query->where($field, 'like', '%' . $value . '%');
                        break;
                    case 'select':
                        $query->where($field, $value);
                        break;
                    case 'date':
                        $query->whereDate($field, $value);
                        break;
                    default:
                        // noop
                        break;
                }
            }
        }

        // Siempre eager-load del autor por rendimiento si existe relación user
        if (method_exists($model, 'user')) {
            $query->with('user');
        }

        $items = $query->latest()->paginate(9);

        return view('livewire.admin.filter-index', [
            'items' => $items,
        ]);
    }
}
