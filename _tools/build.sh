#!/bin/sh

rm -r dist/
mkdir dist
cp -r -t dist class/ css/ js/ img/ languages/ templates/
cp -t dist features.txt license.txt readme.txt footnotes.php includes.php
