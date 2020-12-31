export default {
    data() {
        return {
            inputFields: [],
            hidePreLoader: true,
            isActive: false,
            selectedItemId: '',
            deleteID: '',
            deleteIndex: '',
            updateIndex: '',

        }
    },
    mounted() {
        let instance = this;
        this.$hub.$on('selectedDeletableId', function (id, index) {
            instance.deleteID = id;
            instance.deleteIndex = index;
        });
    },
    methods: {
        modalCloseAction(modalID) {
            let instance = this;
            $(modalID).on('hidden.bs.modal', function (e) {
                instance.isActive = false;
            });

        },
        setPreLoader(value) {
            let instance = this;
            instance.hidePreLoader = value;
        },
        addEditAction(id) {
            console.log("called");
            this.selectedItemId = id;
            this.isActive = true;
        },

        dateFormats(dt) {
            return moment(dt).format(this.dateFormat);
        },

        datePickerDateFormatter(date) {

            if (date == "DD/MM/YYYY") return format('dd/MM/yyyy');
            if (date == "MM/DD/YYYY") return format('MM/dd/yyyy');
            if (date == "YYYY/MM/DD") return format('yyyy/MM/dd');

            if (date == "DD-MM-YYYY") return format('dd-MM-yyyy');
            if (date == "MM-DD-YYYY") return format('MM-dd-yyyy');
            if (date == "YYYY-MM-DD") return format('yyyy-MM-dd');

            if (date == "DD.MM.YYYY") return format('dd.MM.yyyy');
            if (date == "MM.DD.YYYY") return format('MM.dd.yyyy');
            if (date == "YYYY.MM.DD") return format('yyyy.MM.dd');
        },

        dateFormatsWithTime(time) {

            if (this.timeFormat == '12h') {
                return moment(time).format("hh:mm A");
            } else {
                return moment(time).format("HH:mm:ss");
            }
        },
        timeFormateForDatetime(time) {
            if (this.timeFormat == '12h') {
                return moment(time, "HH:mm:ss").format("hh:mm A");
            } else {
                return moment(time, "HH:mm:ss").format("HH:mm:ss");
            }
        },
        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
        globalShortcutMethod() {
            let instance = this;
            if (instance.shortcutStatus == 1) {
                instance.redirect('/sales');
            }
        },
        find_duplicate_in_array(arra1) {
            let object = {},
                result = [];
            arra1.forEach(function (item) {
                if (!object[item])
                    object[item] = 0;
                object[item] += 1;
            })
            for (let prop in object) {
                if (object[prop] >= 2) {
                    result.push(prop);
                }
            }
            return result;
        },
    }
};
