## Use the following:
* Framework: Laravel 10
* PHP 8.1
* JAVASCRIPT
* CSS
* MYSQL

## Develop the following system:
You need to create a site that allows using the Google Speedpage Insights API to show the main metrics of the selected categories. The requirements are the following:

1. Create 3 models:
* MetricHistoryRun: id, url, accesibility_metric, pwa_metric, performance_metric, seo_metric, best_practices_metric (with their respective created and updated date fieldss)
* Category: id, name (create a seeder with the initial values: ACCESSIBILITY, BEST_PRACTICES, PERFORMANCE, PWA, SEO)
* Strategy: id, name (create a seeder with the initial values: DESKTOP, MOBILE)

The MetricHistoryRun and Strategy models have to be related, each run is executed only with one strategy.

2. Create a view (with blade) where the following fields are displayed:
* input text: Where you can enter a URL to get the metrics
* group of checkboxes: Where all the categories will be displayed (1 or multiple)
* select: where you will choose a single strategy.
* submit button: To execute the process that uses the API and obtains the metrics.

3. Create a method in Laravel (that can be called from the view) that makes the call to the Google service using Guzzle, creating a specific client for the call (do not use Laravel's Http Facade). From the view, make the query via AJAX with JAVASCRIPT (pure or
jQuery, as you prefer) to this previously created method.

The Laravel method must use the following URL to request data:
    
    `GET: https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=URL&key=KEY&category=CATEGORY1&category=CATEGORY..N&strategy=STRATEGY`

4. After performing the query via AJAX, the metrics obtained with the values ​​returned by the Google API should be displayed below the fields detailed in the previous point, showing "metric name" and "value obtained" (and whatever is required at the graphic level). From the JSON returned by the query, the results are obtained from the score of each category, as shown in the image:

![Ajax response example](/screenshots/AjaxResponseExample.png)
5. In addition to the results, a button that says "Save Metric Run" should also be displayed. This button, via AJAX, will save the data from the MetricHistoryRun model, related to Strategy.
6. Create a view that shows a list of the entire history in a table with the following columns:

![Table mockup](/screenshots/TableExample.png)

Mockup of the main screen after running the service:
![Mockup](/screenshots/Mockup.png)

**Important:** This is for illustrative purposes only. The challenge will evaluate the design applied to define the CSS level, effects management, DOM manipulation, usability, user interaction, etc. The structure of the screen can (and is suggested) be changed.

**Important:** This is just a mockup to reinforce the description of the exercise. The design used is part of what will be evaluated in terms of CSS usage.
