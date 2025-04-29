#!/usr/bin/env sh

create_bun_install() {
  EXPECTED_CHECKSUM="c61595cdd22a2f7e92c5be6cc2bd7ca817230de369136e027b7da57a124a10dde038a67ed6e5d995728a6d8189cb43d1"

  php -r "copy('https://bun.sh/install', 'bun-install-content.sh');"
  ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'bun-install-content.sh');")"

  if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]; then
    printf "Checksum not matching\n" >&2
    rm "bun-install-content.sh"
    return 1
  fi

  chmod +x "./bun-install-content.sh"
}

run_bun_install() {
  if ./bun-install-content.sh; then
    printf "Bun install failed\n" >&2
    return 1
  fi
}

if which bun > /dev/null; then
  :
else
  create_bun_install
  run_bun_install
  rm "bun-install-content.sh"
fi
