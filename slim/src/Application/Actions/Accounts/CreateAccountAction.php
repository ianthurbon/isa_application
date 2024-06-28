<?php

declare(strict_types=1);

namespace App\Application\Actions\Accounts;

use App\Domain\Accounts\DTO\AccountData;
use Psr\Http\Message\ResponseInterface as Response;

class CreateAccountAction extends AccountAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->respondWithData($this->accounts->create(
            new AccountData(
                array_merge(
                    ['user' => (int) $this->request->getAttribute('user')],
                    $this->getFormData()
                )
            )
        ));
    }
}
