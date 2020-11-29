<template>
    <div>
        <div class="note-title d-flex" v-if="showTitle">
            <app-icon :name="'book-open'"/>
            <h6 class="card-title pl-2">{{ title }}</h6>
        </div>
        <div class="note p-4" :class="noteType">
            <p class="m-1" v-if="contentType==='string'" v-for="(note, index) in notes" :key="index">{{ note }}</p>
            <p class="m-1" v-if="contentType==='html'" v-for="(note, index) in notes" :key="index" v-html="note"></p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AppNotes",

        props: {
            title: {
                type: String,
                require: true,
            },
            showTitle: {
                type: Boolean,
                default: true,
            },
            noteType: {
                type: String,
                default: 'note-warning',
            },
            contentType:{
                type: String,
                default: 'string'
            },
            notes: {
                type: Array,
                require: true,
            }
        }
    }
</script>
