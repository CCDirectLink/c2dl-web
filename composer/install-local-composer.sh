#!/usr/bin/env sh

install_local_composer() {
  INSTALLER_HASH="f3108f64b4e1c1ce6eb462b159956461592b3e3e"
  EXPECTED_CHECKSUM="dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6"

  INSTALLER_URL="https://raw.githubusercontent.com/composer/getcomposer.org/$INSTALLER_HASH/web/installer"
  CURRENT_CHECKSUM="$(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");')"

  php -r "copy('$INSTALLER_URL', 'composer-setup.php');"
  ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

  if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]; then
    printf "Checksum not matching\n" >&2
    rm composer-setup.php
    return 1
  fi
  if [ "$EXPECTED_CHECKSUM" != "$CURRENT_CHECKSUM" ]; then
    printf "WARN: New installer script available -- currently using %s\n" "$INSTALLER_HASH" >&2
  fi

  if php composer-setup.php --quiet; then
    :
  else
    printf "Composer setup failed\n" >&2
    rm composer-setup.php
    return 1
  fi

  rm composer-setup.php
}

if [ -f "composer.phar" ]; then
  :
else
  printf "Install local composer\n"
  install_local_composer
fi

