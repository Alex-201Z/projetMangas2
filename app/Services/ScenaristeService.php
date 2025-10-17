<?php

namespace App\Services;

use App\Exceptions\UserException;
use App\Models\Scenariste;
use Illuminate\Database\QueryException;

class ScenaristeService
{
    public function getListScenaristes()
    {
        try {
            $liste = Scenariste::all();;
            return $liste;

        } catch (QueryException $exception) {
            $userMessage = "Impossible d'acceder à la base de données.";
            throw new UserException($userMessage, $exception->getMessage(), $exception->getCode());
        }
    }

}
