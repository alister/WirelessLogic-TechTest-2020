# Wireless Logic – Software Engineering Team
## Software Engineering Technical Test
### Test Description

This task is intended to test your ability to consume a webpage, process some data and present it. While there is no specific time limit, we would not expect you to spend any longer than 2 hours completing this.

We are looking for concise, testable, clean, well commented code and that you have chosen the right tools for the right job. We will also be looking at your app structure as a whole.

## Requirements

Using best practice coding methods, build a console application that scrapes the following website url https://videx.comesconnected.com/ and returns a JSON array of all the product options on the page.

Each element in the JSON results array should contain 'option title', 'description', 'price' and 'discount' keys corresponding to items in the table. The items should be ordered by annual price with the most expensive package first.

Your code should:
* Include unit tests.
* Include a README.md file in the root describing how to run the app, how to run tests and any dependencies needed from the system
* The application should be written in PHP 

You may use a dependency management system (e.g. composer) and as many dependencies as you like.

## Setup

    # clone the git repository
    composer install
    # run tests:
    php -f phpunit.phar -- --colors --verbose --testdox --coverage-html=build/coverage ./tests/

    # Run the command:
    bin/console app:scrape:videx    # the option `--allow-broken-ssl` also exists which turns off certificat checking...

## Output:

The webpage URL is fetched by 'symfony/http-client', inside a 'symfony/dom-crawler' instance. The parsing of the webpage happens in \App\Scrapers\VidexComesconnectedCom::parse(), which puts the data into a value object, which is then further cleaned, and then sorted buy the annual price (shown below).   

This is the output from `bin/console app:scrape:videx`. Monthly prices (the first three items [0,1,2]) are multiplied by 12 for the annual cost, and then sorted in descending order. 

    [
        {
            "id": 2,
            "optionTitle": "Option 300 Mins",
            "desc": "300 minutes talk time per monthincluding 40 SMS(5p \/ minute and 4p \/ SMS thereafter)",
            "price": 192,
            "discount": ""
        },
        {
            "id": 5,
            "optionTitle": "Option 3600 Mins",
            "desc": "Up to 3600 minutes talk time per year including 480 SMS(5p \/ minute and 4p \/ SMS thereafter)",
            "price": 174,
            "discount": "Save \u00a318 on the monthly price"
        },
        {
            "id": 1,
            "optionTitle": "Option 160 Mins",
            "desc": "Up to 160 minutes talk time per monthincluding 35 SMS(5p \/ minute and 4p \/ SMS thereafter)",
            "price": 120,
            "discount": ""
        },
        {
            "id": 4,
            "optionTitle": "Option 2000 Mins",
            "desc": "Up to 2000 minutes talk time per year including 420 SMS(5p \/ minute and 4p \/ SMS thereafter)",
            "price": 108,
            "discount": "Save \u00a312 on the monthly price"
        },
        {
            "id": 0,
            "optionTitle": "Option 40 Mins",
            "desc": "Up to 40 minutes talk time per monthincluding 20 SMS(5p \/ minute and 4p \/ SMS thereafter)",
            "price": 72,
            "discount": ""
        },
        {
            "id": 3,
            "optionTitle": "Option 480 Mins",
            "desc": "Up to 480 minutes talk time per yearincluding 240 SMS(5p \/ minute and 4p \/ SMS thereafter)",
            "price": 66,
            "discount": "Save \u00a35 on the monthly price"
        }
    ]
