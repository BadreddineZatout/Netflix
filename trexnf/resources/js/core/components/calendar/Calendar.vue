<template>
    <div class="card card-with-shadow border-0">
        <div class="card-body p-primary">
            <div class="position-relative">
                <app-overlay-loader v-if="preloader"/>
                <div class="calendar-view" :class="{'loading-opacity': preloader}">

                    <FullCalendar
                            ref="fullCalendar"
                            defaultView="timeGridWeek"
                            :header="header"
                            :plugins="calendarPlugins"
                            :views="views"
                            :events="events"
                            :selectable="true"
                            :editable="options.editable!==false"
                            v-on="listeners"/>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import FullCalendar from '@fullcalendar/vue';
    import dayGridPlugin from '@fullcalendar/daygrid';
    import timeGridPlugin from '@fullcalendar/timegrid';
    import interactionPlugin from '@fullcalendar/interaction';
    import coreLibrary from '../../helpers/CoreLibrary';

    export default {
        name: "Calendar",
        components: {FullCalendar},
        extends: coreLibrary,
        props: {
            options: {
                type: Object,
                require: true
            },
            filteredData: {
                type: Object
            },
            searchValue: {
                type: String
            },
            id: {
                type: String,
                require: true
            }
        },
        data() {
            return {
                calendarPlugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
                header: {
                    left: 'title',
                    center: 'today prev,next',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay',
                },
                views: {
                    dayGridMonth: {
                        titleFormat: {month: 'long', year: 'numeric'},
                        columnHeaderFormat: {
                            weekday: 'short'
                        }
                    },
                    timeGridWeek: {
                        titleFormat: {month: 'long', year: 'numeric'},
                        columnHeaderHtml: function (date) {
                            if (date.getDay() === 1) {
                                let day = date.getDate();
                                return '<div class="fc-calendar-date-name">Mon</div><div class="fc-calendar-day-name">' + day + '</div>';
                            } else if (date.getDay() === 2) {
                                let day = date.getDate();
                                return '<div class="fc-calendar-date-name">Tue</div><div class="fc-calendar-day-name">' + day + '</div>';
                            } else if (date.getDay() === 3) {
                                let day = date.getDate();
                                return '<div class="fc-calendar-date-name">Wed</div><div class="fc-calendar-day-name">' + day + '</div>';
                            } else if (date.getDay() === 4) {
                                let day = date.getDate();
                                return '<div class="fc-calendar-date-name">Thu</div><div class="fc-calendar-day-name">' + day + '</div>';
                            } else if (date.getDay() === 5) {
                                let day = date.getDate();
                                return '<div class="fc-calendar-date-name">Fri</div><div class="fc-calendar-day-name">' + day + '</div>';
                            } else if (date.getDay() === 6) {
                                let day = date.getDate();
                                return '<div class="fc-calendar-date-name">Sat</div><div class="fc-calendar-day-name">' + day + '</div>';
                            } else {
                                let day = date.getDate();
                                return '<div class="fc-calendar-date-name">Sun</div><div class="fc-calendar-day-name">' + day + '</div>';
                            }
                        },
                        weekNumbers: true
                    },
                    timeGridDay: {
                        titleFormat: {day: 'numeric', month: 'long', year: 'numeric'},
                        columnHeaderFormat: {
                            weekday: 'long'
                        }
                    }
                },
                preloader: false,
                events: [],
                filteredValues: {},
                search: null
            }
        },
        computed: {
            listeners() {
                return {
                    ...this.$listeners,
                    select: event => {
                        this.$emit('createEvent', event);
                    },
                    eventClick: event => {
                        this.$emit('selectedEvent', event);
                    },
                    eventResize: event => {
                        this.$emit('eventResize', event);
                    },
                    eventDrop: event => {
                        this.$emit('eventDrop', event);
                    }
                }
            }
        },
        mounted() {
            this.calendarInit();
            this.reloadCalendar();
        },
        methods: {
            calendarInit() {
                this.filteredValues = this.filteredData;
                this.search = this.searchValue;
                this.events = [];
                this.getCalendarEvents();
            },
            getCalendarEvents() {
                let filter = this.filteredValues,
                    reqData = {},
                    url = this.options.url;
                filter.search = this.search;
                reqData.params = filter;
                this.setPreloader(true);
                this.axiosGet(
                    url,
                    reqData
                ).then(response => {
                    this.events = response.data.data;
                }).catch(({response}) => {

                    // trigger after error

                }).finally(() => {
                    this.setPreloader(false);
                });
            },
            reloadCalendar() {
                let name = 'reload-' + this.id;
                this.$hub.$on(name, (value = true) => {
                    if (value) {
                        this.calendarInit();
                    }
                });
            },
            setPreloader(val) {
                this.preloader = val;
            }
        }
    }
</script>

