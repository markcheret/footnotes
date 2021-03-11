#!/bin/sh

# Moves everything except the stylesheets over to `dist/`

cp -r -t dist class/ js/ img/ languages/ templates/
cp -t dist features.txt license.txt readme.txt footnotes.php includes.php wpml-config.xml customized-documentation-schema.txt customized-template-stack.txt
# TODO: once automatic minification is implemented, this should handle that.
# For now, we shall have to assume that this command is being run on a repo. with
# minimised stylesheet files already in `dist/css/`.
