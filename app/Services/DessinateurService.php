<?php

namespace App\Services;

use App\Exceptions\UserException;
use App\Models\Dessinateur;
use Illuminate\Database\QueryException;

class DessinateurService
{

    public function getListDessinateurs()
    {
        try {
            $liste = Dessinateur::all();;
            return $liste;

        } catch (QueryException $exception) {
            $userMessage = "Impossible d'acceder à la base de données.";
            throw new UserException($userMessage, $exception->getMessage(), $exception->getCode());
        }
    }

}
