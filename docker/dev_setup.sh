#!/usr/bin/env sh

# shellcheck disable=SC3054
# shellcheck disable=SC3028
if [ "${BASH_SOURCE[0]}" = "" ]; then
  _DEV_S_SELF_DIR="$(cd -- "$(dirname -- "$0")" >/dev/null 2>&1 ||
  exit 1; pwd -P )"
else
  # shellcheck disable=SC3054
  # shellcheck disable=SC3028
  _DEV_S_SELF_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")">/dev/null 2>&1||
  exit 1; pwd -P )"
fi
cd "${_DEV_S_SELF_DIR}" || exit 1

_DEV_S_DB_FOUND="false"
if [ -d "${_DEV_S_SELF_DIR}/.run/mysql/c2dl" ]; then
  _DEV_S_DB_FOUND="true"
else
  printf "Database not found\n" >&2
fi

if which docker; then
  if docker --version > /dev/null; then
    _DEV_S_C_TOOL="docker"
  fi
elif which podman; then
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

"${_CONTAINER_TOOL}" compose up -d --wait --build

run_c_command()
{
  "${_CONTAINER_TOOL}" exec \
  -it "${DEV_S_PHP_CONTAINER_NAME:-"c2dl-php"}" sh -c "${1}"
}

if [ "${_DEV_S_ENV_INIT}" = "false" ]; then
  run_c_command "php artisan key:generate"
fi

if [ "${_DEV_S_DB_FOUND}" = "false" ]; then
  dialog --stdout --title "Seed database" \
   --backtitle "Seed database" \
   --yesno "Do you want to seed the database?" 7 60
  _DEV_S_SEED_CHOICE=$?
  clear
else
  _DEV_S_SEED_CHOICE=1
fi

if [ "${_DEV_S_SEED_CHOICE}" -eq "0" ]; then
  printf "Seed database\n"
  run_c_command "php artisan migrate --seed"
else
  printf "Seed database skipped\n"
  run_c_command "php artisan migrate"
fi
