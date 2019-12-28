# PHP Poker Alho
A PHP Texas Hold'em Poker library


[![Build Status](https://travis-ci.com/kingarthurpt/PHPPokerAlho.svg?branch=master)](https://travis-ci.com/kingarthurpt/PHPPokerAlho)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1009dffa-7ced-42bd-b453-ad860f0e4ca0/mini.png)](https://insight.sensiolabs.com/projects/1009dffa-7ced-42bd-b453-ad860f0e4ca0)
[![Code Climate](https://codeclimate.com/github/kingarthurpt/PHPPokerAlho/badges/gpa.svg)](https://codeclimate.com/github/kingarthurpt/PHPPokerAlho)
[![Test Coverage](https://api.codeclimate.com/v1/badges/72dd08bbd2637dbb8d98/test_coverage)](https://codeclimate.com/github/kingarthurpt/PHPPokerAlho/test_coverage)


## Road map
This project will focus on developing a PHP library around the *Texas Hold'em Poker* variant. Other types of Poker may be included someday.

The main focus will be around developing a playable Poker table to play some hands against computer players. These computer players (bots) will be a great opportunity to try to implement some artificial intelligence.

After implementing the main types of Poker players as bots, the focus of this project will shift to the hability to practice playing Poker ring or tournament games against these bots.

Once finished, there are a million possibilities to improve the project.
These may be some of them:
 - Implement a Web interface to play Poker against other Humans
 - Implement a client/server to play Poker against other Humans on the CLI
 - Import hand history files from real Poker Rooms and replay those hands against bots
 - Develop the perfect Poker player who knows all the required Math
 - Build a robot who would become the perfect Poker player and leave him at home playing Poker and making me rich
 - Build a Raspberry Pi machine with some solar panels running this project 24/7 and send it to space to find some aliens who would like to play Poker

## How to Install
You need to install these dependencies in order to execute the project.
On a Debian system, execute:
```
sudo apt install composer php7.0 php-xml php-mbstring php-xdebug php-curl -y
```

If you haven't done it already, clone this project into your computer with:

```
git clone https://github.com/kingarthurpt/PHPPokerAlho.git
```

Move to the project's folder and install the remaining dependencies with:
```
composer install
```

## Basic usage
After installing all dependencies, you can start playing with the available CLI commands:
```
php pokeralho-cli
```

## Contributing
If you want to contribute to this project, you can start by looking at the Issues.
