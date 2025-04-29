#!/usr/bin/env sh

_DEV_S_SELF_DIR="$(cd -- "$(dirname -- "$0")" >/dev/null 2>&1 || exit 1; pwd -P )"
cd "${_DEV_S_SELF_DIR}" || exit 1

_DEV_S_DB_FOUND="false"
if [ -d "${_DEV_S_SELF_DIR}/.run/mysql/c2dl" ]; then
  _DEV_S_DB_FOUND="true"
else
  printf "Database not found\n" >&2
fi

if which docker > /dev/null; then
  if docker --version > /dev/null; then
    _DEV_S_C_TOOL="docker"
  fi
elif which podman > /dev/null; then
  if podman --version > /dev/null; then
    _DEV_S_C_TOOL="podman"
  fi
else
  printf "No container environment found\nDocker or podman required\n" >&2
  exit 1
fi

_DEV_S_CONF_ENV_FILE="${_DEV_S_SELF_DIR}/conf/env/dev_env"
_DEV_S_LARA_ENV_FILE="${_DEV_S_SELF_DIR}/../src/c2dl/.env"

_DEV_S_ENV_INIT="false"
if [ -f "${_DEV_S_LARA_ENV_FILE}" ]; then
  _DEV_S_ENV_INIT="true"
else
  cp "${_DEV_S_CONF_ENV_FILE}" "${_DEV_S_LARA_ENV_FILE}"
fi

"${_DEV_S_C_TOOL}" compose up -d --wait --build

run_c_command()
{
  "${_DEV_S_C_TOOL}" exec \
  -it "${DEV_S_PHP_CONTAINER_NAME:-"c2dl-php"}" sh -c "${1}"
}

run_c_command "composer install"
run_c_command "bun install && bun run build"

if [ "${_DEV_S_ENV_INIT}" = "false" ]; then
  run_c_command "php artisan key:generate"
fi

if [ "${_DEV_S_DB_FOUND}" = "true" ]; then
  _DEV_S_SEED_CHOICE="false"
elif [ -z "${DEV_S_SEED_CHOICE}" ]; then
  printf "Seed database [y/n]: "
  read -r _DEV_S_SEED_INPUT
  if [ "${_DEV_S_SEED_INPUT}" = "y" ]; then
    _DEV_S_SEED_CHOICE="true"
  else
    _DEV_S_SEED_CHOICE="false"
  fi
else
  _DEV_S_SEED_CHOICE="$DEV_S_SEED_CHOICE"
fi

if [ "${_DEV_S_SEED_CHOICE}" = "true" ]; then
  printf "Seed database\n"
  run_c_command "php artisan migrate --seed"
else
  printf "Seed database skipped\n"
  run_c_command "php artisan migrate"
fi
