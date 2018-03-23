<template>
    <section>
        <div v-if="!connected">
            <div class="card-body text-center">
                Waiting for response from scanner...
            </div>
        </div>
        <div v-if="connected">
            <div class="card-body text-center">
                To begin, place a fob on the scanner and select the type of scan.
            </div>
            <div class="row control-row">
                <div class="col-6 pr-0">
                    <button type="button" class="btn btn-dark btn-lg btn-block" v-on:click="search('lf')">
                        Low Frequency <small class="d-none d-sm-inline">125khz</small>
                    </button>
                </div>
                <div class="col-6 pl-0">
                    <button type="button" class="btn btn-secondary btn-lg btn-block" v-on:click="search('hf')">
                        High Frequency <small class="d-none d-sm-inline">13.56mhz</small>
                    </button>
                </div>
            </div>
            <div class="loader-container" v-if="isScanning">
                <div class="loader">
                    <svg viewBox="25 25 50 50">
                        <circle cx="50" cy="50" r="20" fill="none" stroke="#5cb85c" strokeWidth="2" />
                    </svg>
                </div>
            </div>
            <ul class="list-group">
                <result v-bind:prompt-clone="promptClone" v-bind:result="result" v-for="result, index in results" v-bind:key="index" />
            </ul>
        </div>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                connectionInterval: null,
                connected: false,
                results: [],
                isScanning: false
            }
        },
        props: ['addMessage', 'promptClone'],
        mounted() {
            this.connectToScanner();
            this.connectionInterval = setInterval(() => {
                this.connectToScanner();
            }, 5000);
        },
        methods: {
            connectToScanner() {
                axios.get('/api/scanner/status').then((response) => {
                    if (response.data.connected) {
                        this.connected = true;
                        clearInterval(this.connectionInterval);
                        this.connectionInterval = null;
                    }
                }).catch((error) => {
                    console.log(error);
                });
            },
            search(type) {
                this.isScanning = true;
                this.results = [];
                axios.get('/api/scanner/search/' + type).then((response) => {
                    this.isScanning = false;
                    this.results = response.data;
                    if (this.results.length === 0) {
                        this.addMessage({
                            title: 'No results found!',
                            message: 'Try repositioning your fob on the scanner or try a ' + (type == 'lf' ? 'high' : 'low') + ' frequency scan.',
                            type: 'warning',
                            duration: 3000
                        });
                    }
                }).catch((error) => {
                    this.isScanning = false;
                    this.addMessage({
                        title: 'Oh no!',
                        message: error.response.data.message,
                        type: 'danger',
                        duration: 3000
                    });
                });
            }
        }
    }
</script>

<style scoped>
    .loader-container {
        max-width: 300px;
        margin: 20px auto;
    }
</style>