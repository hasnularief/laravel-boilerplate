<script>
	export default {
		props: {
			modalType: {
            	default: '',
        	},
        	mWidth: {

        	},
        	loading:{

        	}
		}
	}
</script>

<template>
	<div class="modal fade" :class='[modalType]'> 
		<div class="modal-dialog" :style="{'min-width': mWidth}"> 
			<div class="modal-content"> 
				<loading v-if="loading" mode="modal"></loading>
				<div class="modal-header"> 
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button> 
					<h4 class="modal-title"><slot name="title">Modal Title</slot></h4>
				</div>
				<div class="modal-body">
					<slot name="body"></slot>
				</div>
				<div class="modal-footer">
					<slot name="footer"> 
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button @click="$emit('save')" type="button" class="btn btn-primary">Save</button>
					</slot>
				</div>
			</div>
		</div>
	</div>	
</template>
