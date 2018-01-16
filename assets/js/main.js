'use strict';

function toTitleCase(input) {
    return input
        .split(' ')
        .map(i => i[0].toUpperCase() + i.substring(1).toLowerCase())
        .join(' ');
}

function removeExtension(input) {
    return input.replace(/\.[^/.]+$/, "");
}

function getLocation() {
    let location = window.location.hash.replace("#", "");
    if (location === '') return location;
    return toTitleCase(location);
}

function breadcrumbs() {
    let title = $('#breadcrumbs');
    let location = getLocation();
    title.text('Chez Rimbault');
    if (location !== '') {
        title.text('Chez Rimbault > ' + location);
    }
}

function buildCardImg(id, name) {
    let img = $('<img>');
    img.attr('class', 'card-img-top');
    img.attr('data-src', 'assets/img/' + id + '/thumbnails/' + name);
    img.attr('title', toTitleCase(removeExtension(name)));
    return img;
}

function buildImgLink(id, name) {
    let link = $('<a>');
    link.attr('href', 'assets/img/' + id + '/' + name);
    link.attr('id', toTitleCase(removeExtension(name)));
    return link;
}

function buildCard(id, name) {
    let card = $('<div>');
    card.attr('class', 'card text-white bg-dark mb-3');

    let link = buildImgLink(id, name);
    let img = buildCardImg(id, name);
    img.appendTo(link);
    link.appendTo(card);

    return card;
}

function displayGallery() {
    [].forEach.call(document.querySelectorAll('img[data-src]'), img => {
        img.setAttribute('src', img.getAttribute('data-src'));
        img.onload = function () {
            img.removeAttribute('data-src');
        };
    });
}

function getGallery(id) {
    $.getJSON('assets/?' + id, json => {
        let gallery = $('#gallery');
        gallery.empty();
        json.thumbnails.forEach(name => {
            let card = buildCard(id, name);
            card.appendTo(gallery);
        });
        displayGallery();
        history.pushState(window.state, id);
        window.location = '#' + id;
        breadcrumbs();
    });
}

function buildCardBody(name) {
    let body = $('<div>').attr('class', 'card-img-overlay');
    let title = $('<h5>').attr('class', 'card-title');
    title.text(toTitleCase(removeExtension(name)));
    title.appendTo(body);

    return body;
}

function homepage() {
    $.getJSON('assets/?portal', json => {
        let gallery = $('#gallery');
        gallery.empty();
        json.forEach(name => {
            let card = $('<div>')
                .attr('class', 'card text-white bg-dark')
                .attr('onclick', 'getGallery("' + removeExtension(name) + '")');
            let img = $('<img>')
                .attr('src', 'assets/img/portal/' + name)
                .attr('class', 'card-img-top');
            let body = buildCardBody(name);
            img.appendTo(card);
            body.appendTo(card);
            card.appendTo(gallery);
        });
        breadcrumbs();
    });
}

$(document).ready(() => {
    homepage();
});