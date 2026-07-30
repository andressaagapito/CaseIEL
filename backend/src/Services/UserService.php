<?php

namespace App\Services;

use App\Repositories\UserRepository;
use InvalidArgumentException;
use Exception;

class UserService
{
    private UserRepository $repository;

    public function __construct(?UserRepository $repository = null)
    {
        $this->repository = $repository ?? new UserRepository();
    }

    public function create(array $data): bool
    {
        $this->validateCreateData($data);

        $existingUser = $this->repository->findByEmail($data['email']);
        if ($existingUser !== null) {
            throw new Exception("O e-mail informado já está em uso.");
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        return $this->repository->create($data);
    }

    public function findById(int $id): ?array
    {
        return $this->repository->findById($id);
    }

    public function findByEmail(string $email): ?array
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("E-mail inválido.");
        }
        return $this->repository->findByEmail($email);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function updateStatus(int $id, string $status): bool
    {
        if (!in_array($status, ['ativo', 'inativo'])) {
            throw new InvalidArgumentException("Status deve ser 'ativo' ou 'inativo'.");
        }

        $user = $this->repository->findById($id);
        if (!$user) {
            throw new Exception("Usuário não encontrado.");
        }

        return $this->repository->updateStatus($id, $status);
    }

    private function validateCreateData(array $data): void
    {
        if (empty($data['name'])) {
            throw new InvalidArgumentException("O nome é obrigatório.");
        }

        if (empty($data['email'])) {
            throw new InvalidArgumentException("O e-mail é obrigatório.");
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("O e-mail fornecido é inválido.");
        }

        if (empty($data['password'])) {
            throw new InvalidArgumentException("A senha é obrigatória.");
        }

        if (!isset($data['status']) || !in_array($data['status'], ['ativo', 'inativo'])) {
            throw new InvalidArgumentException("O status deve ser 'ativo' ou 'inativo'.");
        }
    }
}
