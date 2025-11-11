@extends('adminlte::page')

@section('title', 'News')

@section('content_header')
    <h1>News</h1>
@endsection

@section('css')
<link href="{{ URL::asset('plugins/jquery-ui-1.14.1.custom/jquery-ui.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('css/datepicker.css') }}" rel="stylesheet" />
<style>
    .card-img-top-a{
        max-height:48.44% !important;
        height:48.44% !important;
    }
    .card-img-top{
        height: 100%;
    }
    .card.dim-card{
        max-height: 578px;
        height: 578px;
    }
    .card-text.text-black-50{
        max-height: 82px;
    }
</style>
@endsection

@section('content')
    @livewire('admin.filter-index', [
        'model' => App\Models\News::class,
        'routePrefix' => 'admin.news'
    ])
@endsection

@section('js')
    <script src="{{ URL::asset('plugins/jquery-ui-1.14.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('js/datepicker.js') }}"></script>
    <script src="{{ URL::asset('js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            let minDate = new Date();
            minDate.setFullYear(minDate.getFullYear() - 1);
            initializeDatePicker(minDate);
            $('.campo-fecha').on('change', function () {
                    // id del input: por ejemplo "published_from" o "published_to"
        const fieldId = this.id;
        const value = this.value;

        // Asegúrate que el input existe y tiene wire:model
        const el = document.getElementById(fieldId);
        if (!el) {
            console.warn('Input para Livewire no encontrado con id:', fieldId);
            return;
        }

        // Actualiza el valor del input y dispara evento 'input' (bubbles) para Livewire
        el.value = value;
        el.dispatchEvent(new Event('input', { bubbles: true }));
                });
        });
    </script>
@endsection
