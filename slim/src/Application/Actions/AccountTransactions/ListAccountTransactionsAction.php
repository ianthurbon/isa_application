<?php

declare(strict_types=1);

namespace App\Application\Actions\AccountTransactions;

use Psr\Http\Message\ResponseInterface as Response;

class ListAccountTransactionsAction extends AccountTransactionAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->respondWithData($this->transactions->all(
            (int) $this->resolveArg('id'),
            (int) $this->request->getAttribute('user')
        ));
    }
}
