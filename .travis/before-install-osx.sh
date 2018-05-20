#!/bin/sh

set -ex

curl -s http://php-osx.liip.ch/install.sh | bash -s $OSX_PHP_BRANCH
brew install composer
