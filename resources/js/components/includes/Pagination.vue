<script>
    export default{
        template: '<ul class="pagination" style="margin:0px 0px 10px" v-if="pagination.last_page > 0" :class="sizeClass"><li v-if="showFirst()" :class="{ \'disabled\' : pagination.current_page <= 1 }"><span v-if="pagination.current_page <= 1"><span aria-hidden="true">{{ config.firstText }}</span></span><a href="#" v-if="pagination.current_page > 1 " :aria-label="config.ariaFirst" @click.prevent="changePage(1)"><span aria-hidden="true">{{ config.firstText }}</span></a></li><li v-if="showPrevious()" :class="{ \'disabled\' : pagination.current_page <= 1 }"> <span v-if="pagination.current_page <= 1"> <span aria-hidden="true">{{ config.previousText }}</span> </span> <a href="#" v-if="pagination.current_page > 1 " :aria-label="config.ariaPrevioius" @click.prevent="changePage(pagination.current_page - 1)"> <span aria-hidden="true">{{ config.previousText }}</span> </a> </li> <li v-for="num in array" :class="{ \'active\': num === pagination.current_page }"> <a href="#" @click.prevent="changePage(num)">{{ num }}</a> </li> <li v-if="showNext()" :class="{ \'disabled\' : pagination.current_page === pagination.last_page || pagination.last_page === 0 }"> <span v-if="pagination.current_page === pagination.last_page || pagination.last_page === 0"> <span aria-hidden="true">{{ config.nextText }}</span> </span> <a href="#" v-if="pagination.current_page < pagination.last_page" :aria-label="config.ariaNext" @click.prevent="changePage(pagination.current_page + 1)"> <span aria-hidden="true">{{ config.nextText }}</span> </a> </li> <li v-if="showLast()" :class="{ \'disabled\' : pagination.current_page === pagination.last_page || pagination.last_page === 0 }"> <span v-if="pagination.current_page === pagination.last_page || pagination.last_page === 0"> <span aria-hidden="true">{{ config.lastText }}</span> </span> <a href="#" v-if="pagination.current_page < pagination.last_page" :aria-label="config.ariaLast" @click.prevent="changePage(pagination.last_page)"><span aria-hidden="true">{{ config.lastText }}</span></a></li></ul>',

        props: {
            pagination: {
                type: Object,
                required: true
            },
            callback: {
                type: Function,
                required: true
            },
            options: {
                type: Object
            },
            size: {
                type: String,
                default: 'small'
            }
        },

        computed: {
        array () {
            let first = '1';
            let last = this.pagination.last_page;

            if (this.pagination.last_page <= 0) {
                return [];
            }

            let from = this.pagination.current_page - this.config.offset;
            if (from < 1) {
                from = 1;
            }

            let to = from + (this.config.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }

            let arr = [];
            //arr.push(first);
            while (from <=to) {
                arr.push(from);
                from++;
            }
            //arr.push(last);
            //console.log(arr);
            return arr;
        },

        config () {
            return Object.assign({
                offset: 2,
                ariaPrevious: 'Previous',
                ariaNext: 'Next',
                ariaFirst: 'First',
                ariaLast: 'Last',
                previousText: '«',
                nextText: '»',
                alwaysShowPrevNext: false,
                alwaysShowFirstLast: false,
                firstText: 'First',
                lastText: 'Last',
            }, this.options);
        },
        
        sizeClass () {
                if (this.size === 'large') {
                    return 'pagination-lg';
                } else if(this.size === 'small') {
                    return 'pagination-sm';
                } else {
                    return '';
                }
            }
        },
        watch: {
            'pagination.per_page' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.callback();
                }
            }
        },
        methods: {
            showPrevious () {
                return this.config.alwaysShowPrevNext || this.pagination.current_page > 1;
            },
            showNext () {
                return this.config.alwaysShowPrevNext || this.pagination.current_page < this.pagination.last_page;
            },
            changePage (page) {
                if (this.pagination.current_page === page) {
                    return;
                }

                this.$set(this.pagination, 'current_page', page);
                this.callback();
            },
            showLast () {
                return this.config.alwaysShowFirstLast || this.pagination.current_page != this.pagination.last_page;
            },
            showFirst () {
                return this.config.alwaysShowFirstLast || this.pagination.current_page != 1;
            }
        }
    }
</script>