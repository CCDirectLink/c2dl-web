cd "$( dirname "$0" )" || return 1

blank_dev_env=0
no_db=0
container_tool="_missing"

if [ ! -d .run/mysql/c2dl ]; then
  echo "Check for database... not found"
  no_db=1
else
  echo "Check for database... found"
fi

if [[ $(which docker) && $(docker --version) ]]; then
  echo "Docker found"
  container_tool="docker"
else
  echo "Docker missing but required"
  return 1
fi

if [ ! -f ../src/c2dl/.env ]; then
  echo "No .env file found in c2dl directory - copy dev_env to c2dl/.env"
  cp conf/env/dev_env ../src/c2dl/.env
  blank_dev_env=1
else
  echo ".env file found in c2dl directory - skipped"
fi

$container_tool compose up -d --wait --build

if [ $blank_dev_env -eq 1 ]; then
  echo "Create key for blank .env"
  $container_tool exec -it c2dl-php sh -c "php artisan key:generate"
fi

if [ $no_db -eq 1 ]; then
  dialog --stdout --title "Seed database" \
   --backtitle "Seed database" \
   --yesno "Do you want to seed the database?" 7 60
  seed_choice=$?
  clear
else
  seed_choice=1
fi

if [ $seed_choice -eq 0 ]; then
  echo "Seed database"
  $container_tool exec -it c2dl-php sh -c "php artisan migrate --seed"
else
  echo "Seed database skipped"
  $container_tool exec -it c2dl-php sh -c "php artisan migrate"
fi
