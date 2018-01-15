#!/usr/bin/env bash
#/ Usage: makethumbnails.sh <directory>
#/ Description: make a HTML index for an image directory
#/ Examples:
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
    echo "Error, see the logs" &&
    echo "No jpgs in $1"
  }

  thumbnails="$1"/thumbnails

  mkdir -p "$thumbnails"

  for jpg in "${jpgs[@]}"; do
    jpg=$(basename "$jpg")
    converted="$jpg"

    if [[ ! -f "$thumbnails"/"$converted" ]]; then
      convert "$1"/"$jpg" -resize 380x240 "$thumbnails"/"$converted" &&
      echo "$jpg resized"
    else
      echo "$converted exists already"
    fi
    echo "Found '$1/$jpg'"
  done

  echo "Done"
}

main "$@"
