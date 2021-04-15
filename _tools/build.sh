#!/bin/bash

echo "Building Plugin..."

# Moves everything including the style sheets over to `dist/`
echo "Copying directories..."
cp -r -t dist class/ css/ js/ languages/ templates/
# Among the images, only 2 out of 3 are distributed.
echo "Copying the needed images..."
mkdir dist/img
cp -t dist/img img/fn-wysiwyg.png img/main-menu.png
echo "Copying files..."
cp -t dist features.txt license.txt readme.txt includes.php wpml-config.xml customized-documentation-schema.txt customized-template-stack.txt CONTRIBUTING.md README.md SECURITY.md
echo "Setting production flag..."
sed "s/'PRODUCTION_ENV', false/'PRODUCTION_ENV', true/g" footnotes.php > dist/footnotes.php
echo "Production flag set." 

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

echo "Build complete."
exit 0
