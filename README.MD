# Project Vortex

Vortex is a web application about flux aggregation.
You can add flux url and generate articles from it.

## Installation

Install vortex with Docker :

```bash
  docker-compose build
```
Run my-project with Docker :

```bash
  docker-compose up
```

## Custom commands

Connect to container first

```bash
  docker exec -ti vortex bash
```

Create admin user :

```bash
  php bin/console app:create-user
```

Load fixtures :

```bash
  php bin/console doctrine:fixtures:load
```

Create admin user :

```bash
  php bin/console app:generate-articles
```

Clean articles :

```bash
  php bin/console app:clean-articles
```

## Tech Stack

**Client:** Twig

**Server:** Symfony, Node

## Authors

- [@otoktone](https://github.com/Otoktone)

## Acknowledgements

- [Readme Generator](https://readme.so/)
- [Choose licence](https://choosealicense.com/licenses/)

## Badges

[![GPLv3 License](https://img.shields.io/badge/License-GPL%20v3-yellow.svg)](https://opensource.org/licenses/)
