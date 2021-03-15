#!/bin/bash

echo "Building Plugin..."

# TODO: once automatic minification is implemented, this should handle that.
# For now, we shall have to assume that this command is being run on a repo. with
# minimised stylesheet files already in `dist/css/`.
echo "Building stylesheets..."
./_tools/build-stylesheets.sh -c
if [ $? != 0 ]; then echo "Concatenation failed!"; exit 1; fi
./_tools/build-stylesheets.sh -m
if [ $? != 0 ]; then echo "Minification failed!"; exit 1; fi
./_tools/build-stylesheets.sh -d
if [ $? != 0 ]; then echo "Deployment failed!"; exit 1; fi
echo "Stylesheet build complete."

# Moves everything else over to `dist/`
echo "Copying directories..."
cp -r -t dist class/ js/ img/ languages/ templates/
echo "Copying files..."
cp -t dist features.txt license.txt readme.txt footnotes.php includes.php wpml-config.xml customized-documentation-schema.txt customized-template-stack.txt CONTRIBUTING.md README.md SECURITY.md

echo "Build complete."
exit 0
