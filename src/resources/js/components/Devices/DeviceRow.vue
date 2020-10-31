<template>
    <li class="data-row">
        <div class="row">
            <div class="col-md-4">
                <p v-bind:class="{'title':bold_title,'value':!bold_title}">{{title}}</p>
            </div>
            <div class="col-md-8">
                <p class="value" v-bind:class="classes">{{ value }}</p>
            </div>
        </div>
    </li>
</template>

<script>
export default {
    props: ['title','value','bold_title','classes'],
    name: "DeviceRow"
}
</script>

<style scoped>

</style>
