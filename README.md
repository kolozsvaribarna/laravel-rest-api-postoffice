# Laravel REST API

# Endpoints

| URL                   | HTTP method | Auth | JSON Response            |
|-----------------------| ----------- | ---- |--------------------------|
| /users/login          | POST        |      | user's token             |
| /users                | GET         | Y    | all users                |
| /counties             | GET         |      | all counties             |
| /counties             | POST        | Y    | new county added         |
| /counties             | PATCH       | Y    | edited county            |
| /counties             | DELETE      | Y    | id                       |
| /cities               | GET         |      | all cities               |
| /counties/{id}/cities | GET         |      | all cities in the county |
| /cities               | POST        | Y    | new city added           |
| /cities               | PATCH       | Y    | edited city              |
| /cities               | DELETE      | Y    | id                       |
