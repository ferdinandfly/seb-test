# API
This is a project of technical test using symfony API-Platform.

Refer to the [Getting Started Guide](https://github.com/api-platform/api-platform) for more information.


## Documentation

1. [Install](#installation)
2. [Usage](#usage)
3. [Swagger API](#swagger-api)
4. [Data Fixture](#data-fixtures)
5. [Unit Tests](#unit-tests)

## Installation
   * clone the project
   * make start
   * make migration
## Usage
   * open navigator to: https://localhost
   
A makefile is in place for common usage, you can use :
        
    make help 
to see more information.

## Swagger API
   * The swagger is located at: https://localhost/docs
   * A json file is generated here: [swagger.json](api/config/swagger.json)

## Data Fixtures
   The [Alice](https://github.com/hautelook/AliceBundle) is not compatible for php 8, so it do not contain any fixtures.
   To run all functional tests:
   
    make test
   
## Unit Tests
   The unit test is not needed for no logic exist.
