<template>
  <div class="input-group">
    <date-picker :wrap="true" :config="date_config" v-model="moment"></date-picker>
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
  </div>
</template>

<script>
  export default {
  	props: {
      id: {

      },
      value: String,
      enter: {
        type: Function,
        default: function() {
          return null
        }
      },
      alias: {
        type: String,
        default: 'date'
      },
      viewFormat: {
        type: String
      },
      modelFormat: {
        type: String
      }
    },

    data() {
      return {
        model: 'YYYY-MM-DD',
        view: 'DD/MM/YYYY',
        date_config : {
          format           : 'DD/MM/YYYY',
          useCurrent       : false,
          useStrict        : true,
          allowInputToggle : true,
          sideBySide       : true,
          // inline : true,
        },
        wrap : true,
      }
    },

    created() {
      if(this.alias == 'date'){
        this.model = 'YYYY-MM-DD'
        this.view = 'DD/MM/YYYY'
        this.date_config.format = 'DD/MM/YYYY'
      }
      else if(this.alias == 'datetime') {
        this.model = 'YYYY-MM-DD HH:mm:ss'
        this.view = 'DD/MM/YYYY HH:mm' 
        this.date_config.format = 'DD/MM/YYYY HH:mm'
      }

      if(this.modelFormat)
        this.model = this.modelFormat

      if(this.viewFormat){
        this.view = this.viewFormat
        this.date_config.format = this.viewFormat
      }
    },

    computed: {
      moment: {
        get: function() {
          const vm = this
          if(moment(this.value, this.model, true).isValid()){
            return moment(this.value, this.model).format(this.view)
          }
          else if(moment(this.value, this.view, true).isValid()){
            vm.$emit('input', moment(this.value, this.view).format(this.model))
          }

        },
        set: function(val) {
          if(moment(val, this.view, true).isValid())
            this.$emit('input', moment(val, this.view).format(this.model))
          else
            this.$emit('input', '')
        }
      }
    },
    methods:{

    }
  }
</script>
<style>

</style>