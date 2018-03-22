<template>
    <section>
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
            <ScanResult v-bind:result="result" v-for="result, index in results" v-bind:key="index" />
        </ul>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                results: [],
                isScanning: false
            }
        },
        methods: {
            search(type) {
                this.isScanning = true;
                this.results = [];
                axios.get('/api/scanner/search/' + type).then((response) => {
                    this.isScanning = false;
                    this.results = response.data;

                    if (this.results.length === 0) {
                        // TODO: Add message for no fobs found.
                    }
                }).catch((error) => {
                    this.isScanning = false;
                    console.log(error);
                    alert(error.response.data.message);
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