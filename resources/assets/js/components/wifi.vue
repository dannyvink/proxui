<template>
    <section>
        <input type="text" v-model="ssid" placeholder="SSID" class="form-control form-control-lg" />
        <input type="text" v-model="password" placeholder="Password" class="form-control form-control-lg" />
        <button type="button" class="btn btn-outline-primary btn-lg btn-block" v-on:click="save">Save</button>
        <div class="p-4 text-center" v-if="ip_address">
            <div>Your current IP Address is: <code>{{ ip_address }}</code></div>
        </div>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                ssid: '',
                password: '',
                ip_address: null
            }
        },
        mounted() {
            this.checkExternalIp();
            setInterval(() => {
                this.checkExternalIp();
            }, 10000);
        },
        methods: {
            save() {
                const ref = this;
                axios.post('/api/wifi', { ssid: this.ssid, password: this.password }).then((response) => {
                    ref.checkExternalIp();
                }).catch((error) => {
                    console.log(error);
                });
            },
            checkExternalIp() {
                const ref = this;
                axios.get('https://api.ipify.org?format=json').then((response) => {
                    ref.ip_address = response.data.ip;
                }).catch((error) => {
                    ref.ip_address = null;
                });
            }
        }
    }
</script>