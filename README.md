### Objective

Your assignment is to build an internal API for a fake weather and air quality widget using PHP and Laravel.

### Scenario

Here at Solar Widget Co., our goal is to help everyone adopt green energy best practices to provide a healthier tomorrow for our children. To help our customers understand this goal, we have decided to release a new current weather and air quality widget. This widget was so beloved by our internal staff, that we couldn't decide where to launch the widget. That's when you, our newest developer, suggested we make an internal API that shares the data with any platform that requests it. 

Everyone celebrated the genius answer! "Thank you for volunteering to write this magical tool," a smiling project manager says as he shakes your hand. Before walking away, he politely informs you that you have two weeks to build an initial version of the feature that our development team can expand on when the inevitable future requests roll in. You assure him that won't be a problem. He then reminds you that due to IT VPN limitations, you'll only have four hours to write the widget within the two week time frame, because "we have to share bandwidth space or something."

The project manager walks off whistling a happy tune leaving you in your chair to figure out how to build this widget. Listed below are the notes you eventually get approved by your project manager and the project stakeholders in the original meeting.

### Brief

Modern weather services have evolved to provide multiple features, including historical weather data, forecast data, "feels like" indicators, pollution statistics and more. Today, your task is to build the basic HTTP API around two popular features in modern weather services: current weather data and an air quality indicator. Imagine you are new to the development team, and your backend API design will be immediately used by the rest of your team in future sprints for the foresable future. You also know that the API will be consumed by multiple frontends (web, iOS, Android etc). In order to make the best first impression with your team mates, you want to build a simple, yet scalable solution that will be a pleasure to work with.

### Tasks

1. [Required] Build an API `GET` route named `/weather` using:
   * [PHP 8.1 or 8.2](https://www.php.net/)
   * [Laravel 10.x](https://laravel.com/docs/10.x/releases)
2. [Required] The API route should accept the following query parameters:
   * `city`: User specified city that the weather and air quality rating should be from.
   * `state`: User specified state (US only) that the weather and air quality rating should be from.
3. [Required] Reasonably scalable multi-external API integration: remember, "your team" will be using this for upcoming feature requests.
   * [Airvisual](https://api-docs.iqair.com/#5bc93d6b-d563-43dc-adb9-c266b2e96d4a) for user specified location air quality data.
   * [Weatherstack](https://weatherstack.com/documentation#current_weather) for user specified location weather data.
4. [Required] The API route response should be JSON and contain the following information:
   * `query`: An object with user specified city and state query variables.
   * `temperature`: The temperature for the given queried location. This value should be from [Weatherstack](https://weatherstack.com/documentation#current_weather).
   * `temperature_unit`: The temperature unit (should ALWAYS return `f` for 'Fahrenheit'). This value should be from [Weatherstack](https://weatherstack.com/documentation#current_weather).
   * `weather_description`: A brief description of the weather. This value should be from [Weatherstack](https://weatherstack.com/documentation#current_weather).
   * `humidity_percent`: The humidity percentage. This value should be from [Weatherstack](https://weatherstack.com/documentation#current_weather).
   * `air_quality_rating`: An air quality rating based on the US EPA standards. This value should be interpreted from [Airvisual](https://api-docs.iqair.com/#5bc93d6b-d563-43dc-adb9-c266b2e96d4a) data using the Levels of Concern' from [AirNow.gov: AQI basics](https://www.airnow.gov/aqi/aqi-basics/).
5. [Required] There should be [automated unit and/or feature tests](https://laravel.com/docs/10.x/testing) for all implemented features using either:
   * [PHPUnit](https://phpunit.de/)
   * [PEST](https://pestphp.com/)
6. [Optional] Use [Laravel Octane](https://laravel.com/docs/10.x/octane#introduction) to query both APIs [concurrently](https://laravel.com/docs/10.x/octane#concurrent-tasks) so that your internal API responses are as fast as possible.

#### Example Response

```json
{
    "query": {
        "city": "San Francisco",
        "state": "CA"
    },
    "temperature": "68",
    "temperature_unit": "°F",
    "weather_description": "Partly Cloudy",
    "humidity_percent": "72",
    "air_quality_description": "Good"
}
```

### Evaluation Criteria

1. Assignment Completeness: The assignment should work correctly and implement all requirements. The API should output JSON in the specified format using data from the specified APIs. Bonus points are awarded for successfully implementing Octane concurrency to speed up the external API requests.
2. Code Elegance: Elegant code is concise, easy to read, understand and modify. Elegance is the minimization of unnecessary complexity while not shying away from industry accepted best practices and design patterns when needed. If you can quickly hand the code off to another programmer with reasonable skills and they are able to continue the work then the code is likely elegant.
3. Code Readability: Variables and functions should have meaningful names. Code should be organized into functions/methods where appropriate. There should be an appropriate amount of white space so that the code is readable, and indentation should be consistent. Using [Laravel accepted practices](https://laravel.com/docs/10.x/pint) for maintaining code style is strongly encouraged.
4. Documentation: The code and functions/methods should be appropriately commented. However, not every line should be commented because that makes the code overly busy. Think carefully about where comments are needed and focus on explaining *why* you are doing what you are doing, **not** what you are doing. If you feel the need to explain what you are doing, please refer back to point #2.

### Useful Links

1. You can download a copy of the simplified [Postman collection with mock server for both the Airvisual and Weatherstack APIs here](https://drive.google.com/file/d/19HKlxWiOvbrN3UFX5EpYlPl_c81gy-D-/view?usp=sharing). Please note that this collection only includes routes that you expected to implement. The mock data is what your solution will be tested against.
2. [AirNow.gov: AQI basics](https://www.airnow.gov/aqi/aqi-basics/) - how to translate AQI into a human-readable description based on US EPA standards.
3. [Airvisual](https://api-docs.iqair.com/#5bc93d6b-d563-43dc-adb9-c266b2e96d4a) official API documentation. The above Postman collection is modified directly from the official Postman shared source, and is simplified to only include what you need to complete this assignment.
4. [Weatherstack](https://weatherstack.com/documentation#current_weather) official API documentation. The above Postman collection is a modified version of the official documentation that is simplified to only include what you need to complete this assignment.
5. [Laravel Documentation](https://laravel.com/docs/10.x/installation)

### Disclaimer

The scenario simply provides a story that combines the interview requirements and project tasks. It is not indicative of the day-to-day work environment at Solar Insure. Hopefully it gave you a laugh before beginning your interview assignment. You got this. 


### CodeSubmit

Please organize, design, test, and document your code as if it were going into production - then push your changes to the master branch.

Have fun coding! 🚀
