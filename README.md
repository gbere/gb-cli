gb-cli
======


[![license](https://img.shields.io/github/license/mashape/apistatus.svg?longCache=true&style=for-the-badge)](https://en.wikipedia.org/wiki/MIT_License)
[![Latest Version](https://img.shields.io/github/release/gbere/gb-cli.svg?longCache=true&style=for-the-badge)](https://github.com/gbere/gb-cli/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/gbere/gb-cli.svg?longCache=true&style=for-the-badge)](https://packagist.org/packages/gbere/gb-cli)

gBere cli utils powered by symfony/console

## Requirements

- cURL
- Composer
- PHP >=7.1.3

## Installing

```bash
# Install gb-cli
composer global require gbere/gb-cli
```

## Setting up

If the bin folder of your Composer isn’t in the PATH variable, add it:

```bash
echo "export PATH="$HOME/.composer/vendor/bin:$PATH" " >> ~/.bashrc
source ~/.bashrc
```

## Usage

```bash
gb say:hello
```
