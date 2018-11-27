<template>
    <div v-if="mode == 'panel'" class="overlay">
      <i class="fa fa-refresh fa-spin" style="z-index: 10000"></i>
    </div>
    <div v-else-if="mode == 'modal'" class="modal-overlay">
    	<i class="fa fa-refresh fa-spin"></i>
    </div>
</template>

<script>
    export default {
    	props: {
    		mode: {
    			default: 'panel'
    		}
    	}
    }
</script>
