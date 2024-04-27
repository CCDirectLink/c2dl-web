cd "$( dirname "$0" )" || return 1

container_tool="_missing"

if [[ $(which docker) && $(docker --version) ]]; then
  echo "Docker found"
  container_tool="docker"
else
  echo "Docker missing but required"
  return 1
fi

$container_tool compose down
done=$?
if [ $done -eq 0 ]; then
  echo "Docker compose -> down"
fi

echo "Docker image cleanup"

$container_tool image rm docker-php 2> /dev/null
done=$?
if [ $done -eq 0 ]; then
  echo "image removed: docker-php"
fi

$container_tool image rm c2dl-php 2> /dev/null
done=$?
if [ $done -eq 0 ]; then
  echo "image removed: c2dl-php"
fi

$container_tool image rm mysql:5.7.28 2> /dev/null
done=$?
if [ $done -eq 0 ]; then
  echo "image removed: mysql:5.7.28"
fi

$container_tool image rm composer/composer:2.7.4 2> /dev/null
done=$?
if [ $done -eq 0 ]; then
  echo "image removed: composer/composer:2.7.4"
fi

$container_tool image rm httpd:2.4 2> /dev/null
done=$?
if [ $done -eq 0 ]; then
  echo "image removed: httpd:2.4"
fi

$container_tool image rm node:current-bookworm-slim 2> /dev/null
done=$?
if [ $done -eq 0 ]; then
  echo "image removed: node:current-bookworm-slim"
fi

echo "Prune Docker builder cache"
$container_tool builder prune -f
done=$?
if [ $done -eq 0 ]; then
  echo "builder cache pruned"
fi

if [ -d ../src/c2dl/node_modules ]; then
  rm -r ../src/c2dl/node_modules
  echo "Assets: Node modules removed"
fi

if [ -d ../src/c2dl/public/build ]; then
  rm -r ../src/c2dl/public/build
  echo "Assets: Asset builds removed"
fi

if [ -d ../src/c2dl/vendor ]; then
  rm -r ../src/c2dl/vendor
  echo "Composer: vendors removed"
fi

if [ -d ../tools/svgtofont/node_modules ]; then
  rm -r ../tools/svgtofont/node_modules
  echo "Tooling: Node modules removed (svg to font)"
fi

if [ -d .run/logs ]; then
  rm -r .run/logs
  echo "Logs: Docker logs removed"
fi

if [ -d .run/mysql ]; then
  dialog --stdout --title "Database removal" \
     --backtitle "Database removal" \
     --yesno "Do you want to remove the database content?" 7 60
  db_remove=$?
  clear
else
  db_remove=1
fi

if [ $db_remove -eq 0 ]; then
  rm -r .run/mysql
  echo "Database removed"
fi
