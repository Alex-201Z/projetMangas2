<?php

namespace App\Http\Controllers;

use App\Models\Dessinateur;
use App\Models\Genre;
use App\Models\Scenariste;
use Exception;
use Illuminate\Http\Request;
use App\Services\MangaService;
use App\Services\DessinateurService;
use App\Services\GenreService;
use App\Services\ScenaristeService;
use App\Models\Manga;
use MongoDB\Driver\Session;

class MangaController extends Controller
{
    public function listMangas()
    {
        try {
            $service = new MangaService();
            $mangas = $service->getListMangas();
            foreach ($mangas as $manga) {
                if (!file_exists('assets\\images\\' . $manga->couverture)) {
                    $manga->couverture = 'erreur.png';
                }
            }
            return view('listMangas', compact('mangas'));
        } catch (Exception $exception) {
            return view("error", compact('exception'));
        }
    }
    public function addManga()
    {
        try {
            $serviceG = new GenreService();
            $serviceS = new ScenaristeService();
            $serviceD = new DessinateurService();
            $manga = new Manga();
            $genres = $serviceG->getListGenres();
            $scenaristes  = $serviceS->getListScenaristes();
            $dessinateurs = $serviceD->getListDessinateurs();
            return view('/formManga', compact('manga', 'genres', 'scenaristes', 'dessinateurs'));
        } catch (Exception $exception) {
            return view("error", compact('exception'));
        }
    }
    public function validManga(Request $request)
    {
        try {
            $id = $request->get('id');
            $service = new MangaService();
            if ($id) {

                $manga = $service->getManga($id);
            } else {
                $manga = new Manga();
            }
            $manga->titre = $request->input('titre');
            $manga->id_genre = $request->input('Genre');
            $manga->id_dessinateur = $request->input('Dessinateur');
            $manga->id_scenariste = $request->input('Scenariste');
            $manga->prix = $request->input('prix');

            $couv = $request->file('couv');
            if ($couv) {
                $manga->couverture = $couv->getClientOriginalName();
                $couv->move(public_path() . '\assets\images', $manga->couverture);
            }
            $service->saveManga($manga);
            return redirect(route('listMangas'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
    public function editManga($id)
    {
        try {
            $serviceG = new GenreService();
            $serviceS = new ScenaristeService();
            $serviceD = new DessinateurService();
            $service = new MangaService();
            $manga = $service->getManga($id);
            $genres = $serviceG->getListGenres();
            $scenaristes  = $serviceS->getListScenaristes();
            $dessinateurs = $serviceD->getListDessinateurs();


            return view('formManga', compact('manga', 'genres', 'scenaristes', 'dessinateurs'));
        } catch (Exception $exception) {
            return view("error", compact('exception'));
        }

    }
    public function removeManga($id)
    {
        try {
            $service = new mangaService();
            $service->deleteManga($id);

            return redirect(url ('listerManga'));

        } catch (Exception $exception) {
            if ($exception->getCode() == 23000) {
                session::put('erreur', $exception->getUserMessage());
                return redirect(url('/editerFrais/' . $id));
            }else {
                return view("error", compact('exception'));
            }
        }
    }

}
