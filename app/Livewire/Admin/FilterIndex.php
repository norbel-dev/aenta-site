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
    public array $dateRangeFields = [];

    protected $paginationTheme = 'bootstrap';

    public function mount(string $model, string $routePrefix = '')
    {
        $user = User::find(Auth::id());
        $this->model = $model;
        $this->routePrefix = $routePrefix;
        $base = $model::$filterable ?? [];
        if ($user->isAdmin() || $user->isSuperAdmin()){
            $admin = $model::$filterableAdmin ?? [];
            $this->filterable = array_merge($base, $admin);
        } else {
            $this->filterable = $base;
        }
        $this->dateRangeFields = $model::$dateRangeFields ?? ['created_at'];

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
        $this->filters['published_from'] = '';
        $this->filters['published_to'] = '';
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

            // 🔥 Filtro adicional: rango de fechas (from / to)
            if ($this->filters['published_from'] || $this->filters['published_to']) {
                $from = $this->filters['published_from'];
                $to   = $this->filters['published_to'];

                $query->where(function($q) use ($from, $to) {
                    foreach ($this->dateRangeFields as $field) {

                        // Si vienen ambos
                        if ($from && $to) {
                            $q->orWhereBetween($field, [date('Y-m-d', strtotime($from)), date('Y-m-d', strtotime($to))]);
                        }
                        // Solo desde
                        elseif ($from) {
                            $q->orWhere($field, '>=', date('Y-m-d', strtotime($from)));
                        }
                        // Solo hasta
                        elseif ($to) {
                            $q->orWhere($field, '<=', date('Y-m-d', strtotime($to)));
                        }
                    }
                });
                // if ($this->filters['published_from']) {
                //     $query->whereDate('published_at', '>=', date('Y-m-d', strtotime($this->filters['published_from'])));
                // }

                // if ($this->filters['published_to']) {
                //     $query->whereDate('published_at', '<=', date('Y-m-d', strtotime($this->filters['published_to'])));
                // }
            }else if ($type === 'relation') {
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
                switch ($type) {
                    case 'text':
                        $query->where($field, 'like', "%{$value}%");
                        break;
                    case 'select':
                        $query->where($field, $value);
                        break;
                }
            }


        }

        // Siempre eager-load del autor por rendimiento si existe relación user
        if (method_exists($model, 'user')) {
            $query->with('user');
        }

        $items = $query->latest()->paginate(6);

        return view('livewire.admin.filter-index', [
            'items' => $items,
        ]);
    }

    protected $listeners = [
        'dateChanged' => 'onDateChanged', // escucha el evento JS
    ];

    public function onDateChanged(string $field, ?string $value)
    {
        // asigna el valor al filtro correspondiente
        $this->filters[$field] = $value;
        $this->resetPage(); // opcional: resetea la paginación
    }
}
