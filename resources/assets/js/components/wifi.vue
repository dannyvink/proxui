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
        props: ['addMessage'],
        data() {
            return {
                ssid: '',
                password: '',
                ip_address: null
            }
        },
        methods: {
            save() {
                const ref = this;
                axios.post('/api/wifi', { ssid: this.ssid, password: this.password }).then((response) => {
                    ref.ip_address = response.data.result;
                    this.addMessage({
                        title: 'Success!',
                        message: 'Your Wi-Fi settings have been saved!',
                        type: 'success',
                        duration: 3000
                    });
                }).catch((error) => {
                    console.log(error);
                });
            }
        }
    }
</script>