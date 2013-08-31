jQuery(document).ready(function($) {

    $('#front-search').typeahead({
        name: 'twitter-oss',
        prefetch: '/hadis/search/book-list',
        template: [
            '<a href="{{link}}">',
            '<p class="repo-name">{{name}}</p>',
            '<p class="repo-description">{{description}}</p>',
            '</a>'
        ].join(''),
        engine: Hogan
    });

});