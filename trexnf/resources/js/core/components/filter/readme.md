## Developer guide for `<app-filter/>` component

### Folder Structure

From Laravel Application

- resources
    - js
        - core
            - components
                - filter
                    - Index.Vue

### Register
For `<app-filter/>` component, main Vue component is `Index.Vue`. We had register this component in ```resources/js/core/coreApp.js``` file

```js
    Vue.component('app-filter', require('./components/filter/Index').default);
```

### Components
And we had imports all other components in `resources/js/core/components/filter/Index.Vue`

```js
    import RangeFilter from "./RangeFilter";
    import CheckboxFilter from "./CheckboxFilter";
    import DropDownFilter from "./DropDownFilter";
    import DropdownMenuFilter from "./DropdownMenuFilter";
    import RadioFilter from "./RadioFilter";
    import DateRangeFilter from "./DateRangeFilter";
```

### Props

1. filters :
    - `required`
    - `type` : `Array`
    
### Data

`filterValues` : `{}`

### Computed

1. filterComputed :
    - return : `Object`
    - purpose : To sanitize filter values to use as `HTML` attribute

### Methods

`store` method has store its local state and `$emit` `get-value` event to its parent component

- it has also `$emit` `get-value` event to its parent component
- it accept `v` as a argument which has `v.key` and `v.value`
- it was call upon a event `get-value` called from each `BaseFilter` component


### Usage

```html
    <app-filter :filters="yourArrayOfFilterOptions" @get-values="yourEventHandlerMethod"/>
```

>**Note** :  
>
> - `filters` attribute is required  
> - in dropdown-menu-filter and radio filter you can send `initValue` in filter object
> - when you set initValue it trigger the event `get-values` form child accessed by <app-filter>

###Example

```

<template>
    <div class="col-6 col-sm-8 col-md-9 col-lg-10 col-xl-10">
        <div class="filters-wrapper d-flex justify-content-start flex-wrap">
            <app-filter :filters="filters" @get-values="getFilterValues"/>
        </div>
    </div>

</template>

<script>
    export default {
        name: "Example",
        data() {
            return {
                filters: [
                    {
                        "title": "Select an option",
                        "type": "dropdown-menu-filter",
                        "key": "dropdown-menu",
                        "initValue": 1,
                        "option": [
                            {
                                id: 1,
                                name: 'How many deals were won?',
                                icon: 'award'
                            },
                            {
                                id: 2,
                                name: 'How many deals were lost?',
                                icon: 'frown'
                            },
                            {
                                id: 3,
                                name: 'How many deals were average?',
                            }
                        ],
                        listValueField: 'name'
                     },
                    {
                        "title": "date",
                        "type": "range-picker",
                        "key": "date",
                        "option": ["today", "thisMonth", "last7Days", "nextYear"]
                    },
                    {
                        "title": "sending rate",
                        "type": "range-filter",
                        "key": "sending rate",
                        "maxTitle": "Max usd",
                        "minTitle": "Min usd",
                        "sign": "$"
                        "maxRange": 60,
                        "minRange": 20
                    },
                    {
                        "title": "status",
                        "type": "checkbox",
                        "key": "status",
                        "option": [
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
                        listValueField: 'name'
                    },
                    {
                        "title": "list with segment",
                        "type": "radio",
                        "key": "list-with-segment",
                        "initValue": 1,
                        "header": {
                            "title": "Want to filter your list?",
                            "description": "You can filter your data table which are created based on segment"
                        },
                        "option": [
                            {
                                id: 1,
                                name: "with segment"
                            },
                            {
                                id: 2,
                                name: "without segment"
                            }
                        ],
                        listValueField: 'name'
                    },
                    {
                        "title": "search & select",
                        "type": "drop-down-filter",
                        "key": "search-select",
                        "option": [
                            {id: 1, name: 'Cricket'},
                            {id: 2, name: 'Football'},
                            {id: 3, name: 'Badminton'},
                            {id: 4, name: 'Option 4', disabled: true},
                            {id: 5, name: 'Option 5'},
                            {id: 6, name: 'Option 6'},
                        ],
                        listValueField: 'name'
                    },
                ]
            }
        },
        methods: {
            getFilterValues(values) {
                console.log(values);
            },
        }

    }
</script>

 ```
