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

# main
main() {
  # try and catch
  {
    jpgs=($(ls "$1"/*.jpg 2> /dev/null))
  } || {
    echo "No jpgs in $1"
    exit 0
  }

  thumbnails="$1/thumbnails"

  mkdir -p "$thumbnails"

  for jpg in "${jpgs[@]}"; do
    jpg=$(basename "$jpg")
    converted="$jpg"

    if [[ ! -f "$thumbnails"/"$converted" ]]; then
      convert "$1/$jpg" -resize 320x240 "$thumbnails/$converted" &&
      echo "$jpg resized"
    else
      echo "Thumbnail for $jpg exists already"
    fi
  done
}

echo "$@"

if [[ $# -lt 1 ]]; then
  exit 1
fi

main "$@"
