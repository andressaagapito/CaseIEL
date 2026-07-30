<?php

namespace App\Controllers;

use App\Services\UserService;
use InvalidArgumentException;
use Exception;

class UserController
{
    private UserService $service;

    public function __construct(?UserService $service = null)
    {
        $this->service = $service ?? new UserService();
    }

    public function create(): void
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (!is_array($data)) {
                $data = [];
            }

            $this->service->create($data);

            http_response_code(201);
            echo json_encode(['message' => 'Usuário criado com sucesso.']);
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (Exception $e) {
            if ($e->getMessage() === "O e-mail informado já está em uso.") {
                http_response_code(409);
            } else {
                http_response_code(400);
            }
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function findAll(): void
    {
        try {
            $users = $this->service->findAll();
            
            $users = array_map(function ($user) {
                unset($user['password']);
                return $user;
            }, $users);

            http_response_code(200);
            echo json_encode($users);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro interno do servidor.']);
        }
    }

    public function findById(int $id): void
    {
        try {
            $user = $this->service->findById($id);
            if (!$user) {
                http_response_code(404);
                echo json_encode(['error' => 'Usuário não encontrado.']);
                return;
            }

            unset($user['password']);
            http_response_code(200);
            echo json_encode($user);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro interno do servidor.']);
        }
    }

    public function inactivate(int $id): void
    {
        try {
            $this->service->updateStatus($id, 'inativo');
            
            http_response_code(200);
            echo json_encode(['message' => 'Usuário inativado com sucesso.']);
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (Exception $e) {
            if ($e->getMessage() === "Usuário não encontrado.") {
                http_response_code(404);
            } else {
                http_response_code(500);
            }
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
