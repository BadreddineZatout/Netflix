<template>
    <div>
        <div class="dropdown d-inline-block btn-dropdown">
            <button type="button"
                    class="btn btn-light dropdown-toggle ml-0 mr-2"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                {{ title }}
            </button>
            <div class="dropdown-menu">

                <div v-for="(item, index) in data" :key="index">
                    <a v-if="item.url || item.name || item.icon" :href="item.url">
                    <span class="dropdown-item dropdown-title">
                        <app-icon :name="item.icon" class="primary-text-color mr-3"/>
                        {{item.name}}
                    </span>
                    </a>

                    <div v-if="item.url || item.name || item.icon" class="dropdown-divider"></div>

                    <a v-if="item.data.length > 0" class="dropdown-item" v-for="(smItem, index) in item.data"
                       :key="index" :href="smItem.url">

                        <div class="d-flex align-items-center">
                            <img v-if="smItem.img" :src="smItem.img"
                                 alt="" width="40" class="rounded-circle img-fluid">
                            <span class="ml-3">{{ smItem.name }}</span>
                        </div>

                    </a>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AppDropdownMenu",
        props: {
            title: {
                type: String,
                required: true
            },
            data: {
                type: Array,
                required: true
            }
        },
    }
</script>
