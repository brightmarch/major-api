#!/bin/bash

php phpunit.phar -d memory_limit=512M -c app $*
