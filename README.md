<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


# SGFrota

# TODO
- Admin: editar icones
    trocar senha do user
- Editar caminhão: add botao de excluir caminhao
- Sidebar: menu com opçoes "dropdown"
- Card caminhão: ver o qq vai ser exibido
    remover botao de status
- Relatórios





## Para instalar o projeto
**Instale o PHP/Laravel**

`Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))`

https://laravel.com/docs/12.x/installation

**Instale o NodeJS**
https://nodejs.org/pt/download

**Edite as variáveis de ambiente**
Copie o arquivo .env.example e edite as variáveis de ambiente conforme necessário

`cp .env.example .env`


**Instale as dependências do projeto**
Rode o script _setup.ps1_ para instalar todas as dependências do projeto

`.\setup.ps1`


## Para rodar
Tendo tudo instalado, inicie o servidor dev local

`php artisan serve`