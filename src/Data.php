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
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $game = new Game();
                $game->setName($data[0]);
                $game->setDate(new \DateTime($data[1]));
                $game->setDescription($data[2]);
                $game->setImg($data[3]);
                $game->setTrailer($data[4]);
                $this->games[] = $game;
                $num = count($data);
            }
            fclose($handle);
        }
    }

    public function sortGamesByDate() : Data
    {
        $sorted = [];
        /** @var Game $game */
        foreach($this->games as $game)
        {
            $timestamp = $game->getDate()->getTimestamp();
            $sorted[$timestamp] = $game;
        }
        ksort($sorted);
        $this->games = $sorted;
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
                'content' => $game->getDescription(),
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