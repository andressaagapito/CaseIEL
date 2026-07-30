<?php

namespace Tests;

use App\Services\UserService;
use App\Repositories\UserRepository;
use PHPUnit\Framework\TestCase;
use Exception;

class UserServiceTest extends TestCase
{
    public function testShouldNotAllowDuplicateEmailRegistration(): void
    {
        $repositoryMock = $this->createMock(UserRepository::class);
        
        $repositoryMock->expects($this->once())
            ->method('findByEmail')
            ->with('teste@teste.com')
            ->willReturn(['id' => 1, 'email' => 'teste@teste.com', 'name' => 'Teste']);

        $repositoryMock->expects($this->never())
            ->method('create');

        $userService = new UserService($repositoryMock);

        $userData = [
            'name' => 'Novo Usuário',
            'email' => 'teste@teste.com',
            'password' => '123456',
            'status' => 'ativo'
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("O e-mail informado já está em uso.");

        $userService->create($userData);
    }
}
