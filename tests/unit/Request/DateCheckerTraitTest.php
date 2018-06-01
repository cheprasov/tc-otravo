<?php

use \TC\Otravo\Request\DateCheckerTrait;

class DateCheckerTraitTest extends \PHPUnit\Framework\TestCase
{
    public function providerIsCorrectDate()
    {
        return [
            'line_' . __LINE__ => [
                'date' => '2018-10-10',
                'expect' => true,
            ],
            'line_' . __LINE__ => [
                'date' => '2018-01-01',
                'expect' => true,
            ],
            'line_' . __LINE__ => [
                'date' => '2018-01-32',
                'expect' => false,
            ],
            'line_' . __LINE__ => [
                'date' => '2018-1-10',
                'expect' => false,
            ],
            'line_' . __LINE__ => [
                'date' => '2018-01-1',
                'expect' => false,
            ],
            'line_' . __LINE__ => [
                'date' => '2018-02-30',
                'expect' => false,
            ],
            'line_' . __LINE__ => [
                'date' => '2018',
                'expect' => false,
            ],
            'line_' . __LINE__ => [
                'date' => '2018-02',
                'expect' => false,
            ],
        ];
    }

    /**
     * @see \TC\Otravo\Request\DateCheckerTrait::isCorrectDate
     * @dataProvider providerIsCorrectDate
     */
    public function testIsCorrectDate($date, $expect)
    {
        $Class = new class {
            use DateCheckerTrait;

            public function getResult($date)
            {
                return $this->isCorrectDate($date);
            }
        };

        $this->assertSame($expect, $Class->getResult($date));
    }
}
