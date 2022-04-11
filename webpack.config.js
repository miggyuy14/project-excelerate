const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
            'pub': path.resolve('public/assets'),
        },
    },
};
