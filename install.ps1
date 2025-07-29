# install_laravel.ps1

Write-Host "--- Iniciando a instalacao do projeto ---" -ForegroundColor Yellow

# 1. Copia o arquivo de ambiente, se ele nao existir
if (-not (Test-Path ".env")) {
    Write-Host "Copiando .env.example para .env..."
    Copy-Item .\.env.example .\.env -Force
} else {
    Write-Host ".env ja existe. Pulando a copia."
}

# 2. Instala as dependencias do PHP com Composer
Write-Host "Instalando dependencias do Composer (PHP)..."
composer install

# 3. Gera a chave da aplicacao
Write-Host "Gerando a chave da aplicacao (APP_KEY)..."
php artisan key:generate

# 4. Instala as dependencias do JavaScript com NPM
Write-Host "Instalando dependencias do NPM (JavaScript)..."
npm install

# 5. Compila os assets de front-end (CSS/JS)
Write-Host "Compilando os assets de front-end..."
npm run build # ou use 'npm run dev' para ambiente de desenvolvimento

# 6. Cria o link simbolico para a pasta de armazenamento
Write-Host "Criando o link de armazenamento (storage link)..."
php artisan storage:link

# 7. Gera o banco de dados
php artisan migrate
php artisan db:seed


Write-Host "--- Instalacao concluida com sucesso! ---" -ForegroundColor Green