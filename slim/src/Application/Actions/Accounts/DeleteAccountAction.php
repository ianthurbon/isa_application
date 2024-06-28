<?php

declare(strict_types=1);

namespace App\Application\Actions\Accounts;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteAccountAction extends AccountAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $this->accounts->delete((int)$this->resolveArg('id'), (int) $this->request->getAttribute('user'));
        return $this->respondWithData();
    }
}
