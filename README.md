CodeIgniter 4 Application Starter

# Plataforma de Gerenciamento de Formulários

### Desenvolvido em CodeIgniter 4 + MySQL

Este projeto é uma plataforma completa para criação, gerenciamento e análise de formulários, permitindo que administradores modelem formulários personalizados e que usuários externos respondam de forma simples e intuitiva.

O sistema foi desenvolvido para fins acadêmicos no curso de Engenharia de Software, abordando princípios como modelagem de dados, arquitetura MVC, usabilidade, boas práticas de desenvolvimento e organização de software.

---

## Funcionalidades Principais

### Para Administradores

- Criação de formulários dinâmicos

  - Diversos tipos de campos: texto, número, data, múltipla escolha, checkbox e mais
  - Ordenação e estruturação livre dos campos
  - Validações e campos obrigatórios
- Gerenciamento completo

  - Listagem de formulários
  - Edição em tempo real
  - Ativação e desativação de formulários
- Visualização de respostas

  - Dashboard com respostas em tempo real
  - Estatísticas básicas
- Relatórios

  - Tabelas de respostas
  - Exportação (PDF)

### Para Usuários Externos

- Interface simples e responsiva para preenchimento
- URLs públicas únicas
- Feedback imediato após envio

---

## Arquitetura do Projeto

O projeto utiliza:

### CodeIgniter 4 (CI4)

- Arquitetura MVC
- Rotas limpas
- Services, Filters e Helpers

### MySQL / MariaDB

- Modelagem relacional
- Entidades principais:
  - Formulários
  - Campos/Perguntas
  - Opções
  - Respostas
  - Relacionamentos auxiliares

### Front-end

- Views nativas do CI4 (PHP + HTML)
- Bootstrap 5.2
- JavaScript para interatividade
