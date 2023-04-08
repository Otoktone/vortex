#!/bin/bash

if [[ $1 == "start" ]]; then
  # Start docker-compose services
  docker-compose up -d

  # Display URLs
  echo -e "
          #########################################
          #                                       #
          #          VORTEX | PROJECT             #
          #                                       #
          #     Back : http://localhost/admin     #
          #     Front : http://localhost:80       #
          #  PhpMyAdmin : http://localhost:8081   #
          #                                       #
          #########################################
          "
elif [[ $1 == "restart" ]]; then
  # Restart docker-compose services
  docker-compose down
  docker-compose up -d

  # Display URLs
  echo -e "
          #########################################
          #                                       #
          #          VORTEX | PROJECT             #
          #                                       #
          #     Back : http://localhost/admin     #
          #     Front : http://localhost:80       #
          #  PhpMyAdmin : http://localhost:8081   #
          #                                       #
          #########################################
          "
elif [[ $1 == "stop" ]]; then
  # Stop docker-compose services
  docker-compose stop
else
  echo "Usage: ./run.sh [start|restart]"
fi
