<template>
    <div class="h-100">
        <div class="card border-0 bg-transparent">
            <div class="card-body p-0">
                <table-without-wrapper :options="options"
                            :id="id"
                            :columns="columns"
                            :filtered-data="filteredData"
                            :search-value="searchValue"
                            @action="getAction"/>
            </div>
        </div>
    </div>
</template>

<script>
    // import coreLibrary from '../../helpers/CoreLibrary';
    import TableWithoutWrapper from "./TableWithoutWrapper";
    import {TableMixin} from "./mixin/TableMixin.js";

    export default {
        name: "TableWithWrapper",

        components: {TableWithoutWrapper},

        mixins: [TableMixin],
    }
</script>
