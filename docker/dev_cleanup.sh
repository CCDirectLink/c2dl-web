#!/usr/bin/env sh

# shellcheck disable=SC3054
# shellcheck disable=SC3028
if [ "${BASH_SOURCE[0]}" = "" ]; then
  _DEV_C_SELF_DIR="$(cd -- "$(dirname -- "$0")" >/dev/null 2>&1 ||
  exit 1; pwd -P )"
else
  # shellcheck disable=SC3054
  # shellcheck disable=SC3028
  _DEV_C_SELF_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")">/dev/null 2>&1||
  exit 1; pwd -P )"
fi
cd "${_DEV_C_SELF_DIR}" || exit 1

if which docker > /dev/null; then
  if docker compose ls > /dev/null 2> /dev/null; then
    _DEV_C_C_TOOL="docker"
  fi
elif which podman > /dev/null; then
  if podman compose ls > /dev/null 2> /dev/null; then
    _DEV_C_C_TOOL="podman"
  fi
fi

if [ -z "${_DEV_C_C_TOOL}" ]; then
  printf "No running container environment with compose\n" >&2
  printf "Requires docker compose or podman compose\n" >&2
  exit 1
fi

if "${_DEV_C_C_TOOL}" compose down > /dev/null; then
  printf "Compose down\n"
fi

remove_image()
{
  if "${_DEV_C_C_TOOL}" image rm "${1}" 2> /dev/null; then
    if [ -n "${2}" ]; then
      _DEV_C_NOTE=" (${2})"
    fi
    printf "Image removed: %s%s\n" "${1}" "${_DEV_C_NOTE}"
    unset _DEV_C_NOTE
  fi
}

remove_image "docker-php"
remove_image "c2dl-php"
remove_image "docker-c2dl-sys"
remove_image "mysql:5.7.28" "old mysql"
remove_image "mariadb:10.5"
remove_image "mariadb:10.11"
remove_image "composer/composer:2.7.4"
remove_image "httpd:2.4"
remove_image "node:current-bookworm-slim"

if "${_DEV_C_C_TOOL}" builder prune -f > /dev/null; then
  printf "Builder cache pruned\n"
fi

remove_folder()
{
  if [ -d "${1}" ]; then
    rm -r "${1}"
    printf "%s: %s removed\n" "${2}" "${3}"
  fi
}

_DEV_C_C2DL_DIR="${_DEV_C_SELF_DIR}/../src/c2dl"
_DEV_C_RUN_DIR="${_DEV_C_SELF_DIR}/.run"

remove_folder "${_DEV_C_C2DL_DIR}/node_modules" "Assets" "Node modules"
remove_folder "${_DEV_C_C2DL_DIR}/build" "Assets" "Asset builds"
remove_folder "${_DEV_C_C2DL_DIR}/vendor" "Composer" "Vendors"
remove_folder "${_DEV_C_RUN_DIR}/logs" "Logs" "Docker logs"

_DEV_C_RM_DB="false"
if [ -d "${_DEV_C_RUN_DIR}/mysql" ]; then
  if which read > /dev/null; then
    if [ -z "${DEV_C_RM_DB}" ]; then
      printf "Remove database [y/n]: "
      read -r _DEV_C_RM_DB_INPUT
    else
      _DEV_C_RM_DB="${DEV_C_RM_DB}"
    fi
  fi
  if [ "${_DEV_C_RM_DB_INPUT}" = "y" ]; then
    _DEV_C_RM_DB="true"
  elif [ "${_DEV_C_RM_DB_INPUT}" = "yes" ]; then
    _DEV_C_RM_DB="true"
  fi
  unset _DEV_C_RM_DB_INPUT
fi

if [ "${_DEV_C_RM_DB}" = "true" ]; then
  remove_folder "${_DEV_C_RUN_DIR}/mysql" "Database" "Database"
fi
