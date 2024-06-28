<?php

declare(strict_types=1);

namespace App\Application\Actions\AccountTransactions;

use App\Domain\Accounts\DTO\AccountData;
use App\Domain\AccountTransactions\DTO\AccountTransactionData;
use Psr\Http\Message\ResponseInterface as Response;

class CreateAccountTransactionAction extends AccountTransactionAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->respondWithData($this->transactions->create(
            new AccountTransactionData(
                array_merge(
                    [
                        'id' => (int) $this->resolveArg('id'),
                        'user' => (int) $this->request->getAttribute('user')
                    ],
                    $this->getFormData()
                )
            )
        ));
    }
}
