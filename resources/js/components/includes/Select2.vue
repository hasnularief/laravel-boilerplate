<template>
  <select style="width:100%">
    <slot></slot>
  </select>
</template>
<script>
  export default {
    props: ['options', 'value','api', 'placeholder','dropdownsize'],

    computed: {
      dropdownCssClass() {
        if(this.dropdownsize == 'big')
          return 'bigdropdown'
        else
          return ''
      }
    },

    mounted: function () {
      const vm = this

      if(this.api){
        $(this.$el)
        // init select2
        .select2({ 
          dropdownCssClass: vm.dropdownCssClass,
          placeholder: vm.placeholder,
          data: this.value,
          minimumInputLength: 3,
          ajax:{
            url: this.api, 
            delay: 250,
            data: function (params){
              return {
                search: params.term
              }
            },
            processResults: function(data){
              return {
                results: data
              };
            },
          }
        })
        .val(this.value)
        .trigger('change')
        // emit event on change.
        .on('change', function () {
          vm.$emit('input',  $(this).val()) // multiple select
        })
      }
      else{
        // console.log(vm.dropdownCssClass)
        $(this.$el)
        // init select2
        .select2({ data: vm.options, placeholder: vm.placeholder, 
          dropdownCssClass: vm.dropdownCssClass
          })
        .val(this.value)
        .trigger('change')
        // emit event on change.
        .on('change', function () {
          vm.$emit('input',  $(this).val()) // multiple select
        })
      }
      
    },
    watch: {
      api: function(){
        const vm = this
        $(this.$el)
        // init select2
        .select2({ 
          data: this.value,
          ajax:{
            url: this.api, 
            delay: 250,
            data: function (params){
              return {
                search: params.term
              }
            },
            processResults: function(data){
              return {
                results: data
              };
            } 
          }
        })
        .val(this.value)
        .trigger('change')
        // emit event on change.
        .on('change', function () {
          vm.$emit('input',  $(this).val()) // multiple select
        })
      },
      value: function (value) {
        // update value
        var vm = this

        if(Array.isArray(value)) {
          if ([...value].sort().join(",") !== [...$(this.$el).val()].sort().join(","))
               $(this.$el).val(value).trigger('change');
                vm.$emit('change');
        }
        else {
          $(this.$el).val(value).trigger('change'); 
          vm.$emit('change'); 
        }

      },
      options: function (options) {
        // update options
        const vm = this
        $(this.$el).empty().trigger('change')
        $(this.$el).select2({ data: options }).val([]).trigger('change')
        vm.$emit('change'); 
      }
    },
    destroyed: function () {
      $(this.$el).off().select2('destroy')
    }
  }
</script>