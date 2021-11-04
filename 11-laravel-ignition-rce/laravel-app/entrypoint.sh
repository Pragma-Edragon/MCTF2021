#!/bin/bash
php artisan migrate:fresh
apache2-foreground
