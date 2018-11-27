<template>
    <div ref="imagePreview" class="modal" @click="closePreview()">
      <img class="modal-content" ref="imageCont" :src="src">
    </div>
</template>

<script>
    export default {
      props: ['src'],    

      methods:{
        showPreview(){
          window.document.body.style.overflowY = 'hidden'
          this.$refs.imagePreview.style.display = 'block'
        },
        
        closePreview(){
          window.document.body.style.overflowY = 'auto'
          this.$refs.imagePreview.style.display = 'none'
        },
      }   
    }
</script>

<style scoped>
  .modal {
      display: none;
      position: fixed;
      z-index: 1212;
      padding-top: 20px;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0,0,0);
      background-color: rgba(0,0,0,0.9);
  }

  .modal-content {
      margin: auto;
      display: block;
      height: 600px;
  }

  .modal-content { 
      animation-name: zoom;
      animation-duration: 0.6s;
  }

  @keyframes zoom {
      from {transform:scale(0)} 
      to {transform:scale(1)}
  }

  @media only screen and (max-width: 700px){
      .modal-content {
          width: 100%;
      }
  }
</style>
