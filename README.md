# Laravel 10 with clean architecture

This is an example of a project that applies Clean Architecture using the Laravel framework version 10.

## Features

- Rest API
- Produce and Consume messages with Kafka

## The idea (simulation)

> - User registration
> - Authentication of user
> - The user can create an cart with items
> - The user can pay the cart

## Pre-requisites

Before you begin, make sure you have the following tools installed in your development environment:

- docker


## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/ranierif/laravel-clean-architecture.git


2. **Start the container:**

   ```bash
   docker-compose up -d

3. **Open the terminal in the docker to start the development server and run:**

   ```bash
   composer start:dev

## Commands

1. **Check Code style:**

   ```bash
   composer lint:test

2. **Fix Code style:**

   ```bash
   composer lint:fix

3. **Run tests:**

   ```bash
   composer test

4. **Run coverage**

   ```bash
   composer test:coverage


5. **Default commit:**

   ```bash
   npm run commit

6. **Prepare database:**

   ```bash
   php artisan db:prepare

## Docs

You can find the complete API documentation at the following Postman link:

[![Run in Insomnia}](https://insomnia.rest/images/run.svg)](https://insomnia.rest/run/?label=Laravel%20Clean%20Architecture&uri=#)
