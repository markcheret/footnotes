#!/bin/bash

echo "Building Plugin..."

# Moves everything including the style sheets over to `dist/`
echo "Copying directories..."
rm -rf dist/
mkdir dist
rsync -av --progress --exclude css src/* dist
echo "Setting production flag environment flag..."
sed -i -E "s/('PRODUCTION_ENV'[ ]?,[ ]?)false/\1true/g" ./dist/footnotes.php
echo "Production environment flag set."

echo "Setting pre-release version tags..."
grep " \* Version:" dist/footnotes.php | grep -Po "\d+\.\d+(\.\d+)?d$"
if [ $? != 0 ]; then echo "Development version tag (`d`) not set!"; exit 1; fi
PLUGIN_DEV_VERSION="$(grep " \* Version:" dist/footnotes.php | grep -Po "\d+\.\d+(\.\d+)?d$")"
PLUGIN_PRE_VERSION="${PLUGIN_DEV_VERSION/d/p}"
find dist -type f -exec sed -i "s/$PLUGIN_DEV_VERSION/$PLUGIN_PRE_VERSION/g" {} +
if [ $? != 0 ]; then echo "Pre-release tag (`p`) could not be set!"; exit 1; fi
echo "Pre-release version tags set."

echo "Building stylesheets..."
./_tools/build-stylesheets.sh -c
if [ $? != 0 ]; then echo "Concatenation failed!"; exit 1; fi
echo "Stylesheet build complete."

echo "Minifying CSS and JS..."
npm run minify
if [ $? != 0 ]; then echo "Minification failed!"; exit 1; fi
echo "Deleting unminified files from `dist/`..."
rm -r dist/*/{js,css}/*[^\.min].{js,css}
echo "Minification complete."

echo "Downgrading to PHP 7.4..."
./vendor/bin/rector process
echo "Downgrading complete."

if [[ $1 == "-v" ]]; then
	echo "Moving to VVV..."
	rm -rf ../VVV/www/wordpress-two/public_html/wp-content/plugins/footnotes
	mv dist footnotes && mv footnotes ../VVV/www/wordpress-two/public_html/wp-content/plugins
fi

echo "Build complete."
exit 0
