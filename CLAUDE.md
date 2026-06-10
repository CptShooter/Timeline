# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A single-page PHP app ("Shooter's Timeline") that renders upcoming video-game premieres on a [vis.js](https://visjs.org/) timeline. PHP reads a CSV of games, filters by date window, and serves JSON; the browser draws the timeline. No database, no framework — PHP 8.1 + a CSV file.

Almost all real-world commits are data edits to `data/games.csv` (adding/correcting premieres), not code changes.

## Run locally

```bash
composer install          # generates vendor/autoload.php (PSR-4 autoload only, no deps)
docker compose up         # nginx on :80 (server_name timeline.local) + php-fpm 8.1
```

nginx serves `public/` as docroot. Visit the host and the page fetches `data.php` for the timeline JSON. There are no build, lint, or test commands — `composer install` exists only to produce the autoloader.

## Architecture

Request flow:

1. `public/index.php` — HTML shell. Inline JS `XMLHttpRequest`s `data.php`, parses the JSON, and configures the `vis.Timeline` (item template renders title, sub_title, clickable image linking to the trailer, and the date).
2. `public/data.php` — JSON endpoint. Builds a `Timeline\Data`, then chains:
   `removeGamesOlderThan(15, 150)->sortGamesByDate()->buildJson()->getGamesToJson()`.
3. `src/Data.php` — loads `../data/games.csv` in the constructor into `Timeline\Game` objects, then the fluent pipeline filters/sorts/serializes them.
4. `src/Game.php` — plain data object (getters/setters) for one premiere.

The `15, 150` arguments to `removeGamesOlderThan` mean: drop games more than 15 days in the past, and more than 150 days in the future. This is the visible time window — change it in `data.php`.

`sortGamesByDate()` keys games by Unix timestamp; on a date collision it calls `Game::addRandomTime()` to nudge the timestamp so neither entry is lost before `ksort`.

## Data format

`data/games.csv` — no header row, one premiere per line, columns:

```
name, sub_title, date (DD.MM.YYYY), image_url, trailer_url
```

`date` is parsed with `new \DateTime($data[2])`. `data/old.csv` is an archive of past premieres, not read by the app.

## Notes

- `composer.json` declares only `php >=8.1` and `ext-json` — no third-party libraries. `vis-timeline` is vendored directly under `public/js` and `public/css`.
- `vendor/` is gitignored; the CSV data files are the tracked, frequently-edited content.
