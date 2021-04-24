#!/bin/bash

# Concatenates, minifies (TODO) and deploys stylesheets for distribution.
#
# 12 unified stylesheets are concatenated out of these files:
# - `dev-common.css`
# - `dev-tooltips.css`
# - `dev-tooltips-alternative.css`
# - `dev-layout-reference-container.css`
# - `dev-layout-entry-content.css`
# - `dev-layout-main-content.css`

echo "Running $(dirname "$0")/build-stylesheets.sh"

if [[ $1 == "-c" ]]; then

	echo "Concatenating files and placing in \`tmp/css/\`..."
	
	mkdir -p ./tmp/css
	cat ./src/css/dev-common.css > ./tmp/css/footnotes-nottbrpl0.css
	
	cat ./src/css/dev-{common,layout-reference-container}.css > ./tmp/css/footnotes-nottbrpl1.css
	cat ./src/css/dev-{common,layout-entry-content}.css > ./tmp/css/footnotes-nottbrpl2.css
	cat ./src/css/dev-{common,layout-main-content}.css > ./tmp/css/footnotes-nottbrpl3.css
	
	cat ./src/css/dev-{common,tooltips}.css > ./tmp/css/footnotes-jqttbrpl0.css
	cat ./src/css/dev-{common,tooltips,layout-reference-container}.css > ./tmp/css/footnotes-jqttbrpl1.css
	cat ./src/css/dev-{common,tooltips,layout-entry-content}.css > ./tmp/css/footnotes-jqttbrpl2.css
	cat ./src/css/dev-{common,tooltips,layout-main-content}.css > ./tmp/css/footnotes-jqttbrpl3.css
	
	cat ./src/css/dev-{common,tooltips,tooltips-alternative}.css > ./tmp/css/footnotes-alttbrpl0.css
	cat ./src/css/dev-{common,tooltips,tooltips-alternative,layout-reference-container}.css > ./tmp/css/footnotes-alttbrpl1.css
	cat ./src/css/dev-{common,tooltips,tooltips-alternative,layout-entry-content}.css > ./tmp/css/footnotes-alttbrpl2.css
	cat ./src/css/dev-{common,tooltips,tooltips-alternative,layout-main-content}.css > ./tmp/css/footnotes-alttbrpl3.css
	
	cat ./src/css/dev-{common,tooltips,amp-tooltips}.css > ./tmp/css/footnotes-amptbrpl0.css
	cat ./src/css/dev-{common,tooltips,amp-tooltips,layout-reference-container}.css > ./tmp/css/footnotes-amptbrpl1.css
	cat ./src/css/dev-{common,tooltips,amp-tooltips,layout-entry-content}.css > ./tmp/css/footnotes-amptbrpl2.css
	cat ./src/css/dev-{common,tooltips,amp-tooltips,layout-main-content}.css > ./tmp/css/footnotes-amptbrpl3.css
	
	cat ./src/css/settings.css > ./tmp/css/settings.css
	
	echo "Stylesheet concatenation complete."
	exit 0
	
else

	echo -e "Concatenates stylesheets ready for distribution.\n"
	echo -e "12 unified style sheets are concatenated out of these files:\n"
	echo    "\`dev-common.css\`"
	echo    "\`dev-tooltips.css\`"
	echo    "\`dev-tooltips-alternative.css\`"
	echo    "\`dev-layout-reference-container.css\`"
	echo    "\`dev-layout-entry-content.css\`"
	echo -e "\`dev-layout-main-content.css\`\n"
	echo    "Command: \`-c\`: Concatenate \`dev-*\` CSS files into temporary directory."
	echo    "No command, \"--help\", or anything else: Output this help section."
	
fi
