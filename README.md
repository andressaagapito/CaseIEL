# Case Técnico - API de Gerenciamento de Usuários

## Descrição

Aplicação desenvolvida para atender ao case técnico proposto, composta por uma API REST para gerenciamento de usuários e uma interface web para consumo da API.

A solução implementa as funcionalidades obrigatórias solicitadas:

- Cadastro de usuários;
- Listagem de usuários;
- Filtro por status;
- Consulta por ID;
- Inativação de usuário (soft delete através do campo status).

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

## Arquitetura

O projeto foi organizado em camadas para separar responsabilidades:

- Controllers: recebem as requisições HTTP.
- Services: concentram as regras de negócio.
- Repositories: realizam acesso ao banco de dados.
- Models: representação das entidades.

Essa organização foi escolhida por ser simples, facilitar manutenção e atender ao escopo do desafio sem adicionar complexidade desnecessária.

## Como executar

### Clonar o projeto

```bash
git clone <url>
```

### Configurar ambiente

Copiar:

```
.env.example
```

para

```
.env
```

e ajustar as credenciais do banco.

### Subir containers

```bash
docker-compose up -d
```

### Criar banco

Executar o script disponível em:

```
database/create.sql
```

## Endpoints

| Método | Endpoint | Descrição |
|---------|----------|-----------|
| POST | /users | Cadastrar usuário |
| GET | /users | Listar usuários |
| GET | /users/{id} | Buscar usuário |
| PATCH | /users/{id}/inactivate | Inativar usuário |

## Segurança

Foram adotadas as seguintes práticas:

- Hash de senha utilizando `password_hash()`;
- Validação de dados de entrada;
- Tratamento consistente de erros;
- Prepared Statements para prevenção de SQL Injection.

## Testes

Foi implementado teste automatizado para validação da regra de e-mail único durante o cadastro de usuários.

## Limitações

Por se tratar de um case técnico, não foram implementados:

- autenticação;
- autorização;
- paginação;
- edição de usuários;
- funcionalidades além das exigidas no enunciado.

## Utilização de Inteligência Artificial

Ferramentas de IA foram utilizadas como apoio durante o desenvolvimento para auxiliar na estruturação inicial do projeto e revisão de código.

Todo o código gerado foi revisado, adaptado e validado manualmente antes da integração ao projeto. As regras de negócio, integrações, tratamento de erros e funcionamento da aplicação foram conferidos manualmente para garantir aderência aos requisitos do case.

## Considerações

O foco desta implementação foi atender integralmente aos requisitos obrigatórios do desafio, priorizando organização do código, separação de responsabilidades, simplicidade, legibilidade e boas práticas de desenvolvimento.