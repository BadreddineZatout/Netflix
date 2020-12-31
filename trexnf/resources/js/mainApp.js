import './bootstrap';
import './plugins';
import Vue from 'vue';
import Vuex from 'vuex';
import vuexI18n from 'vuex-i18n';
import './core/coreApp';
import './app/app';

window.Vue = Vue;

/**
 * vuex
 */

Vue.use(Vuex);
import storeData from "./app/store/Index";
// import storeData from "./store/Index";
const store = new Vuex.Store(storeData);


/**
 * localization
 * $t('key') or this.$('key')
 * link: https://github.com/dkfbasel/vuex-i18n
 * */

Vue.use(vuexI18n.plugin, store);

const translationsEn = localStorage.getItem("app-languages");

const translationsDe = {
    'My nice title': 'Ein schöner Titel',
    'content': 'Dies ist ein toller Inhalt'
};

// add translations directly to the application
Vue.i18n.add('en', JSON.parse(translationsEn));
Vue.i18n.add('de', translationsDe);
// set the start locale to use
Vue.i18n.set('en');

/*------ localization end ------*/


const app = new Vue({
    store,
    el: '#app',
});
