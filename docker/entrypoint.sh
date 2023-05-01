#!/usr/bin/env bash

composer install -n

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

# bin/console doc:mig:mig --no-interaction
# bin/console doc:fix:load --no-interaction

exec "$@"