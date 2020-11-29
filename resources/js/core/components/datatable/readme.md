# Developer guide for `<app-table/>` component

### Components
And we had imports all other components in `resources/js/core/components/datatable/Index.Vue`

```Vue
    import DataTable from "./DataTable";
    import ManageColumns from "./ManageColumns";
```
and also used `<app-filter/>` component. [click here](../filter/readme.md)


### Props

1. id
    - `type` : `String`,
    - `required` : `true`
2. options
    - `type` : `Object`,
    - `required` : `true`

### Methods

1. `getColumnsOptions` get `$emit` from `<manage-columns/>` component.
2. `getFilterValues` get `$emit` from `<app-filter/>` component.

### Reload Datatable form any where.
* Can use after 

```
    this.$hub.$emit('reload-'+tableId);
```

### Available options in datatable
1. id
    - `type` : `String`
    - The option `id` is is uniquely identified a table.
2. name
    - `type` : `String`
    - Every table has a `name` option.
3. columns
    - `type` : `Array of Object`
    - This options specifies the columns of a table. Available columns type -
    - ```HTML
      {
          title: 'Invoice',                   // This is a link type column
          type: 'link',
          key: 'invoice',
          isVisible: true,
          modifier: (value, row) => {
            return `test/${row.invoice}/test`;
            }
      },
      {
          title: 'name',                      // This is a text type column
          type: 'text',
          key: 'name'
      },
      {
          title: 'Image',                     // Image type column
          type: 'image',
          key: 'image',
          altText: "No found",
          className: "avatars-group-w-50",
          default: "default image url",
          isVisible: true
      },
      {
          title: 'User',                      // This is a media object type column
          type: 'media-object',
          key: 'profile_picture',
          mediaTitleKey: 'name',        // key for titile
          mediaSubtitleKey: 'email',       // key for sub titile
          default: "default image url",
          isVisible: true,
          modifier:(value, row)=>{
            return value ; // imag url 
         }
      },
      {
          title: 'component',                 // Component type column
          type: 'component',
          key: 'users',
          isVisible: true,
          componentName: 'test-avatar-group',
      },
      {
          title: 'status',                    // custom-class type column
          type: 'custom-class',
          key: 'status',
          isVisible: true,
          modifier: (value) => {
              if (value === 'Active') return "badge badge-pill badge-primary";
              return "badge badge-pill badge-danger";
          }
      },
      {
          title: 'status 2',                  // custom-html type column
          type: 'custom-html',
          key: 'status2',
          isVisible: false,
          modifier: (value) => {
              if (value === 'Active') return `<h1>${value}</h1>`;
              return `<h2>${value}</h2>`;
          }
      },
      {
          title: 'user',                      // object type column
          type: 'object',
          key: 'created_by',
          modifier: (value, row) => {
              return value.first_name+' '+value.last_name
          }
      },
      {
            title: 'Dynamic Content',
            type: 'dynamic-content',
            key: 'name',
            label: 'click me',
            icon: 'check',
            className: 'btn btn-success',
            modifier: (value, row) => {
                return{
                    isValue: false,
                    value: 'dynamic-contnent/'+row.invoice
                    // value: row.invoice
                }
            }
      },
      {
          title: 'Age',               //Button type column
          type: 'button',
          key: 'age',
          sortable: true,
          className: 'btn btn-success',
          // icon: 'check',
          label: 'click me',
          isVisible: true,
          modifier: (value, row) => {
              return 'Manage button'  // whatever you return is consider as button label excepts Boolean `false` 
          }                           // if You return false it will hide the button else all are will be consider as button label
      },
      {
          title: 'Action',                    // Action type column
          type: 'action',
          key: 'invoice',
          isVisible: true
      },
      ```
4. showHeader
    - `type` : `Boolean`
    - Default value `true`
    - By giving this option `showHeader` value `true/false` you can show or hide the table header.      
5. url
    - `type` : `String`
    - Under this option you have to put the url where from. 
6. showSummary
    - `type` : `Boolean`
    - Default value `false`
    - This option `showSummery` use for showing table summery of a table. 
7. orderBy
    - `type` : `String`
    - Default value `DESC`
    - `orderBy` option used to sort the table in ascending or descending order.
8. numberFormat
    - `type` : `Array`
    - `numberFormat` option used to sort the table in ascending or descending order.
9. dateFormat
    - `type` : `Array`
    - `dateFormat` use to show the dates in specific format.
10. rightAlign
    - `type` : `Array`
    - `rightAlign` option takes an array of columns which we needs to show right align in a  table.
11. summation
    - `type` : `Array`
    - `summation` option takes an array of columns which show the summation of the column.
12. summationKey
    - `type` : `String`
    - `summationKey` is an unique key which need to show the summation result of a column.
13. showFilter
    - `type` : `Boolean`
    - Default value `true`
    - This option takes a boolean value to show or hide filters from a datatable.
14. datatableType
    - `type` : `String`
    - Default value `default`
    - There are two datatable type available in `datatableType` option `default/cardView`. `default` type shows all the filters outside of the table card and `cardView` type shows the filters inside the table card.
15. showSearch
    - `type` : `Boolean`
    - Default value `true`
    - `showSearch` option used to show or hide the search filter.
16. filters
    - in dropdown-menu-filter and radio filter you can send `initValue` in filter object
    - when you set initValue it trigger the event `getFilteredValues` form child. can be access from `<app-table>`
    - `type` : `Array of Object`
    - This options specifies the filters of a table. Available keys in a 'filters' is
    - ```HTML
      {
           "title": "String",         // Here goes the title of the filter
           "key": "String",           // filter key
           "type": "String",          // Type of the filter (range-picker/range-filter/checkbox/radio/drop-down-filter/)
           "option": "Array",         // Takes the filter options
       }
      ``` 
    - Available type of filters with example
    ```HTML 
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
        "title": "date",                        // rage-picker type filter
        "type": "range-picker",
        "key": "date",
        "option": ["today", "thisMonth", "last7Days", "nextYear"]
    },
    {
        "title": "sending rate",                // range-filter type filter
        "type": "range-filter",
        "key": "sending rate",
        "maxTitle": "Max usd",
        "minTitle": "Min usd",
        "sign": "$"
    },
    {
        "title": "status",                      // checkbox type filter
        "type": "checkbox",
        "key": "status",
        "option": ["active", "subscribed", "multiple word", "invited", "adfsd", "adsfdsf"]
    },
    {
        "title": "list with segment",           // radio type filter
        "type": "radio",
        "key": "list-with-segment",
        "header": {
            "title": "Want to filter your list?",
            "description": "You can filter your data table which are created based on segment"
        },
        "option": ["with segment", "without segment"]
    },
    {
        "title": "Tab filter",                  // tab-filter type filter
        "type": "tab-filter",
        "key": "tab-filter",
        "option": [
            {id: 1, value: 'All user'},
            {id: 2, value: 'Active'},
            {id: 3, value: 'Inactive'},
            {id: 4, value: 'Invited'},
        ],
    }
    ``` 
17. tablePaddingClass
    - `type` : `String`
    - Default value `p-primay`
    - This options used to padding of table container

17. tableShadow
    - `type` : `Boolean`
    - Default value `true`
    - This options used to shadow of table container
    
17. enableRowSelect
    - `type` : `Boolean`
    - This options used to enable multiple row selection of table. if true.
    - emit `getRows` for the row which are selected.
17. showAction
    - `type` : `Boolean`
    - Default value `true`
    - This options used to show/hide the action buttons in a table 
18. actionType
    - `type` : `String`
    - Two type of action button available in datatable. One is `default` which gives a group of actions with icon view and another one is `dropdown` which give a dropdown action button.
19. actions
    - `type` : `Array`
    - `action` option takes an array of action button, Available keys in a action is-
    ```HTML
    {
        title: 'String',
        icon: 'icon-name',
        type: 'page',
        component: 'test-modal',
        url: 'edit-test',
        uniqueKey: 'String',
        className: 'btn-primary',
        modifier: (row) => {
            return true //for show this action or not.
        }
    }
    ```  
    - Action buttons example
    ```HTML
    
    {
        title: 'Edit',
        icon: 'edit',
        type: 'page',
        component: 'test-modal',
        url: 'edit-test',
        uniqueKey: 'invoice',
    }, {
        title: 'Delete',
        icon: 'trash',
        component: 'test-modal',
        type: 'page',
        url: '',
    },
    {
        title: 'Active',
        modifier: (row) => {
            if (row.status === 'Inactive') {
                return true
            }
        }
    },
    {
        title: 'Inactivate',
        modifier: (row) => {
            if (row.status === 'Active') {
                return true
            }
        }
    }
    ```             
    
### Useges
In the below given how to use `<app-table/>` component.

1. Table With Wrapper

```HTML
<template>
    <div class="content-wrapper">

        <app-breadcrumb :page-title="'Test Table'" :icon="'settings'" :directory="'Datatable'"/>
        <app-table :id="'test-table'" :options="options" @action="getAction" @getRows="getSelectedRows"/>

    </div>
</template>

<script>

    export default {
        name: "Example",

        data() {
            return {
                options: {
                    name: 'TestTable',
                    url: 'test-value',
                    showHeader: true,
                    columns: [
                        {
                            title: 'Invoice',
                            type: 'link',
                            key: 'invoice',
                            sortAble: true,
                            isVisible: true,
                            modifier: (value, row) => {
                                return `test/${row.invoice}/test`;
                            }
                        },
                        {
                            title: 'name',
                            type: 'text',
                            key: 'name'
                        },
                        {
                            title: 'age',
                            type: 'text',
                            key: 'age',
                            isVisible: true
                        },
                        {
                            title: 'Image',
                            type: 'image',
                            key: 'image',
                            altText: "No found",
                            className: "avatars-group-w-50",
                            default: "https://images.unsplash.com/photo-1537815749002-de6a533c64db?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1090&q=80"
                        },
                        {
                            title: 'Media Object',
                            type: 'media-object',
                            key: 'image',
                            mediaTitleKey: 'name', 
                            mediaSubtitleKey: 'email',
                            default: "https://images.unsplash.com/photo-1537815749002-de6a533c64db?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1090&q=80",
                            isVisible: true,
                            modifier:(value, row)=>{
                                return value ; // img url 
                            }
                        },
                        {
                            title: 'Dynamic Content',
                            type: 'dynamic-content',
                            key: 'name',
                            label: 'click me',
                            icon: 'check',
                            className: 'btn btn-success',
                            modifier: (value, row) => {
                                return{
                                    isValue: false,
                                    value: 'dynamic-contnent/'+row.invoice
                                    // value: row.invoice
                                }
                            }
                        },
                        {
                            title: 'component',
                            type: 'component',
                            key: 'users',
                            isVisible: true,
                            componentName: 'test-avatar-group',
                        },
                        {
                            title: 'status',
                            type: 'custom-class',
                            key: 'status',
                            isVisible: true,
                            modifier: (value) => {
                                if (value === 'Active') return "badge badge-pill badge-primary";
                                return "badge badge-pill badge-danger";
                            }
                        },
                        {
                            title: 'status 2',
                            type: 'custom-html',
                            key: 'status2',
                            isVisible: false,
                            modifier: (value) => {
                                if (value === 'Active') return `<h1>${value}</h1>`;
                                return `<h2>${value}</h2>`;
                            }
                        },
                        {
                            title: 'user',
                            type: 'object',
                            key: 'created_by',
                            modifier: (value, row) => {
                                return value.first_name + ' ' + value.last_name
                            }
                        },
                        {
                            title: 'Action',
                            type: 'action',
                            key: 'invoice',
                            isVisible: true
                        },
                    ],
                    filters: [
                        {
                            "title": "date",
                            "type": "range-picker",
                            "key": "date",
                            "option": ["today", "thisMonth", "last7Days", "nextYear"]
                        },
                        {
                            "title": "sending rate",
                            "type": "range-filter",
                            "key": "sending rate"
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
                            "key": "search select",
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
                       
                    ],
                    showSearch: true,
                    showFilter: true,
                    paginationType: "pagination",
                    responsive: true,
                    rowLimit: 10,
                    showAction: true,
                    orderBy: 'desc',
                    actionType: "dropdown",
                    actions: [
                        {
                            title: 'Edit',
                            icon: 'edit',
                            type: 'page',
                            component: 'test-modal',
                            url: 'edit-test',
                            uniqueKey: 'invoice',
                            className: 'btn-primary',
                        }, {
                            title: 'Delete',
                            icon: 'trash',
                            component: 'test-modal',
                            type: 'page',
                            url: '',
                        },
                        {
                            title: 'view',
                            icon: 'trash',
                            type: 'none',
                            url: '',
                        }
                    ],
                }
            }
        },

        methods: {
            getAction(rowData, actionObj, active) {
                console.log(rowData, 'row');
                console.log(actionObj, 'actionObj');
                console.log(active, 'active');
            }
        }
    }
</script>

```


2. Table Without Wrapper

```HTML
<template>
    <div class="content-wrapper">
        <app-breadcrumb :page-title="'Test Table'" :icon="'settings'" :directory="'Datatable'"/>
        <div class="card border-0 bg-transparent">
          
             <div class="card-header d-flex align-items-center p-primary primary-card-color">

                <h4 class="card-title d-inline-block mb-0">Table name</h4>
                <app-search @input="getSearchValue"/>

            </div>
            <div class="card-body p-0">
                <app-table :id="tableId" :options="options" :filtered-data="filteredData" :search="search" @action="getAction"/>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "NewExampleWithoutWrapper",

        data() {
            return {
                tableId: 'test-table',
                filteredData: {},
                search: '',
                options: {
                    name: 'TestTable',
                    url: 'test-value',
                    datatableWrapper: false,
                    showHeader: true,
                    columns: [
                        {
                            title: 'Invoice',
                            type: 'link',
                            key: 'invoice',
                            sortAble: true,
                            isVisible: true,
                            modifier: (value, row) => {
                                return `test/${row.invoice}/test`;
                            }
                        },
                        {
                            title: 'name',
                            type: 'text',
                            key: 'name'
                        },
                        {
                            title: 'age',
                            type: 'text',
                            key: 'age',
                            isVisible: true
                        },
                        {
                            title: 'Action',
                            type: 'action',
                            key: 'invoice',
                            isVisible: true
                        },
                    ],
                    showFilter: false,
                    paginationType: "pagination",
                    responsive: true,
                    rowLimit: 10,
                    orderBy: 'desc',
                    actionType: "dropdown",
                    actions: [
                        {
                            title: 'Edit',
                            icon: 'edit',
                            type: 'page',
                            component: 'test-modal',
                            url: 'edit-test',
                            uniqueKey: 'invoice',
                            className: 'btn-primary',
                        }, {
                            title: 'Delete',
                            icon: 'trash',
                            component: 'test-modal',
                            type: 'page',
                            url: '',
                        },
                        {
                            title: 'view',
                            icon: 'trash',
                            type: 'none',
                            url: '',
                        }
                    ],
                }
            }
        },

        methods: {
            getSelectedRows(value){
                 // do your operation with selected rows
                console.log(value);
            }
            getAction(rowData, actionObj, active) {
                console.log(rowData, 'row');
                console.log(actionObj, 'actionObj');
                console.log(active, 'active');
            },
            getSearchValue(value){
                let instance = this;
                this.search = value;
                setTimeout(function(){
                    instance.$hub.$emit('reload-'+instance.tableId);
                });
            },
        }
    }
</script>

```

# Describe Related Components

## <manage-columns/>

### Components

```Vue
    import FilterAction from "../filter/FilterAction";
    import draggable from 'vuedraggable'; // for drag the column list
```

### Mixin

```Vue
    import {FilterMixin} from "../filter/mixins/FilterMixin"; // common mixin for filters
```

### Props

1. manageOption
    - `type` : `Array`,
    - `required` : `true`

### Methods

1. `dragstart` 
2. `dragend`
3. `clear` reset to previous order.
4. `applyColumnSort` send data to parent component. 



## `<data-table/>` 

### Components

```Vue
    import Action from "./Action";  //common action component for datatable
```

### Props

1. options
    - `type` : `Object`,
    - `required` : `true`
2. columns
    - `type` : `Array`,
    - `required` : `true`
3. filteredData
    - `type` : `Object`,

### Methods

1. `dataTableInit` rest data table for init rander
2. `getDataSet` get data from database
3. `configureTableForLoadMore` when paginationType is loadMore. 
4. `configureTableForPagination` when paginationType is pagination.
5. `setPreloader` set the preloader value.
6. `reloadDataTable` reload the table.
7. `loadMoreSubmit` when click in loadMore button.
8. `paginationSubmit` when click in pagination button.

