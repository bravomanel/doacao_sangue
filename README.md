# Sistema de Gerenciamento para Clínica de Doação de Sangue

## Introdução

Este é o projeto de uma clínica fictícia de doação de sangue, projetado para gerenciar o cadastro e o histórico de doações de seus doadores.

O foco do projeto é demonstrar a implementação de um sistema web dinâmico e funcional, com ênfase nas operações de CRUD (Create, Read, Update, Delete), com um sistema de login simples para separar as permissões de acesso entre doadores e administradores.

O sistema foi construído utilizando as seguintes tecnologias:

   Frontend: HTML, CSS e Bootstrap 5
   Backend: PHP 8
   Banco de Dados: MySQL

## Páginas e Níveis de Acesso

#### Páginas Públicas (Acesso Livre)

   `index.php` (Home)
   `quem_somos.php`
   `cadastrar_doador.php`
   `login.php`

#### Páginas do Administrador (Requer Login)

   `painel_admin.php` (Dashboard do admin)
   `gerenciar_doadores.php`
   `editar_doador.php`
   `controle_doacoes.php`
   `gerenciar_locais.php` (CRUD de locais)

## Fluxo de Uso do Site (Atualizado)

#### Fluxo do Doador:

1.  O usuário acessa a página Home (`index.php`), onde é recebido com informações sobre a importância da doação de sangue e um chamado para a ação.
2.  Ele pode navegar até a página Quem Somos (`quem_somos.php`) para conhecer mais sobre a clínica.
3.  Ao decidir se tornar um doador, ele clica no botão "Seja um Doador" (ou no link do menu) e é direcionado para a página de Cadastro (`cadastrar_doador.php`).
4.  Nesta página, ele preenche um formulário com seus dados pessoais (nome, tipo sanguíneo, etc.) e envia o cadastro. Após o envio, seu registro passa a fazer parte do sistema da clínica.
5.  Caso doador já tenha cadastro, ele pode fazer login e acessar a página de Controle de Doações (`controle_doacoes.php`) para visualizar seu histórico de doações e registrar novas doações.

#### Fluxo do Administrador:

1.  Primeiro o administrador acessa a página de Login (`login.php`), onde insere suas credenciais (neste caso, um usuário fixo sem senha).
2.  Para gerenciar os registros, o administrador acessa a página Gerenciar Doadores (`gerenciar_doadores.php`). Nesta página, ele pode visualizar todos os doadores cadastrados em uma tabela, com opções para editar ou excluir cada registro.
3.  Ao clicar no botão "Editar" ao lado de um doador, o administrador é levado para a página de Edição (`editar_doador.php`), onde pode atualizar as informações do doador.
4.  Também pode acessar a página de Controle de Doações (`controle_doacoes.php`) para gerenciar o histórico de doações de cada doador, podendo registrar novas doações e visualizar o histórico completo.

## Lista de Tarefas (To-Do List) - Atualizada

#### Fase 1: Estrutura e Banco de Dados

  - [x] Planejar a arquitetura do projeto e as tecnologias a serem usadas.
  - [x] Definir a estrutura de pastas e arquivos.
  - [x] Criar o script SQL para as tabelas `doadores`, `locais_doacao`, `doacoes` e `administradores`.
  - [x] Configurar o banco de dados `clinica_db` e executar o script SQL no ambiente local.

#### Fase 2: Componentes Reutilizáveis e Acesso

  - [x] Criar o arquivo de conexão `includes/conexao.php`.
  - [x] Desenvolver `includes/header.php` e `includes/footer.php`.
  - [x] Login do Administrador:
      - [x] Criar o formulário em `login.php`.
      - [x] Desenvolver `backend/processa_login.php` para validar o usuário e criar uma sessão (`$_SESSION`).
      - [x] Criar um script `includes/verifica_login.php` para incluir no topo das páginas restritas.
      - [x] Criar `logout.php` para destruir a sessão.

#### Fase 3: Desenvolvimento das Páginas e Funcionalidades
  - [x] Páginas Privadas:
      - [x] Desenvolver `painel_adm.php`.
      - [x] Desenvolver `registrar_doacao.php`.
  - [x] Páginas Públicas:
      - [x] Desenvolver `index.php`.
      - [x] Desenvolver `quem_somos.php`.
  - [x] CRUD de Doadores:
      - [x] Create: Atualizar `cadastrar_doador.php` com os campos de CPF, CEP e o questionário. Atualizar `backend/processa_cadastro.php`.
      - [x] Read: Implementar `gerenciar_doadores.php`.
      - [x] Update: Implementar `editar_doador.php` e `backend/processa_edicao.php`.
      - [x] Delete: Implementar a exclusão com modal em `gerenciar_doadores.php` e `backend/deletar_doador.php`.
  - [x] CRUD de Locais de Doação (Admin):
      - [x] Criar a página `gerenciar_locais.php` para listar, editar e excluir locais.
      - [x] Criar formulário e script para `cadastrar_local.php` e `backend/processa_local_cadastro.php`.
      - [x] Criar formulário e script para `editar_local.php` e `backend/processa_local_edicao.php`.
  - [x] Controle de Doações:
      - [x] Atualizar `controle_doacoes.php` para que o formulário de nova doação inclua um `<select>` com os locais de doação cadastrados.
      - [x] Atualizar `backend/processa_doacao.php` para salvar o `local_id`.

#### Fase 4: Finalização

  - [ ] Revisar a responsividade de todas as páginas.
  - [ ] Testar todos os fluxos de usuário (cadastro, login de admin, todos os CRUDs).
  - [ ] Limpar o código e adicionar comentários.
  - [ ] Fazer o Deploy.