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
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#useradd" role="tab" aria-controls="home"> Form User </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#presensiadd" role="tab" aria-controls="profile"> Form Presensi </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="useradd" role="tabpanel">
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
                        <div class="tab-pane" id="presensiadd" role="tabpanel">
                            <form action="/add_presensi" method="post">
                                <div class="row">
                                    {{csrf_field()}}
                                    <div class="form-group col-sm-12">
                                        <label for="city">Username</label>
                                        <select class="form-control" name="user_id">
                                            @foreach($list_user as $user)
                                            <option value="{{$user->id}}">{{$user->username}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="postal-code">Masuk</label>
                                        <input type="text" autocomplete="false" class="form-control singletime" placeholder="Waktu Masuk" name="masuk">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="postal-code">Pulang</label>
                                        <input type="text" autocomplete="false" class="form-control singletime" placeholder="Waktu Pulang" name="pulang">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="postal-code">Keterangan</label>
                                        <select class="form-control" name="keterangan">
                                            <option value="">Biarkan jika masuk</option>
                                            <option value="Cuti">Cuti</option>
                                            <option value="Izin">Izin</option>
                                            <option value="Tidak Masuk">Tidak Masuk</option>
                                        </select>
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
            <br>
            <div class="row">
                <div class="col-md-12 mb-2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home4" role="tab" aria-controls="home"> Data User </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile"> Data Presensi </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#export" role="tab" aria-controls="export"> Export Table </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home4" role="tabpanel">
                            <table class="table table-bordered table-striped table-condensed dataTable">
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
                                    			<button onclick="getDataUser({{$user->id}})" class="btn btn-primary btn-sm btn-edit-user" data-id="{{$user->id}}">Edit</button>
                                    			<a href="/delete_user/{{$user->id}}" class="btn btn-danger btn-sm">Hapus</a>
                                    		</div>
                                    	</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="profile4" role="tabpanel">
                            <table class="table table-bordered table-striped table-condensed dataTable">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Tanggal</th>
                                        <th>Masuk</th>
                                        <th>Pulang</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list_presensi as $presensi)
                                    <tr>
                                    	<td>{{$presensi->userInfo->username}}</td>
                                        <td>{{$presensi->tanggal_masuk}}</td>
                                    	<td>
                                            @if($presensi->keterangan==null)
                                            {{substr($presensi->jam_masuk,0,5)}}
                                            @else
                                            <strong>{{$presensi->keterangan}}</strong>
                                            @endif
                                        </td>
                                    	<td>
                                            @if($presensi->keterangan==null)
                                            <?php
                                            if($presensi->jam_pulang!=null) echo substr($presensi->jam_pulang,0,5);
                                            else echo substr($presensi->jam_pulang_temp,0,5).' (Jam otomatis)';
                                            ?>
                                            @else
                                            <strong>{{$presensi->keterangan}}</strong>
                                            @endif
                                        </td>
                                    	<td>
                                    		<div class="btn-group">
                                    			<button onclick="getDataPresensi({{$presensi->id}})" class="btn btn-primary btn-sm btn-edit-presensi" data-id="{{$presensi->id}}">Edit</button>
                                    			<a href="/delete_presensi/{{$presensi->id}}" class="btn btn-danger btn-sm">Hapus</a>
                                    		</div>
                                    	</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="export" role="tabpanel">
                            <iframe src="/export_table" style="width:100%;height: 500px;"></iframe>
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
        $(".dataTable").DataTable();

        function getDataUser (id) {
            $(".btn-edit-user[data-id='"+id+"']").addClass("disabled");
            $.ajax({
                url:"/single_user/"+id,
                method:"GET",
                success:function(res){
                    $("#edit-username").val(res.username);
                    $("#edit-kantor").val(res.kantor);
                    $("#edit-role").val(res.role);
                    $("#largeModal").attr('action','/update_user/'+id);
                    $("#largeModal").modal('show').on('hidden.bs.modal', function () {
                        $("input").val("");
                    });
                    $(".btn-edit-user[data-id='"+id+"']").removeClass("disabled");
                }
            });
        }

        function getDataPresensi (id) {
            $(".btn-edit-presensi[data-id='"+id+"']").addClass("disabled");
            $.ajax({
                url:"/single_presensi/"+id,
                method:"GET",
                success:function(res){
                    $("#edit-masuk").val(res.masuk);
                    $("#edit-pulang").val(res.pulang);
                    $("#largeModal2").attr('action','/update_presensi/'+id);
                    $("#largeModal2").modal('show').on('hidden.bs.modal', function () {
                        $("input").val("");
                    });
                    $(".btn-edit-presensi[data-id='"+id+"']").removeClass("disabled");
                }
            });   
        }
	</script>
@stop