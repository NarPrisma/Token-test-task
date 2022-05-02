<template>
    <div class="StoreToken">
        <div class="container">
            <form @submit.prevent="storeToken">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Token Name</label>
                    <select v-model="form.token_name" v-on:change="changeItem($event)" class="form-control"
                            :class="{ 'is-invalid': submitted && $v.form.token_name.$error }"
                            id="exampleFormControlSelect1">
                        <option v-for="(token, index) in data" :data-index="index" :data-symbol="token.symbol"
                                :key="index">{{ token.name }}
                        </option>
                    </select>
                    <div v-if="submitted && !$v.form.token_name.required" class="invalid-feedback">Please Select Token
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Symbol</label>
                    <input class="form-control" id="disabledInput" type="text" :placeholder="form.symbol" disabled>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Contract address</label>
                    <input v-model="form.contract_address" type="text" class="form-control"
                           id="exampleFormControlInput1" placeholder="Contract address">
                </div>
                <div class="form-group">

                    <label for="exampleFormControlInput1">Count</label>
                    <input v-model.number="form.count" type="text" class="form-control"
                           :class="{ 'is-invalid': submitted && $v.form.count.$error }" id="exampleFormControlInput1"
                           placeholder="Count">
                    <div v-if="submitted && !$v.form.count.required" class="invalid-feedback">Count is required</div>
                    <div v-if="submitted && !$v.form.count.integer" class="invalid-feedback">Count is number</div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Price</label>
                    <input v-model.number="form.price" type="text" class="form-control"
                           :class="{ 'is-invalid': submitted && $v.form.price.$error }" id="exampleFormControlInput1"
                           placeholder="Price">
                    <div v-if="submitted && !$v.form.price.required" class="invalid-feedback">Price is required</div>
                    <div v-if="submitted && !$v.form.price.integer" class="invalid-feedback">Price is number</div>
                </div>

                <button class="btn btn-primary mt-3"> Create Token</button>
            </form>


        </div>
    </div>
</template>

<script>

import {required, integer} from "vuelidate/lib/validators";

export default {
    name: "StoreToken",

    data() {
        return {
            data: [],
            submitted: false,
            form: {
                token_name: "",
                symbol: this.selected,
                contract_address: "",
                count: "",
                price: "",
                index: null,
            }
        }
    },
    validations: {
        form: {
            token_name: {required},
            count: {required, integer},
            price: {required, integer},
        }
    },
    mounted() {
        this.getToken()
    },

    methods: {
        async getToken() {
            await axios.get("/allTokens").then(response => {
                this.data = response.data.data
            }).catch(error => {
                this.$alert("Something went wrong");
            })

        },

        async storeToken() {
            this.submitted = true;
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }

            await axios.post('/create/token', this.form)
                .then((res => {
                    this.$router.push({name: 'allTokens'})
                    this.$alert("Token has been created successfully");
                }))
                .catch((error => {
                    this.$alert("Please try again.");
                }))
        },
        changeItem: function changeItem(event) {
            this.form.index = event.target.options[event.target.options.selectedIndex].dataset.index
            this.form.symbol = event.target.options[event.target.options.selectedIndex].dataset.symbol;
        }
    },
}
</script>

<style scoped>
 .form-group {
     margin-top: 10px !important;
 }

</style>
