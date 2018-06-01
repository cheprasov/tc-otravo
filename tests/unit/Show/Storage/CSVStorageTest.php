<?php

use TC\Otravo\Show\Storage\Exception\StorageException;
use TC\Otravo\Show\Storage\CSVStorage;
use TC\Otravo\Show\Entity\ShowInterface;

class CSVStorageTest extends \PHPUnit\Framework\TestCase
{
    public function providerConstructException()
    {
        return [
            'line_' . __LINE__ => [
                'DIR_RES' => null,
                'filename' => 'test.csv',
            ],
            'line_' . __LINE__ => [
                'DIR_RES' => '/foo/bar/',
                'filename' => 'test.csv',
            ],
            'line_' . __LINE__ => [
                'DIR_RES' => '/foo/bar/',
                'filename' => '/etc/nginx/nginx.conf',
            ],
        ];
    }

    /**
     * @runInSeparateProcess
     * @see \TC\Otravo\Show\Storage\CSVStorage::__construct
     * @dataProvider providerConstructException
     */
    public function testConstructException($DIR_RES, $filename)
    {
        if (!defined('DIR_RES') && $DIR_RES) {
            define('DIR_RES', $DIR_RES);
        }

        $this->expectException(StorageException::class);
        $Storage = new CSVStorage($filename);
    }

    public function providerConstruct()
    {
        return [
            'line_' . __LINE__ => [
                'filename' => 'shows.csv',
                'expect' => 'shows.csv',
            ],
            'line_' . __LINE__ => [
                'filename' => '/../../shows.csv',
                'expect' => 'shows.csv',
            ],
        ];
    }

    /**
     * @runInSeparateProcess
     * @see \TC\Otravo\Show\Storage\CSVStorage::__construct
     * @dataProvider providerConstruct
     */
    public function testConstruct($filename, $expect)
    {
        define('DIR_RES', realpath(__DIR__ . '/../../../../res/') . '/');
        $Storage = new CSVStorage($filename);
        $Property = new ReflectionProperty(CSVStorage::class, 'filename');
        $Property->setAccessible(true);
        $file = $Property->getValue($Storage);

        $this->assertSame(DIR_RES . $expect, $file);
    }

    public function providerGetData()
    {
        return [
            'line_' . __LINE__ => [
                'lines' => [
                    'cats,2018-10-10,drama',
                    '',
                    'dogs,2018-10-11,comedy',
                    '',
                    'mice,2018-10-12,musical',
                ],
                'expect' => [
                    ['cats', '2018-10-10', 'drama'],
                    ['dogs', '2018-10-11', 'comedy'],
                    ['mice', '2018-10-12', 'musical'],
                ],
            ],
            'line_' . __LINE__ => [
                'lines' => [
                    '"  cats  ","2018-10-10","  drama  "' . "\r",
                    '"dogs and cats  ","2018-10-11","  comedy  "' . "\r",
                ],
                'expect' => [
                    ['cats', '2018-10-10', 'drama'],
                    ['dogs and cats', '2018-10-11', 'comedy'],
                ],
            ],
        ];
    }

    /**
     * @see \TC\Otravo\Show\Storage\CSVStorage::getData
     * @dataProvider providerGetData
     */
    public function testGetData($lines, $expect)
    {
        $StorageMock = $this->getMockBuilder(CSVStorage::class)
            ->disableOriginalConstructor()
            ->setMethods(['readFileLines'])
            ->getMock();

        $StorageMock->expects($this->once())
            ->method('readFileLines')
            ->willReturn($lines);

        $Method = new ReflectionMethod(CSVStorage::class, 'getData');
        $Method->setAccessible(true);
        $result = $Method->invoke($StorageMock);
        // second call for check that readFileLines calls once only
        $result = $Method->invoke($StorageMock);

        $this->assertSame($expect, $result);
    }

    public function providerGetAll()
    {
        $lines = [
            ['cats', '2016-01-01', 'drama'],
            ['dogs', '2017-01-01', 'comedy'],
            ['mice', '2018-01-01', 'musical'],
            ['deer', '2018-03-01', 'musical'],
        ];
        return [
            'line_' . __LINE__ => [
                'lines' => $lines,
                'date' => '2015-01-01',
                'expect' => [],
            ],
            'line_' . __LINE__ => [
                'lines' => $lines,
                'date' => '2016-01-01',
                'expect' => ['cats'],
            ],
            'line_' . __LINE__ => [
                'lines' => $lines,
                'date' => '2016-02-01',
                'expect' => ['cats'],
            ],
            'line_' . __LINE__ => [
                'lines' => $lines,
                'date' => '2017-02-01',
                'expect' => ['dogs'],
            ],
            'line_' . __LINE__ => [
                'lines' => $lines,
                'date' => '2018-01-01',
                'expect' => ['mice'],
            ],
            'line_' . __LINE__ => [
                'lines' => $lines,
                'date' => '2018-03-01',
                'expect' => ['mice', 'deer'],
            ],
            'line_' . __LINE__ => [
                'lines' => $lines,
                'date' => '2018-05-01',
                'expect' => ['deer'],
            ],
        ];
    }

    /**
     * @see \TC\Otravo\Show\Storage\CSVStorage::getAll
     * @dataProvider providerGetAll
     */
    public function testGetAll($lines, $date, $expect)
    {
        /** @var \PHPUnit\Framework\MockObject\MockObject|CSVStorage $StorageMock */
        $StorageMock = $this->getMockBuilder(CSVStorage::class)
            ->disableOriginalConstructor()
            ->setMethods(['getData'])
            ->getMock();

        $StorageMock->expects($this->once())
            ->method('getData')
            ->willReturn($lines);

        $result = $StorageMock->getAll(new \DateTime($date));
        $count = count($expect);
        $this->assertSame($count, count($expect));

        for ($i = 0; $i < $count; $i++) {
            /** @var ShowInterface $Show */
            $Show = $result[$i];
            $this->assertTrue($Show instanceof ShowInterface);
            $this->assertSame($expect[$i], $Show->getTitle());
        }
    }
}
