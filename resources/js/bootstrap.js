window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.toastr = require('../../node_modules/toastr/toastr');

window.NiceSelect = require('./nice-select2/nice-select2');

require('./validate');
require('./scripts');


