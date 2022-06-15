require('../../../../../vendor/codemirror/lib/codemirror.js');
require('../../../../../vendor/codemirror/mode/javascript/javascript.js');
require('../../../../../vendor/codemirror/mode/css/css.js');
require('../../../../../vendor/codemirror/addon/hint/show-hint.js');
require('../../../../../vendor/codemirror/addon/hint/css-hint.js');
require('../../../../../vendor/codemirror/addon/hint/javascript-hint.js');

import Vue from "vue";
import VueCodemirror from 'vue-codemirror';

Vue.use(VueCodemirror, /* {
  options: { theme: 'base16-dark', ... },
  events: ['scroll', ...]
} */);

window.beautifyJS = require('js-beautify').js_beautify

export default {
    props: ['structured_data'],
    name: "StructuredDataRow",
    data: function () {
        return {
            rows: [],
            cmOptions: {
                // codemirror options
                tabSize: 2,
                mode: 'json',
                theme: 'base16-light',
                lineNumbers: true,
                line: true,
                autoRefresh: true,
                readOnly: true
                // more codemirror options, 更多 codemirror 的高级配置...
            },
        }
    },
    mounted: function(){
        //this.parseData();
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
