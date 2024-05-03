# 📄 Atende Cidadão

Este projeto de treinamento consiste no aprimoramento, novas tecnologias e funcionalidades, do projeto de Atendimento ao Contribuinte da prefeitura de uma cidade.

## 💻 Tecnologias Utilizadas:

-   Laravel
-   Inertia
-   Vuejs

## 🎲 Configuração do Banco de Dados

-   Criar um banco de dados MySQL chamado 'contribuinte'.
-   Copie o arquivo **.env.example** para **.env** e configure as variáveis de ambiente relacionadas ao banco de dados:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=contribuinte
DB_USERNAME=seu_usuario
DB_PASSWORD=
```

-   Para criar as tabelas do banco, execute o comando:

```
php artisan migrate
```

-   Habilite a conexão com o banco de dados e execute o projeto.

## 🖱️ Executando o Projeto:

```
php artisan serve
```

```
npm run dev
```

Acesse o projeto em http://localhost:8000.
