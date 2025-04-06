const path = require('path');

module.exports = (env) => {

    return {
        entry: '../../../assets/js/bundle.js',
        output: {
            filename: 'bundle.js',
            path: path.resolve(__dirname, '../../public/dist')
        },
        watch: ('development' === env.NODE_ENV)? true : false
    }
};