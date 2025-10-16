<?php

namespace App\Http\Controllers;

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
        $novedoso = Article::latest()->take(3)->get();
        $centros = Center::all();
        $convocatorias = Convocatory::latest()->take(3)->get();
        $eventos = Event::latest()->take(3)->get();
        $headers = Header::all();
        $links = Link::all();
        $noticias = News::latest()->take(3)->get();
        $servicios = Service::latest()->take(3)->get();

        return view('landing-page', compact('novedoso', 'centros', 'convocatorias', 'eventos', 'headers', 'links', 'noticias', 'servicios'));
    }
}
