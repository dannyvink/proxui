<template>
    <section>
        <div v-if="!rebooting">
            <input type="text" v-model="ssid" placeholder="SSID" class="form-control form-control-lg" />
            <input type="text" v-model="password" placeholder="Password" class="form-control form-control-lg" />
            <button type="button" class="btn btn-outline-primary btn-lg btn-block" v-on:click="save">Save</button>
            <div class="card-body text-center" v-if="ip_address">
                Your current IP Address is: <code>{{ ip_address }}</code>
            </div>
        </div>
        <div v-if="rebooting" class="card-body text-center" v-bind:title="lastRebootCheck">
            The device is rebooting...
        </div>
    </section>
</template>

<script>
    export default {
        props: ['addMessage'],
        data() {
            return {
                rebooting: false,
                checkInterval: null,
                ssid: '',
                password: '',
                ip_address: null,
                lastRebootCheck: Date.now()
            }
        },
        mounted() {
            this.getIp();
        },
        methods: {
            getIp() {
                const ref = this;
                axios.get('/api/ip').then((response) => {
                    ref.ip_address = response.data.result;
                }).catch((error) => {
                    ref.ip_address = null;
                });
            },
            save() {
                const ref = this;

                this.rebooting = true;
                this.checkInterval = setInterval(() => {
                    axios.get('/').then((response) => {
                        clearInterval(ref.checkInterval);
                        ref.checkInterval = null;
                        ref.rebooting = false;
                        ref.addMessage({
                            title: 'Success!',
                            message: 'Your Wi-Fi settings have been saved!',
                            type: 'success',
                            duration: 3000
                        });
                    }).catch((error) => {
                        ref.lastRebootCheck = Date.now();
                    })
                }, 10000);

                axios.post('/api/wifi', { ssid: this.ssid, password: this.password }).then((response) => {                   
                    ref.addMessage({
                        title: 'Uh oh!',
                        message: 'Rebooting the device failed! Please manually reboot.',
                        type: 'error',
                        duration: 3000
                    });
                }).catch((error) => {
                    if (error.response.status != 502) {
                        console.log(error);
                        ref.addMessage({
                            title: 'Uh oh!',
                            message: 'Something unexpected happened! Check the console log for details.',
                            type: 'error',
                            duration: 3000
                        });
                    } else {
                        console.log('The device is rebooting...');
                    }
                });
            }
        }
    }
</script>
