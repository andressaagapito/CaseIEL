<?php

class UsuarioRepository
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function cadastrarUsuario(string $nome, string $email, string $senha, string $status): ?int
    {
        $sql = "INSERT INTO usuarios (nome, email, senha, status) VALUES (:nome, :email, :senha, :status)";
        
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':senha' => $senhaHash,
                ':status' => $status
            ]);
            
            return (int) $this->conn->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erro no BD ao cadastrar: " . $e->getMessage());
            throw new RuntimeException("Não foi possível realizar o cadastro no momento.");
        }
    }

    public function buscarUsuarios(?string $filtroStatus = null): array
    {
        $sql = "SELECT * FROM usuarios";
        $params = [];

        if (!empty($filtroStatus)) {
            $sql .= " WHERE status = :status";
            $params[':status'] = $filtroStatus;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removerUsuario(int $id): bool
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        return $stmt->rowCount() > 0;
    }
}
