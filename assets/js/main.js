'use strict';

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

function getLocation()
{
    let location = window.location.hash.replace("#", "");
    if (location === '') return location;
    return location.toTitleCase();
}

function breadcrumbs()
{
    let title = $('#breadcrumbs');
    let location = getLocation();
    title.text('Chez Rimbault');
    if (location !== '') {
        title.text('Chez Rimbault > ' + location);
    }
}

function buildCardImg(gallery, filename)
{
    let img = $('<img>');
    img.attr('class', 'card-img-top');
    img.attr('data-src', 'assets/img/' + gallery + '/' + filename);
    img.attr('title', filename.removeExtension().toTitleCase());
    return img;
}

function buildImgLink(gallery, filename)
{
    let link = $('<a>');
    link.attr('href', 'assets/img/' + gallery + '/' + filename);
    link.attr('id', filename.removeExtension().toTitleCase());
    return link;
}

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

function displayGallery()
{
    [].forEach.call(document.querySelectorAll('img[data-src]'), img => {
        img.setAttribute('src', img.getAttribute('data-src'));
        img.onload = () => {
            img.removeAttribute('data-src');
        };
    });
}

function getGallery(galleryName)
{
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
        breadcrumbs();
    });
}

function buildCardBody(filename)
{
    let body = $('<div>').attr('class', 'card-img-overlay');
    let title = $('<h5>').attr('class', 'card-title');
    title.text(filename.removeExtension().toTitleCase());
    title.appendTo(body);

    return body;
}

function homepage()
{
    $.getJSON('assets/?portal', json => {
        let gallery = $('#gallery');
        gallery.empty();
        json.forEach(filename => {
            let card = $('<div>')
                .attr('class', 'card text-white bg-dark')
                .attr('onclick', 'getGallery("' + filename.removeExtension() + '")');
            let img = $('<img>')
                .attr('src', 'assets/img/' + filename)
                .attr('class', 'card-img-top');
            let body = buildCardBody(filename);
            img.appendTo(card);
            body.appendTo(card);
            card.appendTo(gallery);
        });
        breadcrumbs();
    });
}

$(document).ready(() => {
    let location = getLocation().toLowerCase();
    if (location) {
        getGallery(location);
    } else {
        homepage();
    }
});
