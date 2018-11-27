<template>
	<div>
		<!-- Content Header (Page header) -->
		<content-header 
		title="Manajemen permissions" 
		subtitle="Permissions management" 
		:breadcrumb='{
		icon:"fa fa-dashboard",
		path: ["Home", "Permissions management"]
	}'></content-header>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Users table</h3>
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
			                <th>Display Name</th>
			                <th>Description</th>
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
			                <td>{{m.display_name}}</td>
			                <td>{{m.description}}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- /.box-body -->
			<!-- /.box-footer-->
		</div>
		<!-- /.box -->

		<modal id="modal" @save="writeData()">
       		<template slot="title">Permission entry</template>
       		<template slot="body">
       
        	<div class="form-horizontal">
	          <div class="form-group" :class='{"has-error": validation.name}'>
	            <label class="control-label col-sm-3">Name *</label>
	            <div class="col-sm-9">
	              <input @keyup.enter="writeData()" type="text" class="form-control" placeholder="Enter name" v-model="form.name">
	            </div>
	          </div>
	          <div class="form-group" :class='{"has-error": validation.display_name}'>
	            <label class="control-label col-sm-3">Display name</label>
	            <div class="col-sm-9">
	              <input @keyup.enter="writeData()" type="text" class="form-control" placeholder="Must be unique" v-model="form.display_name">
	            </div>
	          </div>
	          <div class="form-group" :class='{"has-error": validation.description}'>
	            <label class="control-label col-sm-3">Description</label>
	            <div class="col-sm-9">
	              <input @keyup.enter="writeData()" type="text" class="form-control" placeholder="Must be unique" v-model="form.description">
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

	props:['roles'],

	data() {
		return {
			model: {
			  per_page: 10
			},
			form:{
			  id: null,
	          name: null,
	          display_name: null,
	          description: null,
			},
			search: '',
			readRoute: _HOST + 'permissions/read',
			writeRoute: _HOST + 'permissions/write',
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
				$('#modal').modal('show')
				vm.form = model
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
			$('#modal').modal('show')
			Object.assign(this.$data.form, this.$options.data().form)
			this.validation = {}
		}
	}
}
</script>
