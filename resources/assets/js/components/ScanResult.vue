<template>
    <li class="list-group-item">
        {{ result.type }}
        <button type="button"
                class="float-right btn btn-primary btn-xs"
                data-toggle="modal"
                data-target="#cloneModal"
                v-if="result.cloneable"
                v-on:click="promptClone(result)">Clone</button>
    </li>
</template>

<script>
    export default {
        props: ['result', 'promptClone']
    }
</script>