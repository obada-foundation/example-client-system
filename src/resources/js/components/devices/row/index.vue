<template>
    <li class="list-group-item">
        <div class="row">
            <div class="col-md-4">
                <strong>{{ title }}</strong>
            </div>
            <div class="col-md-8">
                {{ value }}
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
