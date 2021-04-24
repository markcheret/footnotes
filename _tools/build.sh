#!/bin/bash

echo "Building Plugin..."

# Moves everything including the style sheets over to `dist/`
echo "Copying directories..."
rm -r dist/
mkdir dist
cp -r -t dist src/{class,js,languages,templates}/
# Among the images, only 2 out of 3 are distributed.
echo "Copying the needed images..."
mkdir -p dist/img
cp -t dist/img src/img/fn-wysiwyg.png
echo "Copying files..."
cp -t dist src/{license.txt,readme.txt,includes.php,wpml-config.xml,SECURITY.md,CHANGELOG.md}
echo "Setting production flag..."
sed "s/'PRODUCTION_ENV', false/'PRODUCTION_ENV', true/g" src/footnotes.php > dist/footnotes.php
echo "Production flag set." 

# TODO: once automatic minification is implemented, this should handle that.
# For now, we shall have to assume that this command is being run on a repo. with
# minimised stylesheet files already in `dist/css/`.
echo "Building stylesheets..."
./_tools/build-stylesheets.sh -c
if [ $? != 0 ]; then echo "Concatenation failed!"; exit 1; fi
if [[ $1 != "-y" ]]; then
	./_tools/build-stylesheets.sh -m
	if [ $? != 0 ]; then echo "Minification failed!"; exit 1; fi
fi
./_tools/build-stylesheets.sh -d
if [ $? != 0 ]; then echo "Deployment failed!"; exit 1; fi
echo "Stylesheet build complete."

echo "Build complete."
exit 0
