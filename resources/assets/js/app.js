
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./vendor/jquery.growl');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('scanner', require('./components/scanner.vue'));
Vue.component('result', require('./components/result.vue'));
Vue.component('history', require('./components/history.vue'));
Vue.component('terminal', require('./components/terminal.vue'));
Vue.component('wifi', require('./components/wifi.vue'));

const app = new Vue({
  el: '#app',
  data: {
    cloneTarget: {}
  },
  methods: {
    promptClone(target) {
      this.cloneTarget = target;
    },
    clone() {
      axios.post('/api/scanner/clone', this.cloneTarget).then((response) => {
        if (response.data.success) {
          this.addMessage({
            title: 'Success!',
            message: response.data.result,
            type: 'success',
            duration: 3000
          })
        }
      }).catch((error) => {
        this.addMessage({
          title: 'Oh no!',
          message: error.response.data.message,
          type: 'danger',
          duration: 3000
        });
      });
    },
    addMessage({ title='', message='', type='', duration=0, location='br' }) {
      let style = 'default';
      const styleMap = {
        'default': 'default',
        'success': 'notice',
        'danger': 'error',
        'warning': 'warning'
      };
      if (type in styleMap) style = styleMap[type];

      let opts = {
        style: style,
        title: title,
        message: message,
        location: location,
        fixed: true
      };
      if (duration > 0) {
        opts.duration = duration;
        opts.fixed = false;
      }

      $.growl(opts);
    }
  }
});
