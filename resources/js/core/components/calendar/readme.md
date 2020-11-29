# Developer guide for `<app-calendar/>` component

### Folder Structure

From Laravel Application

- resources
    - js
        - core
            - components
                - calendar
                    - Index.Vue


### Register
For `<app-calendar/>` component, main Vue component is `Index.Vue`. We had register this component in ```resources/js/core/components/coreApp.js``` file

```js
    Vue.component('app-calendar', require('./components/calendar/Index').default);
```

### Components
And we had imports all other components in `resources/js/core/components/calendar/Index.Vue`

```Vue
    import Calendar from "./Calendar";
```
and also used `<app-filter/>` component.
and also used `<app-search/>` component.

### Props
1. options
    - `type` : `object`,  /* contains filters, url etc
    - `required` : `true`
2. id
    - `type` : `string`,
    - `required` : `true`  
### Methods
1. `getFilterValues` get `$emit` from `<app-filter/>` component.
2.  `getSearchValues` get `$emit` from `<app-search/>` component.

### Usages
In the below given how to use `<app-card-view/>` component.

```
<template>
    <div class="content-wrapper">
        <app-calendar id="demo-calendar" :options="options" @createEvent="createEvent" @selectedEvent="selectedEvent"
                      @eventDrop="eventDropValue"
                      @eventResize="eventResizeValue"/>
    </div>
</template>

<script>
    export default {
        name: "TestCalendarView",
        data() {
            return {
                options: {
                    url: 'test-calendar-events',
                    showSearch: true,
                    showFilter: true,
                    filters: [
                        {
                            title: "date",
                            type: "range-picker",
                            key: "date",
                            option: ["today", "thisMonth", "last7Days", "nextYear"]
                        },
                        {
                            title: "sending rate",
                            type: "range-filter",
                            key: "sending rate"
                        },
                        {
                            title: "status",
                            type: "checkbox",
                            key: "status",
                            option: [
                                {
                                    id: 1,
                                    name: "active"
                                },
                                {
                                    id: 2,
                                    name: "invited"
                                },
                                {
                                    id: 3,
                                    name: "subscribed"
                                },
                                {
                                    id: 4,
                                    name: "multiple word",
                                    disabled: true
                                },
                                {
                                    id: 5,
                                    name: "Option 1",
                                    disabled: true
                                },
                                {
                                    id: 6,
                                    name: "Option 2"
                                }
                            ],
                            listValueField: "name"
                        },
                        {
                            title: "list with segment",
                            type: "radio",
                            key: "list-with-segment",
                            header: {
                                title: "Want to filter your list?",
                                description:
                                    "You can filter your data table which are created based on segment"
                            },
                            option: [
                                {
                                    id: 1,
                                    name: "with segment"
                                },
                                {
                                    id: 2,
                                    name: "without segment"
                                }
                            ],
                            listValueField: "name"
                        },
                        {
                            title: "search & select",
                            type: "drop-down-filter",
                            key: "search select",
                            option: [
                                {id: 1, name: "Cricket"},
                                {id: 2, name: "Football"},
                                {id: 3, name: "Badminton"},
                                {id: 4, name: "Option 4", disabled: true},
                                {id: 5, name: "Option 5"},
                                {id: 6, name: "Option 6"}
                            ],
                            listValueField: "name"
                        }
                    ]
                }
            }
        },
        methods: {
            createEvent(arg) {
                // finding calendar data for creating event
                console.log(arg);
            },
            selectedEvent(arg) {
                // get selected event for action
                console.log(arg);
            },
            eventResizeValue(arg) {
                // for event update
                console.log(arg);
            },
            eventDropValue(arg) {
                // for event update
                console.log(arg);
            }
        }
    }
</script>

```

### Methods
   - for reloading calendar component try below methods
    `this.$hub.$emit('reload-' + this.id);`
