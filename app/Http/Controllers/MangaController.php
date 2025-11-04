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
            $manga = new Manga();
            return $this->showManga($manga);
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
    public function validManga(Request $request)
    {
        try {
            $request->validate([
                'titre' => 'required|max:250',
                'genre' => 'required|exists:genre,id_genre',
                'dess' => 'required|exists:dessinateur,id_dessinateur',
                'scen' => 'required|exists:scenariste,id_scenariste',
                'prix' => 'required|numeric|between:0,1000'
            ]);
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
            $service = new MangaService();
            $manga = $service->getManga($id);
            return $this->showManga($manga);
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
    public function removeManga($id)
    {
        try {
            $service = new mangaService();
            $service->deleteManga($id);

            return redirect( route ('listMangas'));

        } catch (Exception $exception) {
            if ($exception->getCode() == 23000) {
                session::put('erreur', $exception->getUserMessage());
                return redirect(url('/editerFrais/' . $id));
            }else {
                return view("error", compact('exception'));
            }
        }
    }
    private function showManga(Manga $manga)
    {
        $serviceG = new GenreService();
        $genres = $serviceG->getListGenres();
        $serviceD = new DessinateurService();
        $dessinateurs = $serviceD->getListDessinateurs();
        $serviceS = new ScenaristeService();
        $scenaristes = $serviceS->getListScenaristes();
        return view('formManga', compact('genres', 'dessinateurs', 'scenaristes', 'manga'));
    }

}
