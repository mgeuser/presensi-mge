@extends('master')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{session('username')}}</li>
        <li class="breadcrumb-item"><a href="#">Bookmark</a>
        </li>
    </ol>

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            Tambah Bookmark
                        </div>
                        <div class="card-block">
                            <form action="" method="post">
                                <div class="row">
                                    {{csrf_field()}}
                                    <div class="form-group col-sm-12 col-md-3">
                                        <label for="city">Link</label>
                                        <input type="text" class="form-control" placeholder="https://blablabla" name="alamat">
                                    </div>
                                    <div class="form-group col-sm-12 col-md-3">
                                        <label for="city">Judul</label>
                                        <input type="text" class="form-control" placeholder="Judul" name="judul">
                                    </div>
                                    <div class="form-group col-sm-6 col-md-3">
                                        <label for="postal-code">Tag</label>
                                        <input type="text" class="form-control taginput" placeholder="TAG" name="tag">
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
                            Bookmark Private
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
                                <tbody>
                                    
                                        @if(count($list_bookmark_private)<1)
                                        <tr>
                                        <td colspan="4">Tidak ada data bookmark</td>
                                        </tr>
                                        @else
                                        @foreach($list_bookmark_private as $bookmark_private)
                                        <tr>
                                        <td><a href="{{$bookmark_private->alamat}}" target="_blank">{{$bookmark_private->alamat}}</a></td>
                                        <td>{{$bookmark_private->judul}}</td>
                                        <td>{{$bookmark_private->tag}}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm">Edit</button>
                                            <a href="/delete_bookmark/{{$bookmark_private->id}}" class="btn btn-danger btn-sm">Hapus</a>
                                        </td>
                                        </tr>
                                        @endforeach

                                        @endif
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            Bookmark Umum
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
                                <tbody>
                                    
                                        @if(count($list_bookmark_umum)<1)
                                        <tr>
                                        <td colspan="4">Tidak ada data bookmark</td>
                                        </tr>
                                        @else
                                        @foreach($list_bookmark_umum as $bookmark_umum)
                                        <tr>
                                        <td><a href="{{$bookmark_umum->alamat}}" target="_blank">{{$bookmark_umum->alamat}}</a></td>
                                        <td>{{$bookmark_umum->judul}}</td>
                                        <td>{{$bookmark_umum->tag}}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm">Edit</button>
                                            <a href="/delete_bookmark/{{$bookmark_umum->id}}" class="btn btn-danger btn-sm">Hapus</a>
                                        </td>
                                        </tr>
                                        @endforeach

                                        @endif
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop