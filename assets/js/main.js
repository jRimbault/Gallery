'use strict';

/**
 * Mostly for fun, I extended the native String class
 * I shouldn't do that.
 */
Object.assign(String.prototype, {
    toTitleCase()
    {
        return this
            .split(' ')
            .map(i => i[0].toUpperCase() + i.substring(1).toLowerCase())
            .join(' ');
    },
    removeExtension()
    {
        return this.replace(/\.[^/.]+$/, "");
    }
});

/**
 * We're using that to make decisions about what to display
 * @returns String
 */
function getLocation()
{
    let location = window.location.hash.replace("#", "");
    if (location === '') return location;
    return location.toTitleCase();
}

/**
 * Used to show to the users where he is
 */
function breadcrumbs()
{
    let title = $('#breadcrumbs');
    let location = getLocation();
    title.text('Chez Rimbault');
    if (location !== '') {
        title.text('Chez Rimbault > ' + location);
    }
}

/**
 * Responsible for building the img element of a card which is part of
 * a gallery of cards of pictures
 * @param gallery
 * @param filename
 * @returns {jQuery|HTMLElement}
 */
function buildCardImg(gallery, filename)
{
    let img = $('<img>');
    img.attr('class', 'card-img-top');
    img.attr('data-src', 'assets/img/' + gallery + '/' + filename);
    img.attr('title', filename.removeExtension().toTitleCase());
    return img;
}

/**
 * Responsible for link a card to an image file
 * @param gallery
 * @param filename
 * @returns {jQuery|HTMLElement}
 */
function buildImgLink(gallery, filename)
{
    let link = $('<a>');
    link.attr('href', 'assets/img/' + gallery + '/' + filename);
    link.attr('id', filename.removeExtension().toTitleCase());
    return link;
}

/**
 * Links together buildCardImg and buildImgLink to make a whole bootstrap card
 * @param gallery
 * @param filename
 * @returns {jQuery|HTMLElement}
 */
function buildCard(gallery, filename)
{
    let card = $('<div>');
    card.attr('class', 'card text-white bg-dark mb-3');

    let link = buildImgLink(gallery, filename);
    let img = buildCardImg(gallery, filename);
    img.appendTo(link);
    link.appendTo(card);

    return card;
}

/**
 * We don't want the DOM to reflow each time an image finishes loading
 * So, each img tag is loaded first with the data-src attribute, then replaced
 * with the normal src attribute
 */
function displayGallery()
{
    [].forEach.call(document.querySelectorAll('img[data-src]'), img => {
        img.setAttribute('src', img.getAttribute('data-src'));
        img.onload = () => {
            img.removeAttribute('data-src');
        };
    });
}

/**
 * Used to build the gallery of cards of images
 */
function getGallery()
{
    let galleryName = getLocation().toLowerCase();
    $.getJSON('assets/?' + galleryName, json => {
        let gallery = $('#gallery');
        gallery.empty();
        json.forEach(filename => {
            let card = buildCard(galleryName, filename);
            card.appendTo(gallery);
        });
        displayGallery();
        history.pushState(window.state, galleryName);
        window.location = '#' + galleryName;
    });
}

/**
 * Portal cards are specials, they have an overlayed caption
 * This is responsible for building that overlay
 * @param filename
 * @returns {jQuery|HTMLElement}
 */
function buildCardBody(filename)
{
    let body = $('<div>').attr('class', 'card-img-overlay');
    let title = $('<h4>').attr('class', 'card-title');
    title.text(filename.removeExtension().toTitleCase());
    title.appendTo(body);

    return body;
}

/**
 * Responsible for building the portal cards and links
 * @param filename
 * @returns {jQuery|HTMLElement}
 */
function buildPortalCard(filename)
{
    let link = $('<a>').attr('href', '#' + filename.removeExtension());
    let card = $('<div>').attr('class', 'card text-white bg-dark');
    let img = $('<img>')
        .attr('data-src', 'assets/img/' + filename)
        .attr('class', 'card-img-top');
    let body = buildCardBody(filename);
    img.appendTo(card);
    body.appendTo(card);
    card.appendTo(link);
    return link;
}

/**
 * Displays the homepage
 */
function homepage()
{
    $.getJSON('assets/?portal', json => {
        let gallery = $('#gallery');
        gallery.empty();
        json.forEach(filename => {
            let card = buildPortalCard(filename);
            card.appendTo(gallery);
        });
        displayGallery();
    });
}

/** init functions */
function main()
{
    if (getLocation()) {
        getGallery();
    } else {
        homepage();
    }
    breadcrumbs();
}

$(document).ready(main);
$(window).on('hashchange', main);
