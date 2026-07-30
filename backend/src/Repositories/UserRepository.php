<?php

namespace App\Repositories;

use App\Config\Database;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct(?PDO $db = null)
    {
        $this->db = $db ?? Database::getConnection();
    }

    public function create(array $data): bool
    {
        $query = "INSERT INTO users (name, email, password, status) VALUES (:name, :email, :password, :status)";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':status' => $data['status']
        ]);
    }

    public function findById(int $id): ?array
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':email' => $email]);
        
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findAll(?string $status = null): array
    {
        if ($status) {
            $query = "SELECT * FROM users WHERE status = :status";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':status' => $status]);
        } else {
            $query = "SELECT * FROM users";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        }
        
        return $stmt->fetchAll();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $query = "UPDATE users SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
    }
}
