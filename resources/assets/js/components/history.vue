<template>
    <ul class="list-group">
        <li class="list-group-item text-center" v-if="entries.length == 0 && !loaded">Loading history...</li>
        <li class="list-group-item text-center" v-if="entries.length == 0 && loaded">No entries found!</li>
        <result v-bind:prompt-clone="promptClone" v-bind:result="entry" v-for="entry, index in entries" v-bind:key="index" />
    </ul>
</template>

<script>
    export default {
        props: ['promptClone'],
        data() {
            return {
                entries: [],
                loaded: false,
            }
        },
        mounted() {
            this.loadHistory();
        },
        methods: {
            loadHistory() {
                this.entries = [];
                this.loaded = false;
                axios.get('/api/history').then((response) => {
                    this.entries = response.data;
                    this.loaded = true;
                }).catch((error) => {
                    console.log(error);
                    this.loaded = true;
                    this.entries = [];
                });
            }
        }
    }
</script>