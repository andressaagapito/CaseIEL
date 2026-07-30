# Case Técnico - API de Gerenciamento de Usuários

## Descrição

Aplicação desenvolvida para atender ao case técnico proposto, composta por uma API REST para gerenciamento de usuários e uma interface web para consumo da API.

A solução implementa as funcionalidades obrigatórias solicitadas:

- Cadastro de usuários;
- Listagem de usuários;
- Filtro por status;
- Consulta por ID;
- Inativação de usuário (soft delete através do campo status).

## Objetivo

O objetivo deste projeto é demonstrar a capacidade de construir uma aplicação funcional (Backend e Frontend) aplicando padrões de projeto, arquitetura em camadas, segurança e boas práticas de desenvolvimento de software em um cenário prático.

## Estrutura do Projeto

Abaixo está o resumo da estrutura de diretórios do projeto:

```text
.
├── backend/
│   ├── public/         # Ponto de entrada da API (index.php)
│   ├── routes/         # Definição das rotas da API
│   ├── src/
│   │   ├── Controllers/# Controladores das requisições
│   │   ├── Models/     # Modelos e entidades
│   │   ├── Repositories/# Acesso ao banco de dados
│   │   └── Services/   # Regras de negócio
│   └── tests/          # Testes automatizados
├── database/           # Scripts SQL (ex: init.sql)
└── frontend/
    ├── public/         # Arquivos estáticos
    └── src/
        ├── pages/      # Componentes de página (UserForm, UserList)
        ├── App.jsx     # Contêiner principal
        ├── App.css     # Estilos da aplicação
        └── config.js   # Configurações globais
```

## Tecnologias

### Backend

- PHP 8.2
- SQL Server 2022

### Frontend

- React
- Vite
- Axios

### Infraestrutura

- Docker
- Docker Compose

## Pré-requisitos

Certifique-se de ter os seguintes softwares instalados na sua máquina antes de prosseguir:

- [Git](https://git-scm.com/)
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- (Opcional) Ambiente WSL configurado caso esteja utilizando Windows.

## Como executar

Siga os passos abaixo para rodar a aplicação localmente:

### 1. Clonar o projeto

```bash
git clone <url-do-repositorio>
cd <nome-da-pasta-do-projeto>
```

### 2. Configurar o ambiente

Crie o arquivo de variáveis de ambiente copiando o exemplo fornecido:

```bash
cp .env.example .env
```
Em seguida, abra o arquivo `.env` e ajuste as credenciais do banco de dados.

### 3. Subir os containers

Inicialize os containers executando:

```bash
docker-compose up -d --build
```

### 4. Criar a estrutura do banco

Execute o script de inicialização para criar as tabelas necessárias utilizando a ferramenta cliente de sua preferência ou através do próprio container:

```bash
# <Comando-placeholder-para-executar-o-script-sql-no-banco>
# Exemplo: docker exec -i <container-db> /opt/mssql-tools/bin/sqlcmd -S localhost -U sa -P <senha> -i database/init.sql
```
*(O script de criação está disponível em `database/init.sql`)*

### 5. Iniciar o Frontend

Em um novo terminal, acesse a pasta do frontend, instale as dependências e inicie o servidor:

```bash
cd frontend
npm install
npm run dev
```

## Acessos da aplicação

Após a inicialização, os serviços estarão disponíveis nos seguintes endereços:

- **Frontend:** `http://localhost:<porta-do-frontend>` (padrão Vite: `http://localhost:5173`)
- **Backend / API:** `http://localhost:<porta-da-api>` (padrão: `http://localhost:8000`)
- **Documentação da API (Swagger/OpenAPI):** `<url-da-documentacao-caso-exista>`

## Endpoints

Abaixo estão as rotas disponíveis na API REST:

| Método | Endpoint | Descrição |
|---------|----------|-----------|
| POST | `/users` | Cadastrar usuário |
| GET | `/users` | Listar usuários |
| GET | `/users/{id}` | Buscar usuário |
| PATCH | `/users/{id}/inactivate` | Inativar usuário |

### Exemplos de uso da API

**Criar Usuário (POST `/users`)**
```json
{
  "nome": "João Silva",
  "email": "joao.silva@exemplo.com",
  "senha": "SenhaForte123!",
  "status": "ativo"
}
```
**Resposta (201 Created):**
```json
{
  "id": 1,
  "nome": "João Silva",
  "email": "joao.silva@exemplo.com",
  "status": "ativo"
}
```

**Listar Usuários (GET `/users`)**

A listagem suporta filtro por status. Exemplos:
- Todos os usuários: `GET /users`
- Apenas ativos: `GET /users?status=ativo`
- Apenas inativos: `GET /users?status=inativo`

**Resposta (200 OK):**
```json
[
  {
    "id": 1,
    "nome": "João Silva",
    "email": "joao.silva@exemplo.com",
    "status": "ativo"
  }
]
```

## Segurança

Foram adotadas as seguintes práticas de segurança:

- Hash de senha utilizando `password_hash()`;
- Validação de dados de entrada;
- Tratamento consistente de erros (sem expor exceções reais do banco de dados);
- Prepared Statements para prevenção de SQL Injection.

## Testes

Foi implementado um teste automatizado para validação da regra de e-mail único durante o cadastro de usuários.

Para rodar os testes, utilize o comando:
```bash
# <Comando-placeholder-para-executar-os-testes>
# Exemplo: docker-compose exec php vendor/bin/phpunit
```

## Limitações

Por se tratar de um case técnico, não foram implementados:

- autenticação e autorização;
- paginação;
- edição de usuários;
- funcionalidades além das exigidas no enunciado.

## Utilização de Inteligência Artificial

Ferramentas de IA foram utilizadas como apoio durante o desenvolvimento para auxiliar na estruturação inicial do projeto e revisão de código.

Todo o código gerado foi revisado, adaptado e validado manualmente antes da integração ao projeto. As regras de negócio, integrações, tratamento de erros e funcionamento da aplicação foram conferidos manualmente para garantir aderência aos requisitos do case.

## Justificativa das decisões técnicas

O foco desta implementação foi atender integralmente aos requisitos obrigatórios do desafio, priorizando organização do código, separação de responsabilidades, simplicidade, legibilidade e boas práticas de desenvolvimento. 

O uso de PHP sem frameworks pesados e React sem bibliotecas UI externas demonstra domínio nas linguagens base e evita *over-engineering*. O Docker foi utilizado para assegurar a portabilidade imediata do SQL Server e do backend na avaliação.