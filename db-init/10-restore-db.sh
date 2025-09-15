#!/usr/bin/env bash
set -euo pipefail

DB="${POSTGRES_DB:-postgres}"
USER="${POSTGRES_USER:-postgres}"
PASS="${POSTGRES_PASSWORD:-}"

export PGPASSWORD="${PASS}"

DUMP="/docker-entrypoint-initdb.d/seed.dump"
SQL="/docker-entrypoint-initdb.d/seed.sql"

echo "[initdb] Restaurando base '${DB}' se existir dump/sql..."

if [ -f "${DUMP}" ]; then
  echo "[initdb] Encontrado ${DUMP}. Executando pg_restore..."
  pg_restore -U "${USER}" -d "${DB}" --clean --if-exists --no-owner --no-privileges "${DUMP}"
  echo "[initdb] pg_restore concluído."
elif [ -f "${SQL}" ]; then
  echo "[initdb] Encontrado ${SQL}. Executando psql..."
  psql -v ON_ERROR_STOP=1 -U "${USER}" -d "${DB}" -f "${SQL}"
  echo "[initdb] psql concluído."
else
  echo "[initdb] Nenhum seed.dump ou seed.sql encontrado. Pulando restauração."
fi
