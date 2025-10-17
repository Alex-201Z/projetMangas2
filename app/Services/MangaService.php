<?php

namespace App\Services;

use App\Models\Manga;
use Exception;
use Illuminate\Database\QueryException;
use App\Exceptions\UserException;

class MangaService
{
    public function getListMangas()
    {
        try {
            $Liste = Manga::query()
                ->select('manga.*', 'genre.lib_genre', 'dessinateur.nom_dessinateur', 'scenariste.nom_scenariste')
                ->join('genre', 'genre.id_genre', '=', 'manga.id_genre')
                ->join('dessinateur', 'dessinateur.id_dessinateur', '=', 'manga.id_dessinateur')
                ->join('scenariste', 'scenariste.id_scenariste', '=', 'manga.id_scenariste')
                ->get();
            return $Liste;
        } catch (QueryException $exception) {
            $UserMessage = "Impossible d'accéder à la base de données.";
            throw new UserException($UserMessage, $exception->getMessage(), $exception->getCode());
        }
    }
    public function saveManga(Manga $manga)
    {
        try {
            $manga->save();
        } catch (QueryException $exception) {
            if (!$manga->id_genre) {
                $UserMessage = "Vous devez sélectionner un genre";
            } else if (!$manga->id_dessinateur) {
                $UserMessage = "Vous devez sélectionner un dessinateur";
            } else if (!$manga->id_scenariste) {
                $UserMessage = "Vous devez sélectionner un scénariste";
            } else if (!$manga->couverture) {
                $UserMessage = "Vous devez sélectionner une image de couverture";
            } else {
                $UserMessage = "Impossible de mettre à jour la base de données.";
            }
            throw new UserException($UserMessage, $exception->getMessage(), $exception->getCode());
        }
    }
    public function getManga($id)
    {
        try {
            $manga = Manga::query()->find($id);
            return $manga;
        } catch (QueryException $exception) {
            $userMessage = "Impossible de lire la base de données.";
            throw new UserException($userMessage, $exception->getMessage(), $exception->getCode());
        }
    }
    public function deleteManga($id)
    {
        try{
            $manga = Manga::query()->find($id);
            $manga->delete();
        } catch (QueryException $exception) {
            if ($exception->getCode() == 23000) {
                $userMessage = "Impossible de supprimer une fiche avec des manga saisis.";
            } else {
                $userMessage = "Erreur de sa suppression dans la base de données";
            }
            throw new UserException($userMessage, $exception->getMessage(), $exception->getCode());
        }

    }
}
