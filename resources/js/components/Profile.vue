<template>
	<div>
		<!-- Content Header (Page header) -->
		<content-header 
		title="Ganti Profile" 
		subtitle="Update Profile" 
		:breadcrumb='{
		icon:"fa fa-dashboard",
		path: ["Home", "Update Profile"]
	}'></content-header>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="row">
			<div class="col-md-6">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Akun Anda</h3>
					</div>
					<div class="box-body">
						<div class="form">
							<div class="form-group">
			                  <label>Nama</label>
			                  <input type="text" class="form-control" :value="me.name">
			                </div>
			                <div class="form-group">
			                  <label>Email</label>
			                  <input type="text" class="form-control" :value="me.email">
			                </div>
			                <div class="form-group">
			                  <label>Role</label>
			                  <input type="text" class="form-control" :value="role_name">
			                </div>
			                <div class="form-group">
			                  <label>Member since</label>
			                  <input type="text" class="form-control" :value="me.created_at">
			                </div>
						</div>

					</div>
				</div>
				<!-- /.box -->
			</div>
			<div class="col-md-6">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Ganti Password</h3>
					</div>
					<loading v-if="loading"></loading>
					<div class="box-body">
						<div class="form">
							<div class="form-group" :class='{"has-error": validation.old_password}'>
		                  		<label class="control-label">Old Password</label>
		                  		<input @keyup.enter="writeData()" class="form-control" type="password" placeholder="Enter Old Password" v-model="form.old_password">
		                  		<span v-if="validation.old_password" class="help-block">{{validation.old_password[0]}}</span>
		                	</div>
							<div class="form-group" :class='{"has-error": validation.password}'>
		                  		<label class="control-label">Password</label>
		                  		<input @keyup.enter="writeData()" class="form-control" type="password" placeholder="Enter Password" v-model="form.password">
		                  		<span v-if="validation.password" class="help-block">{{validation.password[0]}}</span>
		                	</div>
		                	<div class="form-group" :class='{"has-error": validation.confirm_password}'>
		                	  <label class="control-label">Confirm Password</label>
		                	  <input @keyup.enter="writeData()" type="password" class="form-control" placeholder="Retype Password" v-model="form.confirm_password">
		                	  <span v-if="validation.confirm_password" class="help-block">{{validation.confirm_password[0]}}</span>
		                	</div>
		                	<div class="form-group">
		                	  <button class="btn btn-primary" @click="writeData()">Save</button>
		                	</div>
						</div>
						
					</div>
				</div>
				<!-- /.box -->
			</div>
		</div>
		

	</section>
	<!-- /.content -->
</div>
</template>

<script>
export default {

	props:['me'],

	data() {
		return {
			model: {
				per_page: 10
			},
			form:{
				old_password: null,
				password: null,
				confirm_password: null,
			},
			writeRoute: _HOST + 'profile',
			validation: {},
			loading: false,
		}
	},

	computed: {
		role_name() {
			return this.me.roles.length > 0 ? this.me.roles[0].name : '-- Not Assign --'
		}
	},

	created() {
		
	},

	methods: {

		writeData() {
			const vm = this
			vm.loading = true
			axios.post(vm.writeRoute, this.form).then(function (response) {
				Object.assign(vm.$data.form, vm.$options.data().form)
				alertify.success("Berhasil menyimpan")
				vm.loading = false
			}).catch(function (error){
				vm.loading = false
				vm.validation = vm.$onAjaxError(error)
			})
		}

	}
}
</script>
