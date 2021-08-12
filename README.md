# footnotes

<!-- markdownlint-disable MD013 -->
![stable tag](https://img.shields.io/wordpress/plugin/v/footnotes?style=flat-square) ![WP rating](https://img.shields.io/wordpress/plugin/stars/footnotes?style=flat-square) ![Reqd PHP](https://img.shields.io/wordpress/plugin/required-php/footnotes?style=flat-square) ![Reqd WP](https://img.shields.io/wordpress/plugin/wp-version/footnotes?style=flat-square) ![WordPress Plugin: Tested WP Version](https://img.shields.io/wordpress/plugin/tested/footnotes?style=flat-square)

![GitHub contributors](https://img.shields.io/github/contributors/markcheret/footnotes?style=flat-square) ![GitHub commits since tagged version](https://img.shields.io/github/commits-since/markcheret/footnotes/2.7.3?style=flat-square) ![GitHub commit activity](https://img.shields.io/github/commit-activity/m/markcheret/footnotes?style=flat-square) ![issues](https://img.shields.io/github/issues/markcheret/footnotes?style=flat-square) ![PRs](https://img.shields.io/github/issues-pr/markcheret/footnotes?style=flat-square)

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0) ![Snyk Vulnerabilities for GitHub Repo](https://img.shields.io/snyk/vulnerabilities/github/markcheret/footnotes?style=flat-square) [![OSSAR](https://github.com/markcheret/footnotes/actions/workflows/ossar-analysis.yml/badge.svg)](https://github.com/markcheret/footnotes/actions/workflows/ossar-analysis.yml) [![Code Linting](https://github.com/markcheret/footnotes/actions/workflows/php.yml/badge.svg)](https://github.com/markcheret/footnotes/actions/workflows/lint-code.yml)

[![Commitizen friendly](https://img.shields.io/badge/commitizen-friendly-brightgreen.svg)](http://commitizen.github.io/cz-cli/) [![Coverage Status](https://coveralls.io/repos/github/markcheret/footnotes/badge.svg?branch=main)](https://coveralls.io/github/markcheret/footnotes?branch=main)
<!-- markdownlint-enable MD013 -->

![footnotes](https://raw.githubusercontent.com/markcheret/footnotes/main/.github/img/footnotes.png)

**footnotes** aims to be the all-in-one solution for displaying an
automatically-generated list of references on your Page or Post. The Plugin
ships with a set of defaults while also empowering you to control how your
footnotes will be displayed.

**footnotes** gives you the ability to display well-formatted footnotes on your
WordPress Pages and Posts — those footnotes we know from offline publishing.

Featured on [wpmudev][wpmudev] — cheers for the review, folks!

## Table of Contents

* [Features](#features)
* [Getting Started](#getting-started)
* [Documentation](#documentation)
* [Testing](#testing)
* [Acknowledgments](#acknowledgements)
* [License](#license)
* [Contact Information](#contact-information)

## Features

This Plugin provides:

* fully-customizable footnote start and end shortcodes;
* stylable tooltips supporting hyperlinks and dedicated text;
* a responsive reference container, with customisable positioning;
* a wide choice of different numbering styles;
* a freely-configurable and optional backlink symbol;
* footnote appearance customisation via dashboard settings and custom CSS style
  rules; and
* editor buttons for easily adding shortcode tags.

## Getting Started

1. Read the [contributing guidelines][contributing];
1. clone this repository (`git clone git@github.com:markcheret/footnotes.git`):
    * we recommend that you use [VVV][vvv] for your local testing environment.
1. install [Composer][composer] and [NPM][npm]; and
1. install all dependencies (`composer install`):
    * you will have to install `php-mbstring` manually if you do not already
      have it.
      
## Documentation

View the current docs [here][footnotes-docs].

## Testing

This repo. uses [PHPUnit](phpunit) to run automated tests. To run the full test 
suite, use `composer run test`.

Test cases are found in the `tests/` directory.

PHPUnit settings are available in the file `phpunit.xml`.

## Acknowledgements

Huge thanks to every **footnotes** user, contributor, bug reporter, feature
requester and fan!

## License

This project is licensed under the [GNU GPL v3][gpl-v3].

## Contact Information

| Name          | Link(s)               |
|---------------|-----------------------|
|Mark Cheret  | [Email][mcheret]    |

[wpmudev]: http://premium.wpmudev.org/blog/12-surprisingly-useful-wordpress-plugins-you-dont-know-about/
[php]: https://www.php.net/
[contributing]: https://github.com/markcheret/footnotes/blob/main/CONTRIBUTING.md
[vvv]: https://varyingvagrantvagrants.org/
[composer]: https://getcomposer.org/download/
[npm]: https://www.npmjs.com/
[wpcs-php]: https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/
[phpcs]: https://github.com/squizlabs/PHP_CodeSniffer
[wpcs-js]: https://developer.wordpress.org/coding-standards/wordpress-coding-standards/javascript/
[wpcs-css]: https://developer.wordpress.org/coding-standards/wordpress-coding-standards/css/
[prettier]: https://prettier.io/
[eslint]: https://eslint.org/
[stylelint]: https://stylelint.io/
[phpunit]: https://phpunit.de/
[phpdocumentor]: https://phpdoc.org/
[footnotes-docs]: https://markcheret.github.io/footnotes/
[gpl-v3]: https://www.gnu.org/licenses/gpl-3.0.en.html
[mcheret]: mailto:mark@cheret.de
