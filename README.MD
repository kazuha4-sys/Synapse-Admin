# Synapse AdminPainel

[Visitor Badge](https://komarev.com/ghpvc/?username=teu-usuario&color=red&style=flat-square)
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/kazuha/adminpainel"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>

---

## Sobre o Projeto 
O AdminPainel é um pacote em desenvolvimento criado para adicionar rapidamente um painel administrativo completo em projetos Laravel.
Ele fornece gerenciamento de usuários, impersonation, dashboard e recursos essenciais para sistemas internos.


### funcionalidades

- Dashboard Administrativo
- Listagem de usuários 
- edição de nome, email e outras informações
- Exclusão de usuários
- Impersonate (Entrar temporariamente como outro usuário)
- Comandos Artisan de instalação
- Migrations incluídas 
- Views Personalizadas
- Proteção via Auth (middleware Auth)
- Instalação

---

## Requisitos 

- **PHP 8.1+**
- **Composer**
- **Laravel 10+**

---

## Instalação 
Cloe ou nstale o pacote localmente no seu projeto Laravel:
``bash 
composer require kazuha/adminpainel
``

Caso esteja usando o pacote local via path, configure no composer
``bash 
"repositories": [
    {
        "type": "path",
        "url": "packages/kazuha/adminpainel"
    }
]
``
Depois de um update no composer
``bash
composer update
``

---

## Instalação do Painel 

Execute o comando de instalação
``bash `
php artisan adminpainel:install
``

Com esse comando vc criar as migrations necessarias, cria o usuário de Adin inicial (usuario se senha serão exibidos no terminal onde você executou o comando de instalçao do admin)


---

## Acessando o Painel 



Depois da instalação ser concluida, acesse a rota de login **/login** e complete os campos com as informações que está no terminal. Após estar logado acesse a pagina de admin **/admin**.

---

## Contribuições 

Este pacote está em versão de desenvolvimento.
Algumas funcionalidades podem sofrer ajustes e receber melhorias futuras.
Atualizações serão liberadas continuamente, e quem quiser pode contribuir enviando PRs.

Qualquer ajuda é bem-vinda, como correções, novas features, melhorias no código, documentação ou finaceiramente.

**PIX:**11957136678
**(Qualquer valor já ajuda a manter o projeto vivo)

---

# **AVISO IMPORTANTE**

Como este é um pacote ainda em desenvolvimeto, erros ou comportamentos inesperados podem ocorrer.
Versões futuras trarão correções, refinamentos e novas funcionalidades.

---

## Licença 

Este projeto é distribuído sob a licença MIT.
