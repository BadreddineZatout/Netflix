<template>
    <div>
        <!--    filter-->
        <app-filter-with-search :id="id" :options="options" @filteredValue="getFilterValues" @searchValue="getSearchValue"/>

        <!--    calendar-->
        <Calendar :id="id" :options="options" :filtered-data="filterValues" :search-value="searchValue"
                  v-on="$listeners"/>
    </div>
</template>

<script>
    import Calendar from "./Calendar";

    export default {
        name: "AppCalendar",
        components: {Calendar},
        props: {
            options: {
                type: Object,
                require: true
            },
            id: {
                type: String,
                require: true
            }
        },
        data() {
            return {
                filterValues: {},
                searchValue: ''
            }
        },
        methods: {
            getFilterValues(value) {
                this.filterValues = value;
                setTimeout(()=> {
                    this.$hub.$emit('reload-' + this.id);
                });
            },
            getSearchValue(value) {
                this.searchValue = value;
                setTimeout(()=> {
                    this.$hub.$emit('reload-' + this.id);
                });
            }
        }
    }
</script>
