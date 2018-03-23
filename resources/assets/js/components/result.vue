<template>
    <li class="list-group-item">
        <div class="row">
            <div class="col-8">
                <input class="form-control" v-model="entry.name" v-if="editing">
                <span v-if="!editing"><strong>{{ entry.name }}</strong></span>
                <div>
                    {{ entry.type }}
                    <span v-if="entry.name != entry.identifier"> - <code>{{ entry.identifier }}</code></span>
                </div>
            </div>
            <div class="col-4 text-right">
                <button type="button"
                        class="btn btn-outline-secondary"
                        v-if="!editing"
                        v-on:click="startEdit">Edit</button>
                <button type="button"
                        class="btn btn-outline-success"
                        v-if="editing"
                        v-on:click="saveEdit">Save</button>
                <button type="button"
                        class="btn btn-outline-primary"
                        data-toggle="modal"
                        data-target="#cloneModal"
                        v-if="entry.cloneable"
                        v-on:click="promptClone(entry)">Clone</button>
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        props: ['result', 'promptClone'],
        data() {
            return {
                currentEntry: null,
                editing: false,
                originalName: ''
            }
        },
        computed: {
            entry: {
                get() {
                    return this.currentEntry || this.result;
                },
                set(data) {
                    this.currentEntry = data;
                }
            }
        },
        methods: {
            startEdit() {
                this.originalName = this.entry.name;
                this.editing = true;
            },
            saveEdit() {
                this.editing = false;
                if (this.originalName == this.entry.name) return;
                axios.put('/api/history/' + this.entry.id, { name: this.entry.name }).then((response) => {
                    this.entry = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            }
        }
    }
</script>