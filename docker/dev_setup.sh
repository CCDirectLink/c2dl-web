#!/usr/bin/env sh

# shellcheck disable=SC3054
# shellcheck disable=SC3028
if [ "${BASH_SOURCE[0]}" = "" ]; then
    _SELF_DIR="$(cd -- "$(dirname -- "$0")" >/dev/null 2>&1 ||
    exit 1; pwd -P )"
else
  # shellcheck disable=SC3054
  # shellcheck disable=SC3028
  _SELF_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")">/dev/null 2>&1||
  exit 1; pwd -P )"
fi
cd "${_SELF_DIR}" || exit 1

_BLANK_DEV_ENV=0
_NO_DB=0
_CONTAINER_TOOL="_MISSING"

_PHP_CONTAINER_NAME="c2dl-php"

printf "Check for database..."
if [ -d ".run/mysql/c2dl" ]; then
    printf " found"
else
  printf " not found"
  _NO_DB=1
fi
printf "\n"

printf "Check for container environment..."
if which docker; then
    printf " Docker found"
    _CONTAINER_TOOL="docker"
elif which podman; then
    printf " Podman found"
    _CONTAINER_TOOL="podman"
else
    printf " No tool found\nDocker or podman missing but required\n"
    return 1
fi
printf "\n"

_DEV_ENV_FILE="${_SELF_DIR}/conf/env/dev_env"
_ENV_FILE="${_SELF_DIR}/../src/c2dl/.env"

if [ -f "${_ENV_FILE}" ]; then
  printf "Copy skipped: .env file found in c2dl directory\n"
else
  printf "No .env file found in c2dl directory\n"
  printf "Copy %s to %s\n" "${_DEV_ENV_FILE}" "${_ENV_FILE}"
  cp "${_DEV_ENV_FILE}" "${_ENV_FILE}"
  _BLANK_DEV_ENV=1
fi

"${_CONTAINER_TOOL}" compose up -d --wait --build

if [ "${_BLANK_DEV_ENV}" -eq "1" ]; then
  echo "Create key for blank .env"
  "${_CONTAINER_TOOL}" exec \
  -it "${_PHP_CONTAINER_NAME}" sh -c "php artisan key:generate"
fi

if [ "${_NO_DB}" -eq "1" ]; then
  dialog --stdout --title "Seed database" \
   --backtitle "Seed database" \
   --yesno "Do you want to seed the database?" 7 60
  _SEED_CHOICE=$?
  clear
else
  _SEED_CHOICE=1
fi

if [ "${_SEED_CHOICE}" -eq "0" ]; then
  echo "Seed database"
  "${_CONTAINER_TOOL}" exec \
  -it "${_PHP_CONTAINER_NAME}" sh -c "php artisan migrate --seed"
else
  echo "Seed database skipped"
  "${_CONTAINER_TOOL}" exec \
  -it "${_PHP_CONTAINER_NAME}" sh -c "php artisan migrate"
fi
