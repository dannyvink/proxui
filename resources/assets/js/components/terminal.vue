<template>
    <section>
        <div id="terminal-container">
            <pre v-for="line, index in lines" v-bind:key="index">{{ line }}</pre>
        </div>
        <input type="text" v-model="input" v-on:keyup.enter="onInputSubmit()" />
    </section>
</template>

<script>
    export default {
        data() {
            return {
                lines: [],
                input: ''
            }
        },
        methods: {
            onInputSubmit() {
                var input = this.input;
                this.input = '';
                axios.post('/api/terminal', { input: input }).then((response) => {
                    this.lines.push(response.data.result);
                    var ref = this;
                    setTimeout(function() {
                        ref.scrollToLatest();
                    }, 1);
                }).catch((error) => {
                    console.log(error);
                });
            },
            scrollToLatest() {
                var container = document.getElementById('terminal-container');
                container.scrollTop = container.scrollHeight;
            }
        }
    }
</script>

<style scoped>
    #terminal-container {
        height: 300px;
        background: #222;
        padding: 10px;
        overflow: auto;
    }

    pre {
        font-size: 12px;
        color: #ccc;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        overflow-y: visible;
        white-space: pre-wrap;
    }

    input {
        background: #333;
        width: 100%;
        border: 0;
        border-top: 1px solid #111;
        color: #ccc;
        padding: 5px;
        font-size: 12px;
    }
</style>