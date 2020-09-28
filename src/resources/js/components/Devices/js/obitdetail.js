export default {
    props:['is_mobile','events','usn'],
    data: function () {
        return {
            obit: null,
            isLoading: true
        };
    },
    mounted: function () {
        this.getObit();
    },
    watch: {

    },
    methods: {
        getObit: function(){
            axios.get('/api/internal/obit/'+this.usn, {}).then((response) => {
                if(response.data.status == 0) {
                    console.log(response.data);
                    this.obit = response.data.obit;
                    this.obit.metadata = JSON.parse(this.obit.metadata);
                    this.obit.documents = JSON.parse(this.obit.documents);
                    this.obit.structured_data = JSON.parse(this.obit.structured_data);
                }
            }).catch((e) => {
                if(e.response.hasOwnProperty('errorMessage')) {
                    swal("Error!", e.data.errorMessage, "error");
                } else {
                    swal("Unable To Get Obit!", "We could not find this obit in the database.", "error");
                }
            });
        },
        getKey: function(data){
            var keys = Object.keys(data);
            if(keys) {
                return keys[0];
            }
            return '';
        },
        getValue: function(data){
            var k = this.getKey(data);
            return data[k];
        }
    }
}
