<?php

namespace Tests;

use App\Repositories\UserRepository;
use App\Services\UserService;
use Exception;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    public function testShouldThrowExceptionWhenEmailAlreadyExists(): void
    {
        $userData = [
            'name' => 'Senhor Teste',
            'email' => 'duplicado@email.com',
            'password' => '123456',
            'status' => 'ativo',
        ];

        $repository = $this->createMock(UserRepository::class);

        $repository
            ->expects($this->once())
            ->method('findByEmail')
            ->with($userData['email'])
            ->willReturn([
                'id' => 1,
                'name' => 'Usuário Antigo',
                'email' => $userData['email'],
                'status' => 'ativo',
            ]);

        $service = new UserService($repository);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('O e-mail informado já está em uso.');

        $service->create($userData);
    }
}