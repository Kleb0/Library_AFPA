<?php

namespace App\Tests\Controller;

use App\Controller\AccountController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountControllerUnitTest extends TestCase
{
    public function testAccountRedirectsWhenNotLoggedIn(): void
    {
        echo " testAccountRedirectsWhenNotLoggedIn lancé\n";

        $controller = $this->getMockBuilder(AccountController::class)
            ->onlyMethods(['getUser', 'redirectToRoute'])
            ->getMock();

        $controller->method('getUser')->willReturn(null);

        $controller->method('redirectToRoute')
            ->with($this->equalTo('app_login'))
            ->willReturn(new RedirectResponse('/login'));

        $response = $controller->account();


        $this->assertInstanceOf(RedirectResponse::class, $response);


        /** @var RedirectResponse $response */
        $this->assertSame('/login', $response->getTargetUrl());
    }

    public function testAccountReturnsViewWhenLoggedIn(): void
    {
        $mockUser = $this->createMock(UserInterface::class);

        $controller = $this->getMockBuilder(AccountController::class)
            ->onlyMethods(['getUser', 'render'])
            ->getMock();

        $controller->method('getUser')->willReturn($mockUser);

        $controller->method('render')
            ->with(
                $this->equalTo('account/account.html.twig'),
                $this->equalTo(['user' => $mockUser])
            )
            ->willReturn(new Response('page account'));

        $response = $controller->account();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame('page account', $response->getContent());
    }
}
