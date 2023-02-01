<template>
    <div class="d-sm-flex align-items-center">
        <div v-show="!isEdit" class="pt-1 pb-1">
            <span>{{ accountName }}</span>
            <button v-on:click="switchEdit" class="btn btn-link btn-icon text-decoration-none">
                <i v-if="accountName !== ''" class="fas fa-pen"></i>
                <span v-if="accountName === ''">Add Name</span>
            </button>
        </div>
        <div v-show="isEdit" class="input-group" style="max-width: 325px;">
            <input type="text" maxlength="30" class="form-control"
                   v-model="accountName"
                   @keyup="handleInputChange()">
            <button v-on:click="saveAccountName" class="btn btn-primary" :disabled="isBusy">
                <span v-show="isBusy" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Save
            </button>
        </div>
        <div v-if="hasError" class="text-danger ms-sm-3 mt-2 mt-sm-0" style="line-height: 1.15;">{{ errorMessage }}</div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: [
            'saveNameUrl',
            'name'
        ],
        data: function () {
            return {
                isButtonDisabled: false,
                accountName: '',
                isEdit: false,
                isBusy: false,
                hasError: false,
                errorMessage: ''
            }
        },
        mounted: function() {
            this.accountName = this.name;
        },
        methods: {
            switchEdit: function() {
                this.isEdit = !this.isEdit;
            },
            handleInputChange: function() {
                this.hasError = false;
            },
            saveAccountName: function() {
                this.isBusy = true;

                axios(this.saveNameUrl, {
                    method: 'post',
                    responseType: 'json',
                    data: {
                        name: this.accountName
                    }
                })
                .then(response => {
                    this.isBusy = false;
                    this.switchEdit();
                    document.querySelector('.breadcrumb-item.active').innerHTML = this.accountName;
                })
                .catch(e => {
                    this.isBusy = false;
                    this.hasError = true;

                    this.errorMessage = e.response && e.response.data.errorMessage
                        ? e.response.data.errorMessage
                        : 'Error while saving new account name. Please, try again later.';
                });
            }
        }
    }
</script>
