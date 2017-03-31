@extends('master')

@section('content')
	<ol class="breadcrumb">
        <li class="breadcrumb-item">{{session('username')}}</li>
        <li class="breadcrumb-item"><a href="#">Manajemen</a>
        </li>
    </ol>


    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Tambah User
                        </div>
                        <div class="card-block">
                        	<form action="" method="post">
                        		<div class="row">
	                            	{{csrf_field()}}
	                                <div class="form-group col-sm-6">
	                                    <label for="city">Username</label>
	                                    <input type="text" class="form-control" autocomplete="false" placeholder="Username" name="username">
	                                </div>
	                                <div class="form-group col-sm-6">
	                                    <label for="postal-code">Password</label>
	                                    <input type="password" autocomplete="false" class="form-control" placeholder="Password" name="password">
	                                </div>
	                                <div class="form-group col-sm-6">
	                                    <label for="postal-code">Role</label>
	                                    <select class="form-control" name="role">
	                                    	<option value="admin">Admin</option>
	                                    	<option value="standar">Standar</option>
	                                    </select>
	                                </div>
	                                <div class="form-group col-sm-6">
	                                    <label for="postal-code">Kantor</label>
	                                    <input type="number" min="1" max="2" class="form-control" placeholder="Kantor" name="kantor">
	                                </div>
	                            </div>
	                            <div class="row">
	                            	<div class="col-sm-12">
	                            		<button type="submit" class="btn btn-primary pull-right">Simpan</button>
	                            	</div>
	                            </div>
                        	</form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home4" role="tab" aria-controls="home"> Data User </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile"> Data Presensi </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home4" role="tabpanel">
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Kantor</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list_user as $user)
                                    <tr>
                                    	<td>{{$user->username}}</td>
                                    	<td>{{$user->role}}</td>
                                    	<td>{{$user->kantor}}</td>
                                    	<td>
                                    		<div class="btn-group">
                                    			<button data-toggle="modal" data-target="#largeModal" class="btn btn-primary btn-sm btn-edit" data-id="{{$user->id}}">Edit</button>
                                    			<a href="/delete_user/{{$user->id}}" class="btn btn-danger btn-sm">Hapus</a>
                                    		</div>
                                    	</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="profile4" role="tabpanel">
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Masuk</th>
                                        <th>Pulang</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list_presensi as $presensi)
                                    <tr>
                                    	<td>{{$presensi->userInfo->username}}</td>
                                    	<td>{{$presensi->masuk}}</td>
                                    	<td>{{$presensi->pulang}}</td>
                                    	<td>
                                    		<div class="btn-group">
                                    			<button data-toggle="modal" data-target="#largeModal2" class="btn btn-primary btn-sm btn-edit-presensi" data-id="{{$presensi->id}}">Edit</button>
                                    			<a href="/delete_presensi/{{$presensi->id}}" class="btn btn-danger btn-sm">Hapus</a>
                                    		</div>
                                    	</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<form action="" method="post" class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                	{{csrf_field()}}
                    <div class="form-group col-sm-6">
                        <label for="city">Username</label>
                        <input id="edit-username" type="text" class="form-control" autocomplete="false" placeholder="Username" name="username">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="postal-code">Password</label>
                        <input type="password" autocomplete="false" class="form-control" placeholder="Kosongkan jika tidak dirubah" name="password">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="postal-code">Role</label>
                        <select id="edit-role" class="form-control" name="role">
                        	<option value="admin">Admin</option>
                        	<option value="standar">Standar</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="postal-code">Kantor</label>
                        <input id="edit-kantor" type="number" min="1" max="2" class="form-control" placeholder="Kantor" name="kantor">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<form action="" method="post" class="modal fade" id="largeModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Presensi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                	{{csrf_field()}}
                    <div class="form-group col-sm-6">
                        <label for="city">Masuk</label>
                        <input id="edit-masuk" type="text" class="form-control" autocomplete="false" placeholder="Masuk" name="masuk">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="postal-code">Pulang</label>
                        <input type="text" id="edit-pulang" autocomplete="false" class="form-control" placeholder="Pulang" name="pulang">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
@stop

@section('script')
	<script type="text/javascript">
		$(".btn-edit").click(function(){
			var id = $(this).data('id');
			$.ajax({
				url:"/single_user/"+id,
				method:"GET",
				success:function(res){
					$("#edit-username").val(res.username);
					$("#edit-kantor").val(res.kantor);
					$("#edit-role").val(res.role);
					$("#largeModal").attr('action','/update_user/'+id);
				}
			});
		});

		$(".btn-edit-presensi").click(function(){
			var id = $(this).data('id');
			$.ajax({
				url:"/single_presensi/"+id,
				method:"GET",
				success:function(res){
					$("#edit-masuk").val(res.masuk);
					$("#edit-pulang").val(res.pulang);
					$("#largeModal2").attr('action','/update_presensi/'+id);
				}
			});
		})
	</script>
@stop