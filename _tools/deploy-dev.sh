#!/bin/bash

if [[ $1 == "-v" ]]; then
	echo "Deploying to VVV site #1"
	rm -rf ../VVV/www/wordpress-one/public_html/wp-content/plugins/footnotes
	cp -r src footnotes && mv footnotes ../VVV/www/wordpress-one/public_html/wp-content/plugins
	#rm -rf ./footnotes
fi

echo "Deploy complete."
exit 0
