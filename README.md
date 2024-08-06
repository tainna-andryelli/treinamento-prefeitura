# 📄 Atende Cidadão

Este projeto de treinamento visa aprimorar e adicionar novas tecnologias e funcionalidades ao sistema de Atendimento ao Contribuinte da prefeitura de uma cidade. O sistema permite que os atendentes registrem protocolos e associem pessoas a esses protocolos, acompanhem o andamento dos protocolos e anexem arquivos em determinados formatos. Além disso, o sistema oferece a opção de exportar os protocolos em formato PDF.

O sistema conta com autenticação via login e diferentes perfis de usuário: Administrador de TI, Administrador do Sistema e Atendente. Cada perfil possui restrições específicas; por exemplo, administradores de TI podem registrar Administradores do Sistema, mas o contrário não é permitido. O sistema também inclui um mecanismo de auditoria para monitorar as atividades e muitas outras funcionalidades, vamos conferir?

## 👀 Preview
![image](https://github.com/user-attachments/assets/542d4770-8865-4b13-86c9-822a3a82666c)


## 💻 Tecnologias Utilizadas e Versões:

-   Laravel 11.0
-   PHP 8.2
-   Inertia 1.0
-   Vuejs 3.3.13
---  
-   Execute os comando:
```
composer install
```
```
npm install
```
```
php artisan key:generate
```
---
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
-   Você também pode rodar o comando para iniciar um usuário administrador:
```
php artisan db:seed --class=UserSeeder
```

## 🖱️ Executando o Projeto:

```
php artisan serve
```

```
npm run dev
```

Acesse o projeto em http://localhost:8000.
Entre como administrador utilizando as credencias dos seeders.
