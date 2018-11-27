<template>
	<div>
		<!-- Content Header (Page header) -->
		<content-header 
		title="Manajemen peran" 
		subtitle="Roles management" 
		:breadcrumb='{
		icon:"fa fa-dashboard",
		path: ["Home", "Roles management"]
	}'></content-header>

	<!-- Main content -->
	<section class="content">

		<div class="row">
			<div class="col-md-7">
				<div class="box">
					<loading v-if="loading"></loading>
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
								</tr>
							</thead>
							<tbody>
								<tr v-for="m in model.data">
									<td style="width:100px;"><div class="btn-group">
										<button title="Edit data" @click="editData(m.id)" class="btn btn-xs btn-default"><i class="fa fa-edit"></i></button>
		                      			<button title="Delete data" @click="deleteData(m.id)" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></button>
		                      			<button title="Edit detail" @click="editDetail(m)" class="btn btn-xs btn-default"><i class="fa fa-arrow-right"></i></button>
									</div></td>
									<td style="width: 50px;">{{m.id}}</td>
		                  			<td>{{m.name}}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<p>Displaying: {{model.from}} to {{model.to}} of {{model.total}}</p>
					</div>
					<!-- /.box-footer-->
				</div>		
			</div>

			<div class="col-md-5">
				<div class="box">
					<loading v-if="loading"></loading>
					<div class="box-header" style="padding-bottom:0px;">
		              <!-- <div class="row"> -->
		                <!-- <div class="col-sm-12" style="padding: 10px 20px"> -->
		                  <button :disabled="!detail" class="btn btn-success pull-right"  @click="addDetail()">Add</button>
		                  <div class="form-group pull-right" style="width:250px; margin-right: 15px;">
		                    <select2 v-model="formDetail.id" class="form-control" >
		                      <option v-for="p in permissions" :value="p.id">{{p.name}}</option>
		                    </select2>
		                  </div>
		                <!-- </div> -->
		              <!-- </div> -->
		            </div>
		            <div class="box-body" style="margin-top:0px;">
		              <h4 v-if="detail" style="font-weight: bold; margin-top:0px;">Permission for: {{detail.name}}</h4>
		              <table class="table table-bordered">
		                <tr>
		                  <th style="width: 50px;">Act</th>
		                  <th style="width: 50px;">#</th>
		                  <th>Permission</th>
		                </tr>
		                <tr v-for="m in modelDetail">
		                  <td>
		                    <div class="btn-group">
		                      <button @click="deleteDetail(m)" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></button>
		                    </div>
		                  </td>
		                  <td>{{m.id}}</td>
		                  <td>{{m.name}}</td>
		                </tr>
		              </table>
		            </div> 
				</div>
			</div>
		</div>
		

		<modal id="modal" @save="writeData()">
       		<template slot="title">Role entry</template>
       		<template slot="body">
       			<div class="form-horizontal" v-on:submit.prevent="save()">
		          <div class="form-group" :class='{"has-error": validation.name}'>
		            <label class="control-label col-sm-3">Name *</label>
		            <div class="col-sm-9">
		              <input @keyup.enter="save()" type="text" class="form-control" placeholder="Enter name" v-model="form.name">
		            </div>
		          </div>
		          <div class="form-group" :class='{"has-error": validation.display_name}'>
		            <label class="control-label col-sm-3">Display name</label>
		            <div class="col-sm-9">
		              <input @keyup.enter="save()" type="text" class="form-control" placeholder="Must be unique" v-model="form.display_name">
		            </div>
		          </div>
		          <div class="form-group" :class='{"has-error": validation.description}'>
		            <label class="control-label col-sm-3">Description</label>
		            <div class="col-sm-9">
		              <input @keyup.enter="save()" type="text" class="form-control" placeholder="Must be unique" v-model="form.description">
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

	props:['permissions'],

	data() {
		return {
			model: {
				per_page: 10
			},
			modelDetail: [],
			form: {
	          id: null,
	          name: null,
	          display_name: null,
	          description: null,
	        },
			search: '',
			formDetail: {
				id: null,
			},
			readRoute: _HOST + 'roles/read',
			writeRoute: _HOST + 'roles/write',
			validation: {},
			loading: false,
			detail: null,
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

		readDetail() {
	        const vm = this
	        vm.loading = true
	        const param = {req: 'table_detail', id: vm.detail.id}
	        axios.get(vm.readRoute, {params: param}).then(function(response){
	          Vue.set(vm.$data, 'modelDetail', response.data.model)
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
					alertify.success("Data saved")
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
							alertify.success("Data deleted");
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
		},

		editDetail(m) {
	        const vm = this
	        vm.loading = true
	        vm.detail = m
	        vm.readDetail()
	    },

	    addDetail() {
	        const vm = this
	        axios.post(vm.writeRoute + "?req=add_detail&role_id=" + vm.detail.id, vm.formDetail).then(function(response){
	          alertify.success("Permission added")
	          vm.readDetail()
	        })
	    },

	    deleteDetail(m) {
	        const vm = this
	        axios.post(vm.writeRoute + "?req=delete_detail&role_id=" + vm.detail.id + "&id=" + m.id).then(function(response){
	          alertify.success("Permission deleted")
	          vm.readDetail()
	        })
	    },
	}
}
</script>
