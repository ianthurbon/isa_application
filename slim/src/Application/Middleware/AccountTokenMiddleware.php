<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Users\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class AccountTokenMiddleware implements Middleware
{
    public function __construct(
        protected UserRepository $userRepository
    ){}

    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        $apiToken = $this->getAccountToken($request);
        if (!$apiToken) {
            $response = new Response();
            return $response->withStatus(401);
        }

        try {
            $user = $this->userRepository->findByToken($apiToken);
            $request = $request->withAttribute('user', $user->id());
        } catch (DomainRecordNotFoundException $e) {
            $response = new Response();
            return $response->withStatus(401);
        }

        return $handler->handle($request);
    }

    private function getAccountToken(Request $request): ?string
    {
        $headers = $request->getHeader('Account-Token');
        if (!empty($headers)) {
            foreach ($headers as $value) {
                return $value;
            }
        }

        return null;
    }
}
