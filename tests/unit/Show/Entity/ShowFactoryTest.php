<?php

use TC\Otravo\Show\Entity\ShowFactory;
use TC\Otravo\Show\Entity\DramaShow;
use TC\Otravo\Show\Entity\ComedyShow;
use TC\Otravo\Show\Entity\MusicalShow;
use TC\Otravo\Show\Entity\ShowInterface;

class ShowFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function providerCreate()
    {
        return [
            'line_' . __LINE__ => [
                'title' => 'Cats',
                'date' => '2017-01-01',
                'type' => 'DRAMA',
                'expect' => [
                    'class' => DramaShow::class,
                    'type' => ShowInterface::TYPE_DRAMA,
                ],
            ],
            'line_' . __LINE__ => [
                'title' => 'Test',
                'date' => '2017-12-10',
                'type' => 'COMEDY',
                'expect' => [
                    'class' => ComedyShow::class,
                    'type' => ShowInterface::TYPE_COMEDY,
                ],
            ],
            'line_' . __LINE__ => [
                'title' => 'MusicalShow',
                'date' => '2017-06-06',
                'type' => 'MUSICAL',
                'expect' => [
                    'class' => MusicalShow::class,
                    'type' => ShowInterface::TYPE_MUSICAL,
                ],
            ],
            'line_' . __LINE__ => [
                'title' => 'Wrong Date',
                'date' => '2017',
                'type' => 'MUSICAL',
                'expect' => [
                    'error' => true,
                ],
            ],
            'line_' . __LINE__ => [
                'title' => 'Wrong Type',
                'date' => '2017-01-06',
                'type' => 'WRONG',
                'expect' => [
                    'error' => true,
                ],
            ],
        ];
    }

    /**
     * @see \TC\Otravo\Show\Entity\ShowFactory::create
     * @dataProvider providerCreate
     */
    public function testCreate($title, $date, $type, $expect)
    {
        try {
            $Show = ShowFactory::create($title, $date, $type);
            if (isset($expect['error'])) {
                $this->assertTrue(false, 'Expect exception');
            }
        } catch (\Exception $Ex) {
            $this->assertTrue($expect['error'] ?? false, true);
            return;
        }

        $this->assertTrue($Show instanceof ShowInterface);
        $this->assertSame($expect['class'], get_class($Show));

        $this->assertSame($title, $Show->getTitle());
        $this->assertSame($expect['type'], $Show->getType());

        $time = (new \DateTime($date))->getTimestamp();
        $this->assertSame($time, $Show->getDateBeg()->getTimestamp());
        $this->assertSame($time + 99 * 86400, $Show->getDateEnd()->getTimestamp());
    }
}
