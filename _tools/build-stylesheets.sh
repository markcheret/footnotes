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

	echo "Concatenating files and placing in \`css/tmp/\`..."
	
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
	
	echo "Stylesheet concatenation complete."
	exit 0

elif [[ $1 == "-m" ]]; then

	# TODO: this should automatically minifiy all files, outputting into `.min.css`
	# files and deleting the original concatenated `.css` files in `css/tmp/`.
	# Once that's done, we can change the `rm -r` command in the deploy step to
	# `rmdir`, which will throw us an error if we have any minified files that
	# haven't been moved over to `dist/css/` for whatever reason. As it currently
	# stands, we have no error checking in place.
	echo "Please minify the stylesheets in \`css/tmp/\`, saving them in the same location with the \`.min.css\` file extension."
	read -p "Are you ready to continue? (Y/N): " CONFIRM && [[ $CONFIRM == [yY] || $CONFIRM == [yY][eE][sS] ]] || exit 1
	exit 0
	
elif [[ $1 == "-d" ]]; then

	# NOTE: I've temporarily replaced the `mv` command
	# with `cp` and disabled the `rm` command, so the minified
	# files won't be removed from the source directory.
	echo "Deploying minified stylesheets to \`dist/css/\`..."
	mkdir -p ./dist/css
	for f in ./css/tmp/*.min.css;	do
		filename=$(basename $f .css)
		cp $f ./dist/css
		#mv $f ./dist/css
		echo -e '\t' $filename".css moved."
	done
	
	# NB: We currently distribute both the minified + concatenated and the 
	# unminified + unconcatenated stylesheets with the Plugin.
	echo "Deploying development stylesheets to \`dist/css/\`..."
	for f in ./css/dev-*.css;	do
		filename=$(basename $f .css)
		cp $f ./dist/css
		#mv $f ./dist/css
		echo -e '\t' $filename".css moved."
	done
	
	#echo "Deleting temporary files..."
	#rm -r ./css/tmp
	echo "All stylesheets added to build."
	exit 0
	
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
