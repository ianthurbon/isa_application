<?php

declare(strict_types=1);

namespace App\Application\Actions\FundTypes;

use Psr\Http\Message\ResponseInterface as Response;

class ListFundTypesAction extends FundTypesAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->respondWithData($this->fundTypes->findAll());
    }
}
