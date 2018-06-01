<?php

namespace TC\Otravo\Show\Entity;

use TC\Otravo\Exception\InvalidArgumentException;
use TC\Otravo\Show\ShowManager;

class ShowFactory
{
    const MAP_TYPES = [
        'drama' => ShowInterface::TYPE_DRAMA,
        'comedy' => ShowInterface::TYPE_COMEDY,
        'musical' => ShowInterface::TYPE_MUSICAL,
    ];

    const MAP_TYPE_TO_CLASS = [
        ShowInterface::TYPE_DRAMA => DramaShow::class,
        ShowInterface::TYPE_COMEDY => ComedyShow::class,
        ShowInterface::TYPE_MUSICAL => MusicalShow::class,
    ];

    /**
     * @param string $title
     * @param string $date
     * @param string $type
     * @return ShowInterface
     * @throws InvalidArgumentException
     */
    public static function create(string $title, string $date, string $type): ShowInterface
    {
        $DateBeg = new \DateTime($date);
        $DateEnd = new \DateTime($date);
        $DateEnd->add(new \DateInterval('P' . (ShowManager::SHOW_DAYS_COUNT - 1) . 'D'));

        if (!$showType = self::getShowType($type)) {
            throw new InvalidArgumentException("Wrong type: {$type}");
        }

        if (!$class = self::getClassByType($showType)) {
            throw new InvalidArgumentException("Class for type {$showType} does not exist");
        }

        $Show = new $class($title, $DateBeg, $DateEnd);
        return $Show;
    }

    /**
     * @param string $type
     * @return int|null
     */
    public static function getShowType(string $type)
    {
        return self::MAP_TYPES[strtolower($type)] ?? null;
    }

    /**
     * @param string $type
     * @return string|null
     */
    protected static function getClassByType(string $type)
    {
        return self::MAP_TYPE_TO_CLASS[$type] ?? null;
    }
}
