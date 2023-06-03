#!/usr/bin/env bash

echo " _          _       _            _         _            _     _      _      "
echo "/\ \    _ / /\     /\ \         /\ \      /\ \         /\ \ /_/\    /\ \    "
echo "\ \ \  /_/ / /    /  \ \       /  \ \     \_\ \       /  \ \\ \ \   \ \_\   "
echo " \ \ \ \___\/    / /\ \ \     / /\ \ \    /\__ \     / /\ \ \\ \ \__/ / /   "
echo " / / /  \ \ \   / / /\ \ \   / / /\ \_\  / /_ \ \   / / /\ \_\\ \__ \/_/    "
echo " \ \ \   \_\ \ / / /  \ \_\ / / /_/ / / / / /\ \ \ / /_/_ \/_/ \/_/\__/\    "
echo "  \ \ \  / / // / /   / / // / /__\/ / / / /  \/_// /____/\     _/\/__\ \   "
echo "   \ \ \/ / // / /   / / // / /_____/ / / /      / /\____\/    / _/_/\ \ \  "
echo "    \ \ \/ // / /___/ / // / /\ \ \  / / /      / / /______   / / /   \ \ \ "
echo "     \ \  // / /____\/ // / /  \ \ \/_/ /      / / /_______\ / / /    /_/ / "
echo "      \_\/ \/_________/ \/_/    \_\/\_\/       \/__________/ \/_/     \_\/  "

composer install -n

php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
php bin/console app:create-user admin

exec "$@"