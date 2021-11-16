<?php
declare(strict_types=1);

class Species
{
    private string $speciesName;
    private int $speciesId;

    public static function createFromId(int $id):self
    {
        $req=MyPDO::getInstance()->prepare(<<<SQL
        SELECT *
        FROM Species
        WHERE speciesId=?
        SQL);

        $req->setFetchMode(PDO::FETCH_CLASS, Race::class);
        $req->execute([$id]);
        $return=$req->fetch();
        if(!$return)
        {
            throw new InvalidArgumentException("Id not not in DataBase.");
        }
        return $return;
    }

    /**
     * Retourne le nom de la race.
     * @return string
     */
    public function getSpeciesName() : string {
        return $this->speciesName;
    }

    /**
     * Retourne l'id de l'espèce de la race.
     * @return int
     */
    public function getSpeciesId() : int {
        return $this->speciesId;
    }


}