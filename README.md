# About Product Review System

The Product Review System is designed to handle user reviews and product comments efficiently. The system is built with scalability and flexibility in mind, utilizing various design patterns and best practices to ensure maintainability and future extensibility.

## Setup

First of all check docker copmose yml file for customization ports ane etc.

Build docker compose

```bash
docker compose up --build -d
```

Then migrate doctrine migrations on fpm container

```bash
php artisan doctrine:migrations:migrate
```

Now let's seed database

```bash
php artisan db:seed
```

Note: dont forget to give relative permissions to product comment count file path

```bash
chown -R www-data:www-data /opt/myprogram
```

## Architecture

This project uses Doctrine ORM. I chose Doctrine over other ORMs, such as Eloquent, because Doctrine is a data mapper ORM, which provides more flexibility and separation between the database and the domain model.

I employed abstraction layers such as services and repositories to facilitate scalability and maintain a cleaner codebase. While this abstraction may make the code more complex than usual, it provides the flexibility needed to switch to other ORMs or services in the future without significant refactoring.

I used the Factory pattern for creating user instances since user creation involves multiple processes, such as password hashing. This pattern helps to encapsulate the complexity of user instantiation.

In general, I avoid using facades in code because they tend to hide dependencies, making the project harder to manage. However, in this case, I chose to use them to keep my controllers clean and to follow a structural design pattern.

For user password hashing, I implemented salting to enhance security.

I followed various standards, such as PSR-5, and focused on separating concerns, utilizing events, and more to ensure that the code adheres to best practices.

## Commands

Use the seeders to create a default ParsPack user and initial products:

```bash
php artisan db:seed
```

To create a new product with a given name, use the following command:

```bash
php artisan product:create {name}
```

## Files

### Product Comment Count File

By default, the product comment count file is stored at /opt/myprogram/product_comments.

To change this location, create an environment variable named PRODUCT_COMMENT_COUNT_FILE_PATH.
