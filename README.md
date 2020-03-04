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
