wp.domReady(function () {

    var embed_variations = [
        'wordpress',
        'crowdsignal',
        'soundcloud',
        'spotify',
        'flickr',
        'vimeo',
        'animoto',
        'cloudup',
        'collegehumor',
        'dailymotion',
        'funnyordie',
        'hulu',
        'imgur',
        'issuu',
        'kickstarter',
        'meetup-com',
        'mixcloud',
        'photobucket',
        'polldaddy',
        'reddit',
        'reverbnation',
        'screencast',
        'scribd',
        'slideshare',
        'smugmug',
        'speaker',
        'ted',
        'tumblr',
        'videopress',
        'wordpress-tv',
        'speaker-deck',
        'amazon-kindle',
        'wolfram-cloud'
    ];

    for (var i = embed_variations.length - 1; i >= 0; i--) {
        wp.blocks.unregisterBlockVariation('core/embed', embed_variations[i]);
    }
});