# Otravo

## About me
Alexander Cheprasov
- email: acheprasov84@gmail.com
- phone: 07490 216907
- linkedin: https://uk.linkedin.com/in/alexandercheprasov/
- CV: https://cv.cheprasov.com/
- London, UK

## About JSquery test

Please see result of the test in file `JSquery_result.js`

How to run: `node ./JSquery_result.js`

## About Tickets4Safe test

Thanks for the test, it was good experience.

First of all, I want to notice that the phrase `Ticket sale starts 25 days before a show starts;` means that the show date is included to the period. (see explanation below).

For backend, I created structure where we can easy change a storage (for example, from CSV to mysql), or logic for discount.
Also, I sure that logic about sold ticket must be separated from Show, because it gives us more flexibility, therefore I created special class TicketManager for it.
And special class for check sold ticket, it is important, and help us easy move logic from calculation to real checking (for example, getting information about sold tickets from mysql).

Also, I have finished only 2 user stories (without bonus), because I think it is enough for the test.
I have written tests only for main parts of ticket logic, and I have skipped test for JS.
Also, for front-end I have skipped for disable button on loading data from server and other small things, i think, it is not so important.

### Demo

I have uploaded the code to my server, please see web app here:
https://tc-otravo.cheprasov.com/

### Tech

- PHP >= 7.1

### How to run tests

1. Update vendor via composer: `composer update`
2. Run `./vendor/bin/phpunit`

### How to run the CLI

`php ./src/index.php <filename.csv> <yyyy-mm-dd> <yyyy-mm-dd>`

### How to run the Web application

1. Edit and add config file `./nginx/80.conf` to your nginx server
2. Add some host to `/etc/hosts`, for example `<ip of server> tc-otravo.lh`
3. Open in browser `tc-otravo.lh`
4. Change mode for some dir if need.

Note, I have compiled front-end (javascript / react) via webpack already.

### Structure of the project

- `nginx` - configs for nginx server
- `public` - compiled files for front end (html, js, css)
- `react` - javascript / react source code
- `res` - resources like CSV files
- `src` - php source code
- `tests` - tests for backend

### Explanation of "Ticket sale starts 25 days before a show starts;"

I am writing about it, because I have 1 logical question. I will ask it later.

It is important for me, because in Russian language the phrase means, that the show date is not includes in the period `25 days before a show starts`. And I was a little confused about examples, in the test.

I will try to describe it more detailed.

For example, we have a show (Scenario 2):
```
Everyman, 2017-08-01, drama
```
Running the program with the above inventory, query-date 2017-08-01, and show-date 2017-08-15 should give the result:

Result that we have in the test:
```json
{
    "title": "everyman",
    "tickets left": "100", // 100 sold (200 cap - 100 left)
    "tickets available": "10",
    "status": "open for sale"
}
```

Now, we can see, that on query date 2017-08-01:
- left 100 tickets (sold 100 for prev days) in Tab 1
- left 90 tickets (sold 110 for prev days) in Tab 2

Yep, it is looks fine.

Ok, now I asked the question that confused me:
```
If show starts on 2017-08-15 and ticket sale starts 1 day before a show starts,
what is the first date when people can buy tickets?
```
For me, it looks like:

2017-08-15 - 1 day = 2017-08-14,
but according the test,
in this case the first date of sale is 2017-08-15 (same day).
It confused me :)

I see, that the phrase `25 days before a show starts` includes also the date when show starts to perform.

##### Tab1. Test variant (implemented in the test)

Days before show starts | Query Date | Left | Sold tickets for end of the day
---|---|---|---
25 | 2017-07-22 | 200 | 10
24 | 2017-07-23 | 190 | 20
23 | 2017-07-24 | 180 | 30
22 | 2017-07-25 | 170 | 40
21 | 2017-07-26 | 160 | 50
20 | 2017-07-27 | 150 | 60
19 | 2017-07-28 | 140 | 70
18 | 2017-07-29 | 130 | 80
17 | 2017-07-30 | 120 | 90
16 | 2017-07-31 | 110 | 100
15 | 2017-08-01 | 100 | 110
14 | 2017-08-02 | 90 | 120
13 | 2017-08-03 | 80 | 130
12 | 2017-08-04 | 70 | 140
11 | 2017-08-05 | 60 | 150
10 | 2017-08-06 | 50 | 160
9 | 2017-08-07 | 40 | 170
8 | 2017-08-08 | 30 | 180
7 | 2017-08-09 | 20 | 190
6 | 2017-08-10 | 10 | 200 / sold
5 | 2017-08-11 | 0 | 200 / sold
4 | 2017-08-12 | 0 | 200 / sold
3 | 2017-08-13 | 0 | 200 / sold
2 | 2017-08-14 | 0 | 200 / sold
1 (show date) | 2017-08-15 | 0 |

##### Tab2. Russian variant

in Russian language the phrase means, that the show date is not includes in the period `25 days before a show starts`.

Days before show starts | Query Date | Left | Sold tickets for end of day
---|---|---|---
25 | 2017-07-21 | 200 | 10
24 | 2017-07-22 | 190 | 20
23 | 2017-07-23 | 180 | 30
22 | 2017-07-24 | 170 | 40
21 | 2017-07-25 | 160 | 50
20 | 2017-07-26 | 150 | 60
19 | 2017-07-27 | 140 | 70
18 | 2017-07-28 | 130 | 80
17 | 2017-07-29 | 120 | 90
16 | 2017-07-30 | 110 | 100
15 | 2017-07-31 | 100 | 110
14 | 2017-08-01 | 90 | 120
13 | 2017-08-02 | 80 | 130
12 | 2017-08-03 | 70 | 140
11 | 2017-08-04 | 60 | 150
10 | 2017-08-05 | 50 | 160
9 | 2017-08-06 | 40 | 170
8 | 2017-08-07 | 30 | 180
7 | 2017-08-08 | 20 | 190
6 | 2017-08-09 | 10 | 200 / sold
5 | 2017-08-10 | 0 | 200 / sold
4 | 2017-08-11 | 0 | 200 / sold
3 | 2017-08-12 | 0 | 200 / sold
2 | 2017-08-13 | 0 | 200 / sold
1 | 2017-08-14 | 0 | 200 / sold
0 (show date) | 2017-08-15 | 0 |


