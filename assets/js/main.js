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
    card.attr('class', 'card');

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
        json.thumbnails.forEach(o => {
            let card = buildCard(id, o);
            card.appendTo(gallery);
        });
        displayGallery();
        history.pushState(window.state, id);
        window.location = '#' + id;
    });
}

function init() {
    $.getJSON('assets/?portal', json => {
        let gallery = $('#gallery');
        gallery.empty();
        json.forEach(o => {
            let card = $('<div>');
            let title = removeExtension(name);
            card.attr('class', 'card');
            let link = $('<a>');
            link.attr('href', 'assets/img/' + name);
            link.attr('id', title);
            let img = $('<img>');
            img.attr('src', 'assets/img/' + name);
            img.attr('title', toTitleCase(title));
            img.appendTo(link);
            link.appendTo(card);
            card.appendTo('body');
        });
    });
}

$(document).ready(() => {
    //init();
});

