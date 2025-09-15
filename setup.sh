#!/usr/bin/env bash
set -euo pipefail

info()  { printf "\033[1;34m[INFO]\033[0m %s\n" "$*"; }
warn()  { printf "\033[1;33m[WARN]\033[0m %s\n" "$*"; }
error() { printf "\033[1;31m[ERR ]\033[0m %s\n" "$*" >&2; }

cd "$(dirname "$0")"

info "Setup local - iniciando"

# copy .env if missing
if [[ ! -f .env && -f .env.example ]]; then
  info "Copiando .env.example -> .env"
  cp .env.example .env
else
  info ".env já existe"
fi

# check php
if ! command -v php >/dev/null 2>&1; then
  error "php não encontrado no PATH. Instale PHP antes de continuar."
  exit 1
fi

# ensure composer
if ! command -v composer >/dev/null 2>&1; then
  info "composer não encontrado; instalando composer globalmente (requer permissão)..."
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
  if ! command -v composer >/dev/null 2>&1; then
    warn "Não foi possível instalar composer em /usr/local/bin. Tente instalar manualmente e reexecute o script."
  fi
fi

info "Instalando dependências PHP (composer)..."
composer install --no-interaction --prefer-dist --optimize-autoloader

info "Gerando APP_KEY (se necessário)"
php artisan key:generate --force || true

# JS toolchain
if [[ -f package.json ]]; then
  if ! command -v npm >/dev/null 2>&1 || ! command -v node >/dev/null 2>&1; then
    error "node/npm não encontrados. Instale Node.js antes de continuar."
    exit 1
  fi
  info "Instalando dependências JS..."
  if [[ -f package-lock.json ]]; then
    npm ci --no-audit --no-fund
  else
    npm install --no-audit --no-fund
  fi
  info "Buildando assets (npm run build)..."
  npm run build || warn "npm run build falhou; verifique scripts em package.json"
else
  info "Nenhum package.json encontrado, pulando passo JS."
fi

# storage link
info "Criando storage:link se necessário..."
php artisan storage:link || true

# DB sqlite file if needed
DB_CONN=$(grep -E '^DB_CONNECTION=' .env | cut -d= -f2- | tr -d '"' || echo "pgsql")
if [[ "$DB_CONN" == "sqlite" ]]; then
  mkdir -p database
  if [[ ! -f database/database.sqlite ]]; then
    info "Criando database/database.sqlite..."
    touch database/database.sqlite
  else
    info "database/database.sqlite já existe."
  fi
fi

# migrations and seed
info "Executando migrações..."
php artisan migrate --force
info "Rodando seeders (se existirem)..."
php artisan db:seed --force || true

info "Limpando caches e otimizando"
php artisan optimize:clear || true
php artisan optimize || true

info "Setup local finalizado."
printf "\nAcesse a aplicação em: %s\n\n" "${APP_URL:-http://localhost:8080}"
info "Setup concluído com sucesso."
echo "Acesse o app em: ${APP_URL:-http://localhost:8080}"
