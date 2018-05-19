#!/bin/sh

set -ex

curl -s http://php-osx.liip.ch/install.sh | bash -s $OSX_PHP_BRANCH && true
# which php && true
# echo "export PATH=/usr/local/php5/bin:$PATH " >> $HOME/.bashrc && true
# tail $HOME/.bashrc && true
# source $HOME/.bashrc && true
# which php && true
# php --version && true
brew install composer && true
# composer --version && true