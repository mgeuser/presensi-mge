@extends('master')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{session('username')}}</li>
        <li class="breadcrumb-item"><a href="#">File Manager</a>
        </li>
    </ol>

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            Upload File
                        </div>
                        <div class="card-block">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    {{csrf_field()}}
                                    <div class="form-group col-sm-12 col-md-3">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" placeholder="Nama File" name="nama">
                                    </div>
                                    <div class="form-group col-sm-12 col-md-3">
                                        <label>Tag</label>
                                        <input type="text" class="form-control" placeholder="TAG" name="tag">
                                    </div>
                                    <div class="form-group col-sm-6 col-md-3">
                                        <label>File</label>
                                        <input type="file" class="form-control" placeholder="File" name="file">
                                    </div>
                                    <div class="form-group col-sm-6 col-md-3">
                                        <label for="postal-code">Mode</label>
                                        <select name="privasi" class="form-control">
                                            <option value="private">Private</option>
                                            <option value="umum">Umum</option>
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            File Private
                        </div>
                        <div class="card-block">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Link</th>
                                        <th>Judul</th>
                                        <th>TAG</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            File Umum
                        </div>
                        <div class="card-block">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Link</th>
                                        <th>Judul</th>
                                        <th>TAG</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop