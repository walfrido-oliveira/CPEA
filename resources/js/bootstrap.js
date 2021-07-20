window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.toastr = require('../../node_modules/toastr/toastr');

require('./validate');
require('./sidebar');
require('./scripts');
