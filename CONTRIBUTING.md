# **footnotes** Contributing Guide

**footnotes** welcomes contributions!

## Code of Conduct

Please read and ensure that you adhere to the project's [Code of Conduct][coc].

## Requesting Features/Reporting Bugs

To request a new feature or to report a bug, create an [Issue][new-issue] and
choose the correct template.

## Contributing Code

- **footnotes** uses [GitHub Flow][github-flow];
- branch off of `main` to start developing (`git checkout -b <your branch>`);
- ensure that your new branch has a descriptive name;
- create a remote copy of your new branch (`git push`);
- create a draft [pull request][pull-request] to merge your branch with `main` —
  tag any related Issues, and if they are assigned to a Project board, this will
  automatically move them into the ‘In Progress’ bucket; and
- when you think you're finished, un-draft your pull request — if the PR is
  assigned to a Project board, this will automatically move it and any related
  Issues into the ‘Review in progress’ bucket.

## Commits

- **footnotes** uses the [Conventional Commits][conventional-commits] for
  commit message formatting;
- we recommend using [Commitizen][commitizen] to automate this:
  - install it globally using `npm install -g commitizen`;
  - use `git cz` instead of `git commit`.
- keep individual commits as small as possible.

## Versioning

**footnotes** uses [WordPress Versioning][wpver].

## Translating

Translations are welcome!

[coc]: https://github.com/markcheret/footnotes/blob/main/CODE_OF_CONDUCT.md
[new-issue]: https://github.com/markcheret/footnotes/issues/new/choose
[github-flow]: https://githubflow.github.io/
[pull-request]: https://github.com/markcheret/footnotes/compare
[conventional-commits]: https://www.conventionalcommits.org
[commitizen]: https://www.npmjs.com/package/commitizen
[wpver]: https://make.wordpress.org/core/handbook/about/release-cycle/version-numbering/
