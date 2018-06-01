<?php

class UserStory1CliModeTest extends \PHPUnit\Framework\TestCase
{
    public function testScenario1()
    {
        $expect = <<<JSON
{
    "inventory": [
        {
            "genre": "musical",
            "shows": [
                {
                    "title": "Cats",
                    "tickets left": 200,
                    "tickets available": 0,
                    "status": "sale not started"
                }
            ]
        },
        {
            "genre": "comedy",
            "shows": [
                {
                    "title": "Comedy of Errors",
                    "tickets left": 200,
                    "tickets available": 0,
                    "status": "sale not started"
                }
            ]
        }
    ]
}
JSON;
        $result = `php ./src/index.php showsTest.csv 2017-01-01 2017-07-01`;
        $this->assertSame($expect, $result);
    }

    public function testScenario2()
    {
        $expect = <<<JSON
{
    "inventory": [
        {
            "genre": "musical",
            "shows": [
                {
                    "title": "Cats",
                    "tickets left": 50,
                    "tickets available": 5,
                    "status": "open for sale"
                }
            ]
        },
        {
            "genre": "comedy",
            "shows": [
                {
                    "title": "Comedy of Errors",
                    "tickets left": 100,
                    "tickets available": 10,
                    "status": "open for sale"
                }
            ]
        },
        {
            "genre": "drama",
            "shows": [
                {
                    "title": "Everyman",
                    "tickets left": 100,
                    "tickets available": 10,
                    "status": "open for sale"
                }
            ]
        }
    ]
}
JSON;
        $result = `php ./src/index.php showsTest.csv 2017-08-01 2017-08-15`;
        $this->assertSame($expect, $result);
    }
}
