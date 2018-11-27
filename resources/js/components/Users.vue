<template>
	<div>
		<!-- Content Header (Page header) -->
		<content-header 
		title="Manajemen pengguna" 
		subtitle="Users management" 
		:breadcrumb='{
		icon:"fa fa-dashboard",
		path: ["Home", "Users management"]
	}'></content-header>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<div class="box-title"><pagination :pagination="model" :callback="readData"></pagination></div>
				<div class="box-tools">
					<button class="btn btn-success" @click="newData">New</button>
				</div>
			</div>
			<loading v-if="loading"></loading>
			<div class="box-body">
				<table class="table table-striped table-condensed" width="100%">
					<thead>
						<tr>
							<th>Act</th>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Role</th>
							<th>Created at</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="m in model.data">
							<td><div class="btn-group">
								<button class="btn btn-xs btn-default" @click="editData(m.id)"><i class="fa fa-edit"></i></button>
								<button class="btn btn-xs btn-default" @click="deleteData(m.id)"><i class="fa fa-trash"></i></button>
							</div></td>
							<td>{{m.id}}</td>
							<td>{{m.name}}</td>
							<td>{{m.email}}</td>
							<td>{{m.role_name}}</td>
							<td>{{m.created_at}}</td>
							<td>{{m.deleted_at ? 'Tidak Aktif' : 'Aktif'}}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- /.box-body -->
			<!-- /.box-footer-->
			<div class="box-footer">
				<p>Displaying: {{model.from}} to {{model.to}} of {{model.total}}</p>
			</div>
		</div>
		<!-- /.box -->

		<modal id="modal" @save="writeData()">
       		<template slot="title">User entry</template>
       		<template slot="body">
       
        	<div class="form-horizontal">
          		<div class="form-group" :class='{"has-error": validation.name}'>
            		<label class="control-label col-sm-3">Name *</label>
            		<div class="col-sm-8">
              			<input @keyup.enter="writeData()" v-model="form.name" maxlength="8" type="text" class="form-control" placeholder="Enter name">
              			<span v-if="validation.name" class="help-block">{{validation.name[0]}}</span>
            		</div>
          		</div>
          		<div class="form-group" :class='{"has-error": validation.email}'>
            		<label class="control-label col-sm-3">Email *</label>
            		<div class="col-sm-8">
              			<input :disabled="bridging" @keyup.enter="writeData()" type="text" class="form-control" placeholder="Enter email" v-model="form.email">
              			<span v-if="validation.email" class="help-block">{{validation.email[0]}}</span>
            		</div>
          		</div>
          		<div class="form-group" :class='{"has-error": validation.password}'>
            		<label class="control-label col-sm-3">Password *</label>
            		<div class="col-sm-8">
              			<input @keyup.enter="writeData()" type="password" class="form-control" placeholder="Enter password" v-model="form.password">
              			<span v-if="validation.password" class="help-block">{{validation.password[0]}}</span>
            		</div>
          		</div>
          		<div class="form-group" :class='{"has-error": validation.confirm_password}'>
            		<label class="control-label col-sm-3">Conf. password *</label>
            		<div class="col-sm-8">
              			<input @keyup.enter="writeData()" type="password" class="form-control" placeholder="Retype password" v-model="form.confirm_password">
              			<span v-if="validation.confirm_password" class="help-block">{{validation.confirm_password[0]}}</span>
            		</div>
          		</div>
          		<div class="form-group" :class='{"has-error": validation.role}'>
            		<label class="control-label col-sm-3">Role</label>
            		<div class="col-sm-8">
            			<select2 class="form-control" v-model="form.role_id">
            				<option :value="null">-- Select role --</option>
            				<option v-for="r in roles" :value="r.id">{{r.name}}</option>
            			</select2>
              			<span v-if="validation.role" class="help-block">{{validation.role[0]}}</span>
            		</div>
          		</div>
        	</div>
      		</template>
   	 	</modal>

	</section>
	<!-- /.content -->
</div>
</template>

<script>
export default {

	props:['roles', 'bridging'],

	data() {
		return {
			model: {
				per_page: 10
			},
			form:{
				id: null,
				name: null,
				email: null,
				password: null,
				confirm_password: null,
				role_id: null,
			},
			search: '',
			readRoute: _HOST + 'users/read',
			writeRoute: _HOST + 'users/write',
			validation: {},
			loading: false,
		}
	},

	created() {
		this.readData()
	},

	methods: {
		readData() {
			const vm = this
			vm.loading = true
			const param = {req: 'table', name: vm.search, per_page: vm.model.per_page, page: vm.model.current_page}
			axios.get(vm.readRoute, {params: param}).then(function (response) {
				Vue.set(vm.$data, 'model', response.data.model)
				vm.loading = false
			})
		},

		editData(_id) {
			const vm = this
			const param = {req: 'single', id: _id}

			axios.get(vm.readRoute, {params: param}).then(function (response) {
				vm.validation = {}
				const model = response.data.model
				setTimeout(function(){
					vm.form = {
						id: model.id,
						name: model.name,
						email: model.email,
						role_id: model.role_id,
						password: null,
						confirm_password: null,
					}	
				})
				$('#modal').modal('show')
			}).catch(function(error){
				vm.$onAjaxError(error)
			})
		},

		writeData() {
			const vm = this
			axios.post(vm.writeRoute + '?req=write', this.form).then(function (response) {
				if(response.status == 200){
					$('#modal').modal('hide')
					vm.readData()
					alertify.success("Berhasil menyimpan")
				}
			}).catch(function (error){
				vm.validation = vm.$onAjaxError(error)
			})
		},

		deleteData(id) {
			const vm = this
			alertify.confirm("Apa anda yakin menghapus rekord ini?", function(e){
				if(e){
					const param = {req:'delete', id: id}
					axios.post(vm.writeRoute, param).then(function (response) {
						if(response.data) {
							vm.readData()
							alertify.success("Berhasil menghapus");
						}
					})
				}
				else{
					return;
				}
			})
		},

		newData() {
			if(this.bridging)
				return alertify.error("Tidak bisa membuat user saat bridging. Silahkan buat user di Aissha")

			$('#modal').modal('show')
			Object.assign(this.$data.form, this.$options.data().form)
			this.validation = {}
		}
	}
}
</script>
