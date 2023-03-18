#!/bin/bash

if [[ $1 == "start" ]]; then
  # Start docker-compose services
  docker-compose up -d

  # Display URLs
  echo "Admin URL: http://$CONTAINER_IP/admin"
  echo "Front URL: http://localhost:80"
  echo "PhpMyAdmin URL: http://localhost:8081"
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
          # PhpMyAdmin : http://localhost:8081    #
          #                                       #
          #########################################
          "
else
  echo "Usage: ./run.sh [start|restart]"
fi
