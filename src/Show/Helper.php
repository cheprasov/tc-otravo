<?php

namespace TC\Otravo\Show;

class Helper
{
    /**
     * @param string $filename
     * @param string $dateQuery
     * @param string $dateShow
     * @param bool $withPrice
     * @return mixed
     */
    public static function getResult(string $filename = null, string $dateQuery = null, string $dateShow, bool $withPrice): array
    {
        if (!$filename) {
            $filename = 'shows.csv';
        }
        $DateQuery = new \DateTime($dateQuery ?: date('Y-m-d'));
        $DateShow = new \DateTime($dateShow);
        $ShowManager = ShowManagerFactory::create($filename, $withPrice);
        $Inventory = $ShowManager->getInventory($DateQuery, $DateShow);
        return $Inventory->toArray();
    }
}
