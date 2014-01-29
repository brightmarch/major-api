#!/bin/bash

PHPMINVERSION='5.4.0'
PHPVERSION=`php -r "echo phpversion();"`
PHPCORRECTVERSION=`php -r "echo version_compare(phpversion(), '$PHPMINVERSION');"`

GREEN="\033[1;32m"
RED="\033[1;31m"
BLUE="\033[1;34m"
YELLOW="\033[1;33m"
ENDCOLOR="\033[0m"

echo -e "${BLUE}[BEGIN]${ENDCOLOR} Beginning MajorApi development build process."
echo

echo -e "${BLUE}[CHECK]${ENDCOLOR} ./app/config/build.settings exists."
if [ ! -f ./app/config/build.settings ]
then
    echo -e "${RED}[FAILURE]${ENDCOLOR} The ./app/config/build.settings file does not exist. Create it from ./app/config/build.settings.template."
    exit 1
fi
echo -e "${GREEN}[OK]${ENDCOLOR} ./app/config/build.settings exists."
echo

echo -e "${BLUE}[CHECK]${ENDCOLOR} Node.js is installed."
node --version >/dev/null 2>&1 || {
    echo -e "${RED}[FAILURE]${ENDCOLOR} Node.js is not installed. See http://nodejs.org to install Node.js."
    exit 1
}
echo -e "${GREEN}[OK]${ENDCOLOR} Node.js found in `which node`."
echo

echo -e "${BLUE}[CHECK]${ENDCOLOR} NPM is installed."
npm --version >/dev/null 2>&1 || {
    echo -e "${RED}[FAILURE]${ENDCOLOR} NPM is not installed. See http://npmjs.org to install NPM."
    exit 1
}
echo -e "${GREEN}[OK]${ENDCOLOR} NPM found in `which npm`."
echo

echo -e "${BLUE}[INSTALL]${ENDCOLOR} Installing Composer."
curl -s https://getcomposer.org/installer | php >/dev/null 2>&1

echo -e "${BLUE}[INSTALL]${ENDCOLOR} Installing PHPUnit."
wget http://pear.phpunit.de/get/phpunit-3.7.13.phar -O phpunit.phar >/dev/null 2>&1
chmod +x phpunit.phar

echo -e "${BLUE}[INSTALL]${ENDCOLOR} Installing Phing."
mkdir -p config/phing
wget http://www.phing.info/get/phing-2.5.0.tgz -O config/phing/phing.tgz >/dev/null 2>&1
tar -xzf config/phing/phing.tgz -C config/phing

echo -e "${BLUE}[INSTALL]${ENDCOLOR} Installing NPM libraries."
npm install >/dev/null 2>&1
echo

echo -e "${BLUE}[CHECK]${ENDCOLOR} PHP version."
if [ -1 = $PHPCORRECTVERSION ]; then
    echo -e "${RED}[FAILURE]${ENDCOLOR} PHP version $PHPMINVERSION required."
    exit 1
fi
echo -e "${GREEN}[OK]${ENDCOLOR} PHP version $PHPVERSION found."
echo

echo -e "${BLUE}[CHECK]${ENDCOLOR} Git is installed."
git --version exists >/dev/null 2>&1 || {
    echo -e "${RED}[FAILURE]${ENDCOLOR} Git is not installed. Git is needed to install the vendors. See http://git-scm.com to to install Git."
    exit 1
}
echo -e "${GREEN}[OK]${ENDCOLOR} Git found in `which git`."
echo

echo -e "${BLUE}[CHECK]${ENDCOLOR} Redis is installed."
REDIS=`which redis-server`
if [ -z $REDIS ]; then
    echo -e "${RED}[FAILURE]${ENDCOLOR} Redis is not installed. See http://redis.io to to install Redis."
    exit 1
fi
echo -e "${GREEN}[OK]${ENDCOLOR} Redis found in `which redis-server`."
echo

echo -e "${BLUE}[BEGIN]${ENDCOLOR} Building the MajorApi project."

php config/phing/bin/phing -Dbuild_settings_file=app/config/build.settings >/dev/null 2>&1
php config/phing/bin/phing run-database-migrations >/dev/null 2>&1

./node_modules/.bin/bower install >/dev/null 2>&1

if [ ! -d "log" ]; then
    mkdir log
fi
echo -e "${GREEN}[FINISHED]${ENDCOLOR} Building the MajorApi project."

echo
echo -e "${GREEN}####################################################################${ENDCOLOR}"
echo -e "${GREEN}# [SUCCESS] The MajorApi project is ready to go!                   #${ENDCOLOR}"
echo -e "${GREEN}####################################################################${ENDCOLOR}"
echo

exit 0
