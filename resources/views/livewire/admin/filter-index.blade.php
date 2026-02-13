<div>
    <div class="card">
        <div class="card-header">
            <div class="row mb-1 g-2 align-items-end">
                @foreach ($filterable as $field => $meta)
                    <div class="col-md-2">
                        @php $type = $meta['type'] ?? 'text'; @endphp

                        @if ($type === 'text')
                            <label for="{{ $field }}" class="form-label text-muted small mb-0">{{$meta['label'] ?? $field}}</label>
                            <input wire:model.live="filters.{{ $field }}" type="text"
                                class="form-control mb-1"
                                placeholder="Buscar {{ strtolower($meta['label'] ?? $field) }}">
                        @elseif ($type === 'select')
                            <label for="{{ $field }}" class="form-label text-muted small mb-0">{{$meta['label'] ?? $field}}</label>
                            <select wire:model.live="filters.{{ $field }}" class="form-control mb-1">
                                <option value="">{{ $meta['label'] ?? '--' }}</option>
                                @foreach ($meta['options'] ?? [] as $val => $label)
                                    <option value="{{ $val }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        @elseif ($type === 'relation')
                            <label for="{{ $field }}" class="form-label text-muted small mb-0">{{$meta['label'] ?? $field}}</label>
                            <input wire:model.live="filters.{{ $field }}" type="text"
                                class="form-control mb-1"
                                placeholder="Buscar {{ strtolower($meta['label'] ?? $field) }}">
                        @endif
                    </div>
                @endforeach

                {{-- 🔥 FILTRO: RANGO DE FECHAS --}}
                <div class="col-md-2">
                    <label for="published_from" class="form-label text-muted small mb-0">Desde</label>
                    <input wire:model.live="filters.published_from" id="published_from"
                        type="text" class="form-control mb-1 campo-fecha" placeholder="Fecha desde">
                </div>

                <div class="col-md-2">
                    <label for="published_to" class="form-label text-muted small mb-0">Hasta</label>
                    <input wire:model.live="filters.published_to" id="published_to"
                        type="text" class="form-control mb-1 campo-fecha" placeholder="Fecha hasta">
                </div>

                <div class="col-md-1">
                    <button wire:click="$refresh" class="btn btn-secondary w-100 mt-3 mb-1" title="Limpiar filtros"><i class="bi bi-eraser-fill"></i></button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center w-100">
                @can($routePrefix . '.create')
                    <a href="{{ route($routePrefix . '.create') }}" class="btn btn-primary" title="Crear Noticia"><i class="bi bi-plus-circle-fill"></i></a>
                @endcan
                {{-- <div class="d-flex align-items-center gap-3"> --}}
                    {{ $items->links() }}
                {{-- </div> --}}
            </div>
            <div class="row g-4">
                @forelse ($items as $item)
                    <div class="col-md-4">
                        @php
                            $schema = collect($item->getCardSchema())->sortBy('order');
                        @endphp
                        <div class="card dim-card hover-effect border-0">
                            <div class="card-img-top-a d-flex justify-content-center p-1">
                                @foreach ($schema as $row)
                                    @php
                                        $value = data_get($item, $row['field']);
                                    @endphp
                                    @if ($row['type'] === 'image' && $value)
                                        <a href="{{route($routePrefix . '.show', $item)}}">
                                            <img class="card-img-top rounded" src="{{ asset('storage/'.$value) }}" alt="Card image cap">
                                        </a>
                                    @elseif ($row['type'] === 'image' && !$value)
                                        <a class="d-flex justify-content-center align-items-middle" href="{{route($routePrefix . '.show', $item)}}">
                                            <i class="bi bi-image-fill text-secondary rounded" style="font-size: 7rem;"></i>
                                        </a>
                                    @endif
                                @endforeach
                            </div>

                            <div class="card-body d-flex flex-column">
                                @foreach ($schema as $row)
                                    @php
                                        $value = data_get($item, $row['field']);
                                    @endphp
                                    <div class="mb-1">
                                    @if ($row['type'] === 'title')
                                        <h5 class="card-title fw-bold"><a href="{{route($routePrefix . '.show', $item)}}">{{ $value ? $value : ''}}</a></h5>
                                    @endif

                                    @if ($row['type'] === 'date')
                                        <span class="text-black-50">
                                            <i class="bi bi-calendar-date me-1"></i>
                                            {{ $value ? \Carbon\Carbon::parse($value)->format('d-m-Y') : '---' }}
                                        </span>
                                    @endif

                                    @if ($row['type'] === 'relation')
                                        <span class="text-black-50">
                                            <i class="bi bi-person me-1"></i>
                                            {{ $value ? $value : '---' }}
                                        </span>
                                    @endif

                                    @if ($row['type'] === 'location')
                                        <span class="text-black-50">
                                            <i class="bi bi-geo-alt me-1"></i>
                                            {{ $value ? $value : '---' }}
                                        </span>
                                    @endif

                                    @if ($row['type'] === 'html')
                                        <p class="card-text text-black-50 mb-1">{!! Str::limit($value ?? '', 200) !!}</p>
                                    @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="card-footer py-3 bg-white text-muted">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <span class="badge bg-{{ $item->status->color() }}">
                                        {{ $item->status->label() }}
                                    </span>
                                    <div class="d-flex align-items-center gap-2">
                                        @can($routePrefix . '.edit')
                                            <a href="{{ route($routePrefix . '.edit', $item) }}"
                                            class="btn btn-sm btn-primary"
                                            title="Editar">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        @endcan

                                        @can($routePrefix . '.destroy')
                                            <form action="{{ route($routePrefix . '.destroy', $item) }}"
                                                method="POST" class="m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('¿Eliminar esta noticia?')"
                                                        title="Eliminar">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center mt-3">No se encontraron resultados.</p>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
