import coreLibrary from "../../core/helpers/CoreLibrary";
import DateFunction from "../../core/helpers/date/DateFunction";

import * as dateTimeHelper from './DateTimeHelper';
export default{
    extends: coreLibrary,
    methods:{
        getTimeFromDateTime(dateTime){
            const format = this.$store.state.settings.timeFormat;
            return dateTimeHelper.getTimeFromDateTime(dateTime, format);
        },
        getDateFormatForBackend (date) {
            return DateFunction.getDateFormatForBackend(date);
        }
    }
}
