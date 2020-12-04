import AxiosFunction from "./axios/AxiosFunction";
import Utility from "./utility/Utility";
import DateFunction from "./date/DateFunction";
import AppFunction from "./app/AppFunction";
import RegularExpression from "./reg-exp/RegularExpression";
import Icon from "./icon/Icon";
import TemplateHelper from "./template-helper/TemplateHelper";
import Time from "./time/Time";

export default {
    mounted() {
        this.$nextTick(() => {
            Icon.initFeather();
            TemplateHelper.preventDropdownMenuCloseOnInsideClick();
        });
    },
    computed: {
        timeFormat() {
            return this.$store.state.settings.timeFormat;
        },
        dateFormat() {
            return this.$store.state.settings.dateFormat;
        }
    },
    methods: {
        /**
         * axios get request
         * */
        axiosGet(url, data = null) {
            url = this.getAppUrl(url);
            return AxiosFunction.axiosGet(url, data);
        },

        /**
         * axios Post request
         * */
        axiosPost(options) {
            options.url = this.getAppUrl(options.url);

            return AxiosFunction.axiosPost(options);
        },

        /**
         * axios patch request
         * */
        axiosPatch(options) {
            options.url = this.getAppUrl(options.url);

            return AxiosFunction.axiosPatch(options);
        },

        /**
         * axios Put request
         * */
        axiosPut(options) {
            options.url = this.getAppUrl(options.url);

            return AxiosFunction.axiosPut(options);
        },

        /**
         * axios Delete request
         * */
        axiosDelete(url) {
            url = this.getAppUrl(url);

            return AxiosFunction.axiosDelete(url);
        },

        /**
         * get app url
         * */
        getAppUrl(url) {
            return AppFunction.getAppUrl(url);
        },

        /**
         * get base url
         * */
        getBaseUrl() {
            return AppFunction.getBaseUrl();
        },

        /**
         * checking function
         * */
        isFunction(func) {
            return Utility.isFunction(func);
        },

        /**
         * checking isUndefined
         * */
        isUndefined(obj) {
            return Utility.isUndefined(obj);
        },

        /**
         * checking given param is empty
         * */
        isEmpty(obj) {
            return Utility.isEmpty(obj);
        },

        /**
         * checking isBoolean
         * */
        isBoolean(obj) {
            return Utility.isBoolean(obj);
        },

        /**
         * checking valid email
         * */
        isValidEmail(email) {
            if (email)
                return RegularExpression.isValidEmail(email);
            else return true
        },

        /**
         * checking valid password
         * */
        isValidPassword(password) {
            if (password)
                return RegularExpression.isValidPassword(password);
            else return true
        },

        /**
         * checking Alphanumeric
         * */
        isAlphanumeric(value) {
            return RegularExpression.isAlphanumeric(value);
        },

        /**
         * compare between two dates
         * */
        isSecondDateAfterFirstDate(firstDate, secondDate) {
            return DateFunction.isSecondDateAfterFirstDate(
                firstDate,
                secondDate
            );
        },

        /**
         * get date format
         * */
        getDateFormat(date) {
            return DateFunction.getDateFormat(date, this.dateFormat);
        },

        isValidTime(timeString) {
            if (timeString)
                return Time.isValidTime(timeString, this.timeFormat);
            else return false;
        },

        objectToQueryString(obj) {

            const results = [];

            _.forOwn(obj, (value, key) => {
                results.push(`${key}=${value}`);
            });

            return results.join('&');
        },

        /**
         * get query strign value
         * @param key
         * */
        getQueryStringValue(key) {
            return AppFunction.getQueryStringValue(key);
        },

        /**
         * Back to previous url
         * */
        backToPrevioustUrl() {
            AppFunction.backToPrevioustUrl();
        },

        /**
         * go to next url
         * */
        goToNextUrl() {
            AppFunction.goToNextUrl();
        }
    }
};
