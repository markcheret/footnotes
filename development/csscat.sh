#!/bin/bash
# 2021-02-15T1839+0100
# Last modified: 2021-02-16T0155+0100
# csscat.sh
# Concatenates CSS files; deletes the concatenations after they’ve been minified.
#
# 12 unified style sheets are concatenated out of these files:
# dev-common.css
# dev-tooltips.css
# dev-tooltips-alternative.css
# dev-layout-reference-container.css
# dev-layout-entry-content.css
# dev-layout-main-content.css
#
echo "Running $(dirname "$0")/csscat.sh"
if [[ $1 == "c" ]]; then
echo "Concatenate in csscat/ for minification:"
cd ../css
mkdir csscat
cat dev-common.css > csscat/footnotes-nottbrpl0.css
cat dev-common.css dev-layout-reference-container.css > csscat/footnotes-nottbrpl1.css
cat dev-common.css dev-layout-entry-content.css > csscat/footnotes-nottbrpl2.css
cat dev-common.css dev-layout-main-content.css > csscat/footnotes-nottbrpl3.css
cat dev-common.css dev-tooltips.css > csscat/footnotes-jqttbrpl0.css
cat dev-common.css dev-tooltips.css dev-layout-reference-container.css > csscat/footnotes-jqttbrpl1.css
cat dev-common.css dev-tooltips.css dev-layout-entry-content.css > csscat/footnotes-jqttbrpl2.css
cat dev-common.css dev-tooltips.css dev-layout-main-content.css > csscat/footnotes-jqttbrpl3.css
cat dev-common.css dev-tooltips.css dev-tooltips-alternative.css > csscat/footnotes-alttbrpl0.css
cat dev-common.css dev-tooltips.css dev-tooltips-alternative.css dev-layout-reference-container.css > csscat/footnotes-alttbrpl1.css
cat dev-common.css dev-tooltips.css dev-tooltips-alternative.css dev-layout-entry-content.css > csscat/footnotes-alttbrpl2.css
cat dev-common.css dev-tooltips.css dev-tooltips-alternative.css dev-layout-main-content.css > csscat/footnotes-alttbrpl3.css
echo "Done."
elif [[ $1 == "d" ]]; then
echo "Move minified to css/ and delete concatenations and their temp dir:"
cd ../css/csscat
mv footnotes-nottbrpl0.min.css ..
mv footnotes-nottbrpl1.min.css ..
mv footnotes-nottbrpl2.min.css ..
mv footnotes-nottbrpl3.min.css ..
mv footnotes-jqttbrpl0.min.css ..
mv footnotes-jqttbrpl1.min.css ..
mv footnotes-jqttbrpl2.min.css ..
mv footnotes-jqttbrpl3.min.css ..
mv footnotes-alttbrpl0.min.css ..
mv footnotes-alttbrpl1.min.css ..
mv footnotes-alttbrpl2.min.css ..
mv footnotes-alttbrpl3.min.css ..
cd ..
rm -r csscat
echo "Done."
else
echo "Concatenates CSS files; deletes the concatenations after they’ve been minified."
echo ""
echo "12 unified style sheets are concatenated out of these files:"
echo ""
echo "dev-common.css"
echo ""
echo "dev-tooltips.css"
echo "dev-tooltips-alternative.css"
echo ""
echo "dev-layout-reference-container.css"
echo "dev-layout-entry-content.css"
echo "dev-layout-main-content.css"
echo ""
echo "Command: c: Concatenate temporary files waiting for minification."
echo "Command: d: Move the minified files to css/, delete the temporary."
echo "No command, \"--help\", or anything else: Output this help section."
fi
