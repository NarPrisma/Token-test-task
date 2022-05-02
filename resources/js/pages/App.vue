<template>
    <div class="app">
        <b-button-group class="mb-2">
            <b-button  variant="info" router-link :to="{ name: 'allTokens'}">All Tokens</b-button>
            <b-button  variant="warning" router-link :to="{ name: 'createToken'}">Create Token</b-button>
        </b-button-group>
    </div>
</template>

<script>


    export default {
        data() {
            return {
            };
        },
        watch: {},
        mounted() {

        },
        methods: {

            }
    }
</script>


<style lang="css" scoped>



</style>
