<template>
    <li class="data-row">
        <ul v-if="rows.length > 0" class="sub-list">
            <template v-for="data in rows">
                <li v-if="data.type === 'data-row'" class="data-row" >
                    <div class="row">
                        <div class="col-md-4">
                            <p class="value">{{data.key}}</p>
                        </div>
                        <div class="col-md-8">
                            <p class="value">{{data.value }}</p>
                        </div>
                    </div>
                </li>
            </template>
        </ul>



    </li>
</template>

<script>
export default {
    props: ['structured_data'],
    name: "StructuredDataRow",
    data: function () {
        return {
            rows: []
        }
    },
    mounted: function(){
        this.parseData();
    },
    methods: {
        parseData: function(){
            console.log(this.structured_data);
            if(typeof this.structured_data === 'array') {

            } else if (typeof this.structured_data === 'object') {
                var keys = Object.keys(this.structured_data);
                keys.forEach((k)=>{
                    var value = this.structured_data[k];
                    if(typeof value === 'object' || typeof value === 'array') {

                    } else {
                        this.rows.push({
                            "type":"data-row",
                            "key":k,
                            "value":value
                        });
                    }
                });
            }
        }
    }
}
</script>

<style scoped>

</style>
