export default {
    props:['is_mobile','events', 'user', 'alerts'],
    data: function () {
        return {

        };
    },
    mounted: function () {

    },
    watch: {

    },
    methods: {
        dismissAlert: function(alert){
            this.$emit('dismissalert',alert);
        }
    }
}
