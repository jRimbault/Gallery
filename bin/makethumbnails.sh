#!/usr/bin/env bash
#/ Usage: makethumbnails.sh <directory full of jpg>
#/ Description: make a HTML index for an image directory
#/ Examples:
#/     ./makethumbnails.sh <directory full of jpg>
#/ Options:
#/     --help  display this help
usage() {
    grep '^#/' "$0" | cut -c4-
    exit 0
}
expr "$*" : ".*--help" > /dev/null && usage

checkImagick()
{
  if ! which convert > /dev/null; then
    echo "Imagemagick is not installed, or is not the path"
    exit 3
  fi
}

checkDirectory()
{
  if [[ ! -d "$1" ]]; then
    echo "'$1' is not a directory, or isn't accessible"
    exit 2
  fi
}

# main
main() {
  local gallery="$1"
  local thumbdir="$gallery/thumbnails"
  local jpg

  mkdir -p "$thumbdir"

  for jpg in "$gallery"/*.jpg; do
    jpg=$(basename "$jpg")

    if [[ ! -f "$thumbdir"/"$jpg" ]]; then
      convert "$gallery/$jpg" -resize 640x480 "$thumbdir/$jpg" &&
      echo "$jpg resized"
    else
      echo "Thumbnail for $jpg exists already"
    fi
  done
}

if [[ $# -lt 1 ]]; then
  usage
fi

checkDirectory "$1"
checkImagick
main "$@"
