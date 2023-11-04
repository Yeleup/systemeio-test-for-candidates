#!/bin/bash

set -e

echo "Starting test setup..."
echo "Removing existing test database..."
php bin/console doctrine:database:drop --force --env=test

echo "Creating new test database..."
php bin/console doctrine:database:create --env=test

echo "Creating database schema..."
php bin/console doctrine:schema:create --env=test

echo "Loading fixtures into the test database..."
php bin/console doctrine:fixtures:load --no-interaction --env=test

echo "Running PHPUnit tests..."
php bin/phpunit tests

echo "Test setup completed!"
