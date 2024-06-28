<?php

declare(strict_types=1);

use App\Application\Actions\Accounts\CreateAccountAction;
use App\Application\Actions\Accounts\DeleteAccountAction;
use App\Application\Actions\Accounts\GetAccountAction;
use App\Application\Actions\Accounts\ListAccountsAction;
use App\Application\Actions\AccountTransactions\CreateAccountTransactionAction;
use App\Application\Actions\AccountTransactions\ListAccountTransactionsAction;
use App\Application\Actions\AccountTypes\ListAccountTypesAction;
use App\Application\Actions\FundTypes\ListFundTypesAction;
use App\Application\Actions\Users\GetUserAction;
use App\Application\Actions\Users\ListUsersAction;
use App\Application\Middleware\AccountTokenMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('/{id}', GetUserAction::class);
        $group->get('', ListUsersAction::class);
    });

    $app->group('/account-types', function (Group $group) {
        $group->get('', ListAccountTypesAction::class);
    });

    $app->group('/fund-types', function (Group $group) {
        $group->get('', ListFundTypesAction::class);
    });

    $app->group('/accounts', function (Group $group) {
        $group->post('', CreateAccountAction::class);
        $group->post('/{id}/deposit', CreateAccountTransactionAction::class);
        $group->get('/{id}/transactions', ListAccountTransactionsAction::class);
        $group->get('/{id}', GetAccountAction::class);
        $group->get('', ListAccountsAction::class);
        $group->delete('/{id}', DeleteAccountAction::class);
    })->add(AccountTokenMiddleware::class);
};
