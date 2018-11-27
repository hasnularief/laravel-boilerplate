<script>
    export default {
      props: ['width', 'stylex','dialog','locked'],
      data () {
        return {
          style_container: {}
        }
      },

      created () {        
        this.width ? this.$set(this.style_container, 'width', this.width) : this.$set(this.style_container, 'width', 'auto')
        this.stylex && this.stylex['overflow-y'] ? this.$set(this.style_container, 'overflow-y', this.stylex['overflow-y']) : null
      }
    }
</script>

<template>
    <div class="alertify"><div class="dialog"><div><slot name="body"><p class="msg">Apa anda yakin menghapus rekord ini?</p></slot><nav><button v-if="!dialog" class="cancel btn btn-default" tabindex="2"  @click="$emit('close')">Cancel</button><button :disabled="locked" class="ok btn btn-primary" tabindex="1" @click="$emit('submit')">Ok</button></nav></div></div></div>
</template>