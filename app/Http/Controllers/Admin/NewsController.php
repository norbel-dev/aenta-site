<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NewsController extends BaseCrudController
{
    protected string $model = News::class;
    protected string $folder = 'news';
    protected string $permissionPrefix = 'admin.news';

    // public function index()
    // {
    //    $filterable = [
    //     'title' => [
    //         'label' => 'Título',
    //         'type' => 'text',
    //     ],
    //     'status' => [
    //         'label' => 'Estado',
    //         'type' => 'select',
    //         'options' => collect(\App\Enums\Status::cases())
    //             ->mapWithKeys(fn($case) => [$case->value => $case->name])
    //             ->toArray(),
    //     ],
    //     'published_at' => [
    //         'label' => 'Fecha publicación',
    //         'type' => 'date',
    //     ],
    //     'autor' => [
    //         'label' => 'Autor',
    //         'type' => 'relation',
    //     ],
    // ];

    // return view('admin.news.index', compact('filterable'));
    // }
}
