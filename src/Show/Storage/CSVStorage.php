<?php

namespace TC\Otravo\Show\Storage;

use TC\Otravo\Show\Entity\ShowFactory;
use TC\Otravo\Show\Storage\Exception\StorageException;

class CSVStorage implements StorageInterface
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var array|null
     */
    protected $data;

    public function __construct(string $filename)
    {
        if (!defined('DIR_RES')) {
            throw new StorageException('Const DIR_RES is not defined');
        }
        $this->filename = realpath(DIR_RES . basename($filename));
        if (!$this->filename) {
            throw new StorageException('Wrong path to file');
        }
    }

    /**
     * @return array
     */
    protected function readFileLines(): array
    {
        if (!file_exists($this->filename)) {
            throw new StorageException("Cant find file: {$this->filename}");
        }

        return file($this->filename);
    }

    /**
     * @return array
     * @throws StorageException
     */
    protected function getData(): array
    {
        if ($this->data) {
            return $this->data;
        }

        $csv = [];
        foreach ($this->readFileLines() as $line) {
            if (!$line = trim($line)) {
                continue;
            }
            $csv[] = array_map("trim", str_getcsv($line));
        }
        if (!$csv) {
            throw new StorageException("Cant load data from file: {$this->filename}");
        }

        return $this->data = $csv;
    }

    /**
     * @inheritdoc
     */
    public function getAll(\DateTime $DateShow): array
    {
        $shows = [];
        foreach ($this->getData() as $show) {
            // Because, we do not use DB
            $Show = ShowFactory::create(...$show);
            if ($Show->getDateBeg()->getTimestamp() > $DateShow->getTimestamp()
                || $Show->getDateEnd()->getTimestamp() < $DateShow->getTimestamp()) {
                // Skip show if it does not perform on show date
                continue;
            }
            $shows[] = $Show;
        }
        return $shows;
    }
}
