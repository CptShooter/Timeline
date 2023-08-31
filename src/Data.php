<?php

namespace Timeline;

class Data
{
    private array $games = [];
    private string $filename = '../data/games.csv';
    private array $jsonGames = [];

    public function __construct()
    {
        $this->getCSV();
    }

    private function getCSV() : void
    {
        if (($handle = fopen($this->filename, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {
                $game = new Game();
                $game->setName($data[0]);
                $game->setSubName($data[1]);
                $game->setDate(new \DateTime($data[2]));
                $game->setImg($data[3]);
                $game->setTrailer($data[4]);
                $this->games[] = $game;
            }
            fclose($handle);
        }
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function sortGamesByDate() : Data
    {
        $sorted = [];
        /** @var Game $game */
        foreach($this->games as $game)
        {
            $timestamp = $game->getDate()->getTimestamp();
            if ( isset($sorted[$timestamp]) ){
                $timestamp = $game->addRandomTime()->getTimestamp();
            }
            $sorted[$timestamp] = $game;
        }
        ksort($sorted);
        $this->games = $sorted;
        return $this;
    }

    public function removeGamesOlderThan($daysBefore = 60, $daysAhead = 90) : self
    {
        $now = new \DateTime('now');
        /** @var Game $game */
        foreach($this->games as $key => $game)
        {
            if ($game->getDate() instanceof \DateTime) {
                $diff = $game->getDate()->diff($now);
                if ($diff->invert == 0 && $diff->days > $daysBefore) {
                    unset($this->games[$key]);
                }
                if ($diff->invert != 0 && $diff->days > $daysAhead) {
                    unset($this->games[$key]);
                }
            }
        }
        return $this;
    }

    public function buildJson(): Data
    {
        $id = 0;
        /** @var Game $game */
        foreach($this->games as $game)
        {

            $json = [
                'id' => $id,
                'title' => $game->getName(),
                'sub_title' => $game->getSubName(),
                'content' => $game->getName(),
                'img' => $game->getImg(),
                'link' => $game->getTrailer(),
                'start' => $game->getDate()->format('Y-m-d')
            ];
            $this->jsonGames[] = $json;
            $id++;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getGames() : array
    {
        return $this->games;
    }

    /**
     * @return string
     */
    public function getGamesToJson() : string
    {
        return json_encode($this->jsonGames, true);
    }
}