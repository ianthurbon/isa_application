<?php

declare(strict_types=1);

namespace App\Application\Actions\Accounts;

use Psr\Http\Message\ResponseInterface as Response;

class ListAccountsAction extends AccountAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->respondWithData($this->accounts->all((int) $this->request->getAttribute('user')));
    }
}
