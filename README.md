# Case IEL

Este é o repositório do Case IEL, desenvolvido com as seguintes tecnologias:

- **Backend**: PHP 8.2, Composer, Arquitetura Limpa (Controllers, Services, Repositories, Models).
- **Frontend**: React + Vite, Axios.
- **Banco de Dados**: SQL Server 2022.
- **Infraestrutura**: Docker e Docker Compose.

## Estrutura do Projeto

- `/backend`: Contém a API em PHP puro, organizada em camadas, com as rotas centralizadas e arquivo de configuração.
- `/frontend`: Aplicação SPA construída com React e Vite.
- `/database`: Arquivos relacionados ao banco de dados (scripts SQL, estruturação, etc).
- `/docker`: Arquivos de configuração de containers (ex: Dockerfile do PHP com extensão `sqlsrv`).

## Como rodar o projeto

1. Certifique-se de ter o Docker e Docker Compose instalados.
2. Clone o repositório.
3. Crie uma cópia do `.env.example` com o nome `.env` na raiz do projeto.
4. Execute `docker-compose up -d --build` para subir os containers.
5. O backend estará disponível em `http://localhost:8000`.
6. O frontend estará disponível em `http://localhost:5173`.
7. O banco de dados SQL Server estará rodando na porta `1433`.

## Padrões Adotados
- Clean Code e princípios SOLID.
- Separação de responsabilidades utilizando Services e Repositories.
- Arquitetura focada em legibilidade e fácil manutenção.