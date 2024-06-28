<?php

declare(strict_types=1);

namespace App\Application\Actions\AccountTypes;

use Psr\Http\Message\ResponseInterface as Response;

class ListAccountTypesAction extends AccountTypesAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->respondWithData($this->accountTypes->findAll());
    }
}
