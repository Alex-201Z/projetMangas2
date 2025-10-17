<?php

namespace App\Services;

use App\Exceptions\UserException;
use App\Models\Genre;
use Illuminate\Database\QueryException;


class GenreService
{
    public function getListGenres()
    {
        try {
            $liste = Genre::all();;
            return $liste;

        } catch (QueryException $exception) {
            $userMessage = "Impossible d'acceder à la base de données.";
            throw new UserException($userMessage, $exception->getMessage(), $exception->getCode());
        }
    }

}
