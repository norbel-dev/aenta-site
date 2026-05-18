<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Article;
use App\Models\Center;
use App\Models\Convocatory;
use App\Models\Event;
use App\Models\Header;
use App\Models\Link;
use App\Models\News;
use App\Models\Service;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $novedoso = Article::latest()->where('status', Status::EDIT_PUBLISHED)->take(5)->get();
        $centros = Center::all();
        $convocatorias = Convocatory::latest()->where('status', Status::EDIT_PUBLISHED)->take(5)->get();
        $eventos = Event::latest()->where('status', Status::EDIT_PUBLISHED)->take(5)->get();
        $headers = Header::where('status', Status::EDIT_PUBLISHED)->get();
        $links = Link::all();
        $noticias = News::latest()->where('status', Status::EDIT_PUBLISHED)->take(5)->get();
        $servicios = Service::latest()->take(5)->get();
        return view('landing-page', compact('novedoso', 'centros', 'convocatorias', 'eventos', 'headers', 'links', 'noticias', 'servicios'));
    }
}
