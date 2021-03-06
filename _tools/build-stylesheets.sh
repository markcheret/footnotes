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

	echo "Concatenating files and placing in \`css/tmp/\`."
	mkdir -p ./css/tmp
	cat ./css/dev-common.css > ./css/tmp/footnotes-nottbrpl0.css
	cat ./css/dev-{common,layout-reference-container}.css > ./css/tmp/footnotes-nottbrpl1.css
	cat ./css/dev-{common,layout-entry-content}.css > ./css/tmp/footnotes-nottbrpl2.css
	cat ./css/dev-{common,layout-main-content}.css > ./css/tmp/footnotes-nottbrpl3.css
	cat ./css/dev-{common,tooltips}.css > ./css/tmp/footnotes-jqttbrpl0.css
	cat ./css/dev-{common,tooltips,layout-reference-container}.css > ./css/tmp/footnotes-jqttbrpl1.css
	cat ./css/dev-{common,tooltips,layout-entry-content}.css > ./css/tmp/footnotes-jqttbrpl2.css
	cat ./css/dev-{common,tooltips,layout-main-content}.css > ./css/tmp/footnotes-jqttbrpl3.css
	cat ./css/dev-{common,tooltips,tooltips-alternative}.css > ./css/tmp/footnotes-alttbrpl0.css
	cat ./css/dev-{common,tooltips,tooltips-alternative,layout-reference-container}.css > ./css/tmp/footnotes-alttbrpl1.css
	cat ./css/dev-{common,tooltips,tooltips-alternative,layout-entry-content}.css > ./css/tmp/footnotes-alttbrpl2.css
	cat ./css/dev-{common,tooltips,tooltips-alternative,layout-main-content}.css > ./css/tmp/footnotes-alttbrpl3.css
	cat ./css/settings.css > ./css/tmp/settings.css
	echo "Done."

elif [[ $1 == "-m" ]]; then

	# TODO: this should automatically minifiy all files, outputting into `.min.css`
	# files and deleting the original concatenated `.css` files in `css/tmp/`.
	# Once that's done, we can change the `rm -r` command in the deploy step to
	# `rmdir`, which will throw us an error if we have any minified files that
	# haven't been moved over to `dist/css/` for whatever reason. As it currently
	# stands, we have no error checking in place.
	echo "Minifying files (TODO)..."
	mkdir -p ./dist/css
	for f in ./css/tmp/*.css;	do
		filename=$(basename $f .css)
		echo $filename
		# TODO: automated minification
		echo $filename Done
	done
	echo "Done."
	
elif [[ $1 == "-d" ]]; then

	echo "Deploying minified files to \`dist/css/\`..."
	rm -r ./dist
	mkdir -p ./dist/css
	for f in ./css/tmp/*.min.css;	do
		filename=$(basename $f .css)
		echo Moving $filename
		mv $f ./dist/css
		echo $filename Moved
	done
	echo "Deleting temporary files..."
	rm -r ./css/tmp
	echo "Done."
	
else

	echo -e "Concatenates, minifies (TODO) and deploys stylesheets for distribution.\n"
	echo -e "12 unified style sheets are concatenated out of these files:\n"
	echo    "\`dev-common.css\`"
	echo    "\`dev-tooltips.css\`"
	echo    "\`dev-tooltips-alternative.css\`"
	echo    "\`dev-layout-reference-container.css\`"
	echo    "\`dev-layout-entry-content.css\`"
	echo -e "\`dev-layout-main-content.css\`\n"
	echo    "Command: \`-c\`: Concatenate \`dev-*\` CSS files into temporary directory."
	echo    "Command: \`-m\`: Minify files (TODO)."
	echo    "Command: \`-d\`: Deploy minified files to \`dist/css/\` and remove temporary files."
	echo    "No command, \"--help\", or anything else: Output this help section."
	
fi
