<template>
    <div class="alerts-container">
        <template v-for="alert in alerts">
            <div class="alert" v-bind:class="{'alert-success':alert.type === 'message', 'alert-warning':alert.type==='warning', 'alert-danger':alert.type==='error','alert-dismissable':!alert.autoclose}" role="alert">
                <span v-html="alert.message"></span>
                <button v-show="!alert.autoclose" type="button" class="close" data-dismiss="alert" aria-label="Close" @click="dismissAlert(alert)">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </template>
    </div>
</template>

<script src="./alerts.js"></script>
