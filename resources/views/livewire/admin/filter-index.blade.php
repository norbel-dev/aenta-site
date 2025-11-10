<div>
    <div class="card">
        <div class="card-header">
            {{-- 🔍 Filtros dinámicos --}}
            <div class="row mb-4 g-2">
                @foreach ($filterable as $field => $meta)
                    <div class="col-md-3">
                        @if ($meta['type'] === 'text')
                            <input wire:model.live="filters.{{ $field }}" type="text"
                                class="form-control" placeholder="Buscar {{ strtolower($meta['label']) }}">
                        @elseif ($meta['type'] === 'select')
                            <select wire:model.live="filters.{{ $field }}" class="form-select">
                                <option value="">-- {{ $meta['label'] }} --</option>
                                @foreach ($meta['options'] as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        @elseif ($meta['type'] === 'date')
                            <input wire:model.live="filters.{{ $field }}" type="date"
                                class="form-control" placeholder="{{ $meta['label'] }}">
                        @endif
                    </div>
                @endforeach

                <div class="col-md-2">
                    <button wire:click="$refresh" class="btn btn-secondary w-100">Limpiar</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @can($routePrefix . '.create')
                <a href="{{ route($routePrefix . '.create') }}" class="btn btn-primary mb-3">Add New</a>
            @endcan
            <div class="row g-4 mt-4">
                @forelse ($items as $item)
                    <div class="col-md-4">
                        <div class="card dim-card hover-effect border-0">
                            @if($item->thumbnail)
                                <a class="card-img-top-a" href="{{route($routePrefix . '.show', $item)}}">
                                    <img class="card-img-top" src="{{ asset('storage/'.$item->thumbnail) }}" alt="Card image cap">
                                </a>
                            @endif
                            <div class="card-body">
                                <h4 class="card-title fw-bold mb-2"><a href="{{route($routePrefix . '.show', $item)}}">{{ $item->title ?? '(Sin título)' }}</a></h4>
                                <p class="mb-2 card-title-sub text-uppercase fw-normal ls1">
                                    <a href="{{route($routePrefix . '.show', $item)}}" class="text-black-50">
                                        {{ isset($item->published_at) ? \Carbon\Carbon::parse($item->published_at)->format('d/m/Y') : '---' }}
                                    </a>
                                </p>
                                <div class="rating-stars mb-2"><i class="icon-star3"></i><i class="icon-star3"></i><i class="icon-star3"></i><i class="icon-star3"></i><i class="icon-star-half-full"></i> <span>{{$item->user->name}}</span></div>
                                <p class="card-text text-black-50 mb-1">{{ Str::limit($item->content ?? '', 200) }}</p>
                            </div>
                            <div class="card-footer py-3 d-flex justify-content-between align-items-center bg-white text-muted">
                                <span class="badge bg-{{ $item->status->color() }}">{{ $item->status->label() }}</span>
                                @can($routePrefix . '.edit')
                                    <a href="{{ route($routePrefix . '.edit', $item) }}" class="btn btn-sm btn-primary">Editar</a>
                                @endcan
                                @can($routePrefix . '.destroy')
                                    <form action="{{ route($routePrefix . '.destroy', $item) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta noticia?')">Eliminar</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center mt-3">No se encontraron resultados.</p>
                @endforelse
            </div>
            {{-- 📄 Paginación --}}
            <div class="mt-4">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
