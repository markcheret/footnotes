![footnotes](https://raw.githubusercontent.com/markcheret/footnotes/main/img/footnotes.png)

# footnotes

## Description

Featured on [wpmudev](http://premium.wpmudev.org/blog/12-surprisingly-useful-wordpress-plugins-you-dont-know-about/) — cheers for the review, folks!

**footnotes** aims to be the all-in-one solution for displaying an automatically generated list of references on your Page or Post. The Plugin ships with a set of defaults while also empowering you to control how your footnotes are being displayed.

**footnotes** gives you the ability to display well-formatted footnotes on your WordPress Pages and Posts — those footnotes we know from offline publishing.

## Getting Started

1. Read the contributing guidelines
1. Clone this repository (`git clone git@github.com:markcheret/footnotes.git`)
    - We recommend that you use [VVV](https://varyingvagrantvagrants.org/) for your local testing environment
1. Install [Composer](https://getcomposer.org/download/), if you don't have it already
1. Install dependencies (`composer install`)
    - You will have to install `php-mbstring` manually if you do not already have it.

## Code Formatting

1. Run `composer run lint-php` to lint all PHP files
1. Run `composer run lint-php:fix` to attempt to automatically fix errors and warnings

## Releasing

1. Run `composer run release`

## Building

1. Run `_tools/build-stylesheets.sh -c` to concatenate stylesheets
1. Manually minify the output files in `css/tmp/`, saving them as `.min.css` files
  - The intention is to replace this with automated minification, meaning that
    all of these steps can be rolled into a single `build` command.
1. Run `_tools/build-stylesheets.sh -d` to deploy the minified files to `dist/`
  - **this will delete any existing `dist/` folder**
1. Run `composer run build` to move over the remaining files to `dist/`
  - Currently, the files to include in a distribution are hard-coded in `_tools/build.sh`
  - The intention is to replace this with a proper parsing of the `.distignore` file

## Updating Documentation

1. Run `composer run docs`

## Testing

Unit tests are TODO.

## Main Features

- Fully customizable **footnotes** start and end shortcodes;
- Styled tooltips supporting hyperlinks display **footnotes** or a dedicated text;
- Responsive *Reference Container* at the end or positioned by shortcode;
- Display the **footnotes** *Reference Container* inside a Widget;
- Wide choice of numbering styles;
- Freely configurable and optional backlink symbol;
- Configure the **footnotes'** appearance by dashboard settings and Custom CSS style rules;
- Button in both the Visual and the Text editor to add shortcodes around selection.

## Example Usage

These are a few examples of possible ways to delimit footnotes:

1. Your awesome text`((`with an awesome footnote`))`
2. Your awesome text`[ref]`with an awesome footnote`[/ref]`
3. Your awesome text`<fn>`with an awesome footnote`</fn>`
4. Your awesome text`custom-shortcode`with an awesome footnote`custom-shortcode`

## Where to get footnotes?

The current version is available on the [WordPress.org Plugin Directory](https://wordpress.org/plugins/footnotes/).

## Acknowledgements

Huge thanks to every **footnotes user**, contributor, bug reporter, feature requester and fan!
