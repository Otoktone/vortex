# Project Vortex

Vortex is a content aggregation application that keeps you up to date with news and articles related to the world of tech.

It centralizes streams from various reliable sources such as news websites, blogs, and online publications. The application provides real-time updates to keep you informed about the latest IT developments. You can customize your news feed based on your interests and preferences, and even bookmark articles to read later. With a modern UI and multi-platform compatibility, Vortex offers an intuitive tech monitoring experience whether you're using it on desktop, tablet, or mobile.

Explore the world of technology and new advancements with Vortex!

## Tech Stack

Symfony 5.4
End of bug fixes: November 2024
End of security fixes: November 2025

PHP 8.1
Active Support Until : 25 Nov 2023
Security Support Until : 25 Nov 2024

Webpack 1.16

Twig

MySQL8

Docker

## Installation

Install Vortex with Docker :

```bash
  docker-compose build
```
Run Vortex with Docker :

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

Generate articles from RSS feeds :

```bash
  php bin/console app:generate-articles
```

Clean articles older than 3 months if they are not bookmarked by users :

```bash
  php bin/console app:clean-articles
```

## Potential errors

Expected to find class "App\Command\GenerateArticles" :

```bash
  composer dump-autoload
```

## Authors

- [@otoktone](https://github.com/Otoktone)

## Acknowledgements

- [FeedIo Documentation](https://github.com/alexdebril/feed-io/blob/main/doc/specifications-support.md)
- [Readme Generator](https://readme.so/)
- [Choose licence](https://choosealicense.com/licenses/)

## Badges

[![GPLv3 License](https://img.shields.io/badge/License-GPL%20v3-yellow.svg)](https://opensource.org/licenses/)
