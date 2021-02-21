![footnotes](https://raw.githubusercontent.com/markcheret/footnotes/main/img/footnotes.png)

# footnotes

## Description

Featured on [wpmudev](http://premium.wpmudev.org/blog/12-surprisingly-useful-wordpress-plugins-you-dont-know-about/) --- cheers for the review, folks!

**footnotes** aims to be the all-in-one solution for displaying an automatically generated list of references on your Page or Post. The Plugin ships with a set of defaults while also empowering you to control how your footnotes are being displayed.

**footnotes** gives you the ability to display well-formatted footnotes on your WordPress Pages and Posts — those footnotes we know from offline publishing.

## Getting Started

1. Read the contributing guidelines
1. Clone this repository (`git clone git@github.com:Rumperuu/footnotes.git`)
1. Install [Composer](https://getcomposer.org/download/), if you don't have it already
1. Install dependencies (`composer install`)
1. Create a new branch from `main` (`git checkout -b <your-descriptive-branch-name>`)
1. When you're finished, commit your changes to the remote version of your branch
   and submit a [pull request](https://github.com/Rumperuu/footnotes/pulls).

## Checking WP Coding Standard Compliance

1. Run PHP_CodeSniffer on the file(s) you want to check (`./vendor/bin/phpcs --standard="WordPress" --colors --encoding=utf-8 -n -p <file(s)>`)
1. (If applicable) run the PHP Code Beautifier and Formatter to attempt to automatically fix any errors (`./vendor/bin/phpcbf --standard="WordPress" --encoding=utf-8 -p <file(s)>`)
  - Add the `-n` flag to ignore warnings (i.e., show only errors)
	- Add the `-s` flag to show sniff codes (used for disabling errors in the code with `phpcs disable:<sniff code>` — MAKE SURE THAT YOU HAVE `phpcs enable` AT THE EARLIEST POINT POSSIBLE, and provide a justification for disabling the sniff code)
  - You can run either across the entire project by adding the argument `--ignore=*/vendor/*` and targetting the file `./*.php ./**/*.php`

## Updating Documentation

1. Install [phpDocumentor](https://phpdoc.org/)
1. Run it (`phpDocumentor -d . -t docs`)

## Testing

Unit tests are TODO.

## Main Features

- Fully customizable **footnotes** start and end shortcodes;
- Styled tooltips supporting hyperlinks display **footnotes** or a dedicated text;
- Responsive *Reference Container* at the end or positioned by shortcode;
- Display the **footnotes** *Reference Container* inside a Widget;
- Wide choice of numbering styles;
- Freely configurable and optional backlink symbol;
- Configure the **footnotes’** appearance by dashboard settings and Custom CSS style rules;
- Button in both the Visual and the Text editor to add shortcodes around selection.

## Example Usage

These are a few examples of possible ways to delimit footnotes:

1. Your awesome text((with an awesome footnote))
2. Your awesome text[ref]with an awesome footnote[/ref]
3. Your awesome text`<fn>`with an awesome footnote`</fn>`
4. Your awesome text`custom-shortcode`with an awesome footnote`custom-shortcode`

## Where to get footnotes?

The current version is available on the [WordPress.org Plugin Directory](https://wordpress.org/plugins/footnotes/).

## Acknowledgements

Huge thanks to every footnotes user, contributor, bug reporter, feature requester and fan!
