<?php

namespace App\Livewire\Admin;

use App\Models\User;
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

        // 🔧 Cargar filtros desde el modelo
        $this->filterable = $model::$filterable ?? [];

        // Inicializa filtros vacíos
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
            if ($value === null || $value === '') continue;

            $type = $this->filterable[$field]['type'] ?? 'text';

            match ($type) {
                'text' => $query->where($field, 'like', "%{$value}%"),
                'select' => $query->where($field, $value),
                'date' => $query->whereDate($field, $value),
                default => null,
            };
        }

        $items = $query->latest()->paginate(9);

        return view('livewire.admin.filter-index', [
            'items' => $items,
        ]);
    }
}
