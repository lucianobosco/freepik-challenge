# Freepik API Challenge

# Architecture
- This code is based on Slim 4 PHP Framework.
- Development environment uses Docker + Nginx + PHP 8.1
- Code Integration with Github actions
- Swagger-PHP for endpoints documentation. File located in root folder `openapi.yaml` and must be read in https://editor.swagger.io/

# Instructions
1. Clone the repository
2. Navigate to the project folder and run `Docker compose build`
3. Run `Docker compose up`
4. Hit `http://localhost:8080/country-check/it` in your browser
5. Expect a json response