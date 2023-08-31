<?php

namespace Timeline;

class Game
{
    private string $name;
    private string $subName;
    private \DateTime $date;
    private string $img;
    private string $trailer;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSubName(): string
    {
        return $this->subName;
    }

    /**
     * @param string $subName
     */
    public function setSubName(string $subName): void
    {
        $this->subName = $subName;
    }


    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function addRandomTime(): \DateTime
    {
        $hoursToAdd = random_int(1,12);
        $minutesToAdd = random_int(1,59);
        $secondsToAdd = random_int(1,59);
        $this->date->add(new \DateInterval('PT'.$hoursToAdd.'H'.$minutesToAdd.'M'.$secondsToAdd.'S'));

        return $this->date;
    }

    /**
     * @return string
     */
    public function getImg(): string
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg(string $img): void
    {
        $this->img = $img;
    }

    /**
     * @return string
     */
    public function getTrailer(): string
    {
        return $this->trailer;
    }

    /**
     * @param string $trailer
     */
    public function setTrailer(string $trailer): void
    {
        $this->trailer = $trailer;
    }
}