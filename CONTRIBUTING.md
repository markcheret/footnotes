# footnotes Contributing Guidelines

This project welcomes contributions!

This document describes everything you need to know about working with this
project.

## Table of Contents

* [Code of Conduct](#code-of-conduct)
* [Requesting Features and Reporting Bugs](#requesting-feature-and-reporting-bugs)
* [Development](#development)
* [Releases](#releases)
* [Translating](#translating)

## Code of Conduct

Please read and ensure that you adhere to the project's [Code of Conduct][coc].

## Requesting Features and Reporting Bugs

To request a new feature or to report a bug, create an [Issue][new-issue]:

* example templates are provided;
* if you are reporting a bug that has security implications, please see
  the project [security guidelines][security].

## Development

### Version Control

Version control for this project uses [Git][git] for development and
[Apache Subversion][svn] for releases:

* The [development repository][dev-repo] is hosted on [GitHub][github]; and
* the [release repository][rel-repo] is hosted on the [WordPress Plugin Directory][wp-plugin-dir],
a Subversion repository hosted by the WordPress Plugins team:
  * information on using the WordPress Plugin Directory can be found in the
      [_WordPress Plugin Handbook_][wp-plugin-handbook].

#### Branching

This project uses the [GitHub Flow][github-flow] branching methodology:

* branch off of `main` to start developing (`git checkout -b <your branch>`);
* ensure that your new branch has a descriptive name (e.g., ‘fix-foo-bug’);
* create a remote copy of your new branch (`git push`);
* create a draft [pull request][new-pull-request] to merge your branch with `main`:
  * tag any related or to-close Issues, Projects and Milestones:
    * if any Issues are assigned to a Project board, this will automatically
          move them into the ‘In Progress’ bucket.
  * assign the PR to yourself unless you have a good reason not to.
* when you think you're finished, un-draft your pull request:
  * if the request is assigned to a Project board, this will automatically
      move it and any related Issues into the ‘Review in progress’ bucket.

#### Committing

This project uses the [Conventional Commits][conventional-commits] format for
commit messages:

* commit message formatting can be automatically enforced by using
  [Commitizen][commitizen]:
  * install it globally using `npm install -g commitizen`; then
  * use `git cz` instead of `git commit`.
* please keep individual commits as small and atomic as possible.

### Configuration

The only configurable environment variable is the `PRODUCTION_ENV` flag in
`src/footnotes.php`. This should always be set to `false` on this repo, and is
automatically flipped during the release process.

### Code Formatting

This repo. uses [Husky][husky] to run pre-commit code formatting and linting
on all staged files. This ensures that only style-conformant code can be
committed (although this can be bypassed by passing the `--no-verify` argument
to your `git commit` command).

The individual commands used by Husky can also be called manually:

* Run `composer run format` to run all format commands.
* Run `composer run format:fix` to attempt to automatically fix all formatter warnings
  and errors.

* Run `composer run lint` to run all linting commands.
* Run `composer run lint:fix` to attempt to automatically fix all linter warnings
  and errors.
  
_NB: `npm` can also be used in place of `composer`._

#### PHP

PHP code must follow the [WordPress PHP Coding Standards][wpcs-php] and be
compatible with PHP 7.0+.

1. Run `composer run lint:php` to lint all PHP files with
  [PHP CodeSniffer][phpcs]; and
1. run `composer run lint:php:fix` to attempt to automatically fix warnings and
  errors using the PHP Code Beautifier and Formatter tool.
  
#### JavaScript

JavaScript code must follow the [WordPress JavaScript Coding Standards][wpcs-js].
JavaScript code targets the [ESNext][esnext] standard.

1. Run `composer run format:js` to format all JS files with [Prettier]
  [prettier]; and
1. run `composer run format:js:fix` to attempt to automatically fix warnings and
  errors.

1. Run `composer run lint:js` to lint all JS files with [ESLint][eslint]; and
1. run `composer run lint:js:fix` to attempt to automatically fix warnings and errors.

Prettier and ESLint configuration settings are found in `package.json`. Prettier
ignore rules are found in `.prettierignore`.
  
#### CSS

CSS stylesheets must follow the [WordPress CSS Coding Standards][wpcs-css].

1. Run `composer run lint:css` to lint all CSS files with [stylelint]
  [stylelint]; and
1. run `composer run lint:css:fix` to attempt to automatically fix warnings and
  errors.

stylelint configuration settings are found in `package.json`.

#### Markdown

* Run `composer run lint:md` to lint all Markdown files with [markdownLint]
  [markdownlint]; and
* run `composer run lint:md:fix` to attempt to automatically fix warnings and errors.

#### HTML

Run `composer run lint:html` to lint all HTML files with [HTMLHint][htmlhint].

#### YAML

Run `composer run validate:yaml` to validate all YAML files with [yaml-validator][yaml-validator].

#### JSON

TODO

### Testing

TODO

## Documentation

This repo. uses [Husky][husky] to run pre-push documentation generation. This is
to guarantee that all HTML documentation on the remote repo. should be up-to-date,
but this step can be bypassed if necessary by passing the `--no-verify` flag to
the `git push` command.

### Tooling

HTML documentation of the codebase is generated using [phpDocumentor][phpdocumentor].

phpDocumentor configuration settings are found in `phpdoc.dist.xml`.

### Documenting

The codebase is documented using PHPDoc docblocks.

### Documentation Commands

| Command     | Result             |
|----------------|--------------------------------|
| `composer run docs` | Regenerate HTML documentation. |

## Releases

Only Project Collaborators can issue new releases.

### Versioning

This project uses [WordPress Versioning][wpver] for version numbering (as of 2.7).

### Building

Run `composer run build` to build the Plugin.

### Releasing

Run `composer run release` to run use the release handler:

* this is still a WIP!
* TODO: move to a GitHub Action so that the only way of handling a release is to
  create one on GitHub:
  * TODO: create separate pre-release and non-pre-release Actions

## Translating

Translations are welcome!

[coc]: https://github.com/markcheret/footnotes/blob/main/CODE_OF_CONDUCT.md
[new-issue]: https://github.com/markcheret/footnotes/issues/new/choose
[security]: https://github.com/markcheret/footnotes/blob/main/SECURITY.md
[git]: https://git-scm.com/
[svn]: https://subversion.apache.org/
[dev-repo]: https://github.com/markcheret/footnotes
[github]: https://github.com
[rel-repo]: https://plugins.svn.wordpress.org/footnotes/
[wp-plugin-dir]: https://plugins.svn.wordpress.org/
[wp-plugin-handbook]: https://developer.wordpress.org/plugins/wordpress-org/how-to-use-subversion/
[github-flow]: https://githubflow.github.io/
[new-pull-request]: https://github.com/markcheret/footnotes/compare
[conventional-commits]: https://www.conventionalcommits.org
[commitizen]: https://www.npmjs.com/package/commitizen
[husky]: https://typicode.github.io/husky/#/
[esnext]: https://esnext.github.io/esnext/
[markdownlint]: https://github.com/DavidAnson/markdownlint
[htmlhint]: https://htmlhint.com/
[yaml-validator]: https://www.npmjs.com/package/yaml-validator
[wpver]: https://make.wordpress.org/core/handbook/about/release-cycle/version-numbering/
