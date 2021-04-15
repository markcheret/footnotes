![footnotes](https://raw.githubusercontent.com/markcheret/footnotes/main/img/footnotes.png)

# footnotes

Featured on [wpmudev][wpmudev] — cheers for the review, folks!

**footnotes** aims to be the all-in-one solution for displaying an 
automatically-generated list of references on your Page or Post. The Plugin 
ships with a set of defaults while also empowering you to control how your 
footnotes will be displayed.

**footnotes** gives you the ability to display well-formatted footnotes on your 
WordPress Pages and Posts — those footnotes we know from offline publishing.

## Table of Contents

* [Features](#features)
* [Getting Started](#getting-started)
* [Deploying](#deploying)
* [Testing](#testing)
* [Code Formatting](#code-formatting)
* [Documentation](#documentation)
* [Acknowledgments](#acknowledgements)
* [License](#license)
* [Contact Information](#contact-information)

## Features

This Plugin provides:

- fully customizable footnote start and end shortcodes;
- stylable tooltips supporting hyperlinks and dedicated text;
- a responsive 'reference container', with customisable positioning;
- a wide choice of different numbering styles;
- a freely-configurable and optional backlink symbol;
- footnote appearance customisation via dashboard settings and custom CSS style 
  rules; and
- editor buttons for easily adding shortcode tags.

## Getting Started

1. Read the [contributing guidelines][contributing];
1. clone this repository (`git clone git@github.com:markcheret/footnotes.git`):
    - we recommend that you use [VVV][vvv] for your local testing environment.
1. install [Composer][composer], if you don't have it already; and
1. install all dependencies (`composer install`):
    - you will have to install `php-mbstring` manually if you do not already 
      have it.
     
## Deploying

Automated release deployments will be introduced soon.

### Building

1. Run `_tools/build-stylesheets.sh -c` to concatenate stylesheets;
1. manually minify the output files in `css/tmp/`, saving them as `.min.css` files:
    - the intention is to replace this with automated minification, meaning that
    all of these steps can be rolled into a single `build` command.
1. run `_tools/build-stylesheets.sh -d` to deploy the minified files to `dist/`:
    - **this will delete any existing `dist/` folder!**
1. run `composer run build` to move over the remaining files to `dist/`:
    - currently, the files to include in a distribution are hard-coded in 
      `_tools/build.sh`; but
    - the intention is to replace this with a proper parsing of the `.distignore` 
      file
  
### Releasing

1. Ensure that you have configured your Git config. with SVN credentials;
1. run the above [build](#building) commands; and
1. run `composer run release` and follow the prompts.
      
## Testing

Automated testing will be introduced soon.

## Code Formatting

This repo. uses pre-commit code formatting and linting on all staged files. 
This ensures that only style-conformant code can be committed.

The individual commands used by the pre-commit hook can also be called manually:

### PHP Code

PHP code must follow the [WordPress PHP Coding Standards][wpcs-php].

1. Run `composer run lint:php` to lint all JS/TS files with [PHP CodeSniffer][phpcs]
1. Run `composer run lint:php:fix` to attempt to automatically fix warnings and 
  errors with the PHP Code Beautifier and Formatter.
  
### JavaScript Code

JavaScript code must follow the [WordPress JavaScript Coding Standards][wpcs-js].

Automated linting and formatting will be introduced soon.
  
### CSS Stylesheets

JavaScript code must follow the [WordPress CSS Coding Standards][wpcs-css].

Automated linting and formatting will be introduced soon.

## Documentation

Run `composer run docs` to automatically generate HTML documentation with 
[phpDocumentor][phpdocumentor].

View the current docs [here][footnotes-docs].

## Acknowledgements

Huge thanks to every **footnotes user**, contributor, bug reporter, feature 
requester and fan!

## License

This project is licensed under the [GNU GPL v3][gpl-v3].

## Contact Information 

| Name          | Link(s)               |
|---------------|-----------------------|
|Mark Cheret		| [Email][mcheret] 			|

[wpmudev]: http://premium.wpmudev.org/blog/12-surprisingly-useful-wordpress-plugins-you-dont-know-about/
[php]: https://www.php.net/
[contributing]: https://github.com/markcheret/footnotes/blob/main/CONTRIBUTING.md
[vvv]: https://varyingvagrantvagrants.org/
[composer]: https://getcomposer.org/download/
[wpcs-php]: https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/
[phpcs]: https://github.com/squizlabs/PHP_CodeSniffer
[wpcs-js]: https://developer.wordpress.org/coding-standards/wordpress-coding-standards/javascript/
[wpcs-css]: https://developer.wordpress.org/coding-standards/wordpress-coding-standards/css/
[phpdocumentor]: https://phpdoc.org/
[footnotes-docs]: https://markcheret.github.io/footnotes/
[gpl-v3]: https://www.gnu.org/licenses/gpl-3.0.en.html
[mcheret]: mailto:mark@cheret.de

