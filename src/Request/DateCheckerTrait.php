<?php

namespace TC\Otravo\Request;

trait DateCheckerTrait
{
    /**
     * @param string $date
     * @return bool
     */
    protected function isCorrectDate(string $date): bool
    {
        if (!preg_match('/^(?P<year>\d{4})-(?P<month>\d{2})-(?P<date>\d{2})$/', $date, $m)) {
            return false;
        }
        return checkdate($m['month'], $m['date'], $m['year']);
    }
}
