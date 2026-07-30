IF NOT EXISTS (SELECT * FROM sys.databases WHERE name = 'caseiel')
BEGIN
    CREATE DATABASE caseiel;
END
GO

USE caseiel;
GO

IF NOT EXISTS (SELECT * FROM sys.tables WHERE name = 'users')
BEGIN
    CREATE TABLE users (
        id INT IDENTITY(1,1) PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        status VARCHAR(10) NOT NULL DEFAULT 'ativo' CHECK (status IN ('ativo', 'inativo')),
        created_at DATETIME NOT NULL DEFAULT GETDATE(),
        updated_at DATETIME NOT NULL DEFAULT GETDATE()
    );
END
GO

-- Trigger para atualizar automaticamente o campo updated_at a cada update na tabela users
CREATE OR ALTER TRIGGER trg_users_updated_at
ON users
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;
    UPDATE users
    SET updated_at = GETDATE()
    FROM inserted i
    WHERE users.id = i.id;
END;
GO
