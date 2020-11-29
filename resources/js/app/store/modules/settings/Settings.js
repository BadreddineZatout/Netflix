import {axiosGet} from '../../../helpers/AxiosHelper';
import {getDateFormatForFrontend, getTimeFormatForFrontend} from '../../../helpers/DateTimeHelper';
import {BASIC_SETTINGS, LANGUAGE} from "../../../config/ApiUrl";
export default {

	state: {
		dateFormat: "DD/MM/YYYY",
		timeFormat: 12,
		appSettings: {},
        selectedLanguage : {},
		languages: [],
	},

	getters: {
		appSettings : state => state.appSettings,
	},

	mutations: {

    	GET_SETTINGS(state, settigns){
			state.appSettings = settigns;
			state.appSettings.logo = settigns.company_logo;
			state.appSettings.icon = settigns.company_icon;
			state.dateFormat = getDateFormatForFrontend(settigns.date_format);
			state.timeFormat = getTimeFormatForFrontend(settigns.time_format);
		},

		LANGUAGE_LIST(state, data) {
			state.languages = data.map((lang) => {
				return {
					...lang,
					id: lang.key,
					value: lang.title
				}
			});
		},

		SET_SELECTED_LANGUAGE(state, rootState){
    	    const {locale, translations} = rootState.i18n;
    	    state.selectedLanguage = translations[locale];
        }
	},

	actions: {
		getSettings({commit}){
			axiosGet(BASIC_SETTINGS).then(({data}) => {
				commit('GET_SETTINGS', data);
			});
		},

		getLanguages({commit, state}) {
			if (!state.languages.length) {
				axiosGet(LANGUAGE).then(({data}) => {
					commit('LANGUAGE_LIST', data)
				});
			}
		},

		setSelectedLanguage({commit, rootState}){
		    commit('SET_SELECTED_LANGUAGE', rootState)
        }
	}
}
