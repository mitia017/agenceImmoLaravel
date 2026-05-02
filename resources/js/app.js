import './bootstrap';

import Alpine from 'alpinejs';

import axios from 'axios';

axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Alpine = Alpine;

Alpine.start();
