<template>
	<select2 v-model="model" :api="api"></select2>
</template>
<script>
	export default {
		props: {
			value: {

			}
		},

		watch:{
			model(val){
				console.log(val)
				this.$emit('input', this.model)
			}
		},

		data() {
			return {
				api: _HOST + 'api/user?req=get_user',
				model: null
			}
		},

		created() {
			this.model = this.value
		}
	}
</script>