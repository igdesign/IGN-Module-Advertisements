#! /bin/bash

NAME="mod_advertisement"

# mandatory arguments
[ "$#" -eq 1 ] || exit "requires path to Joomla! Dev root directory - <path>"

JPATH="$1"

echo "Removing existing module..."
rm -rf $JPATH/modules/$NAME
echo "done."

echo "Linking new module build..."
ln -s "$(pwd)/_build/$NAME" "$JPATH/modules/$NAME"
echo "done"

echo "Running gulp..."
gulp
