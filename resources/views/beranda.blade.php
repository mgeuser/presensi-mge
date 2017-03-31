@extends('master')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{session('username')}}</li>
        <li class="breadcrumb-item"><a href="#">Presensi</a>
        </li>
        <li class="breadcrumb-menu hidden-md-down">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a class="btn btn-secondary" href="#"><i class="icon-speech"></i></a>
                <a class="btn btn-secondary" href="./"><i class="icon-graph"></i> &nbsp;Dashboard</a>
                <a class="btn btn-secondary" href="#"><i class="icon-settings"></i> &nbsp;Settings</a>
            </div>
        </li>
    </ol>


    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Presensi
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            @if($sudah_pulang==false)
                                            <a href="<?=$sudah_masuk==true?'/pulang':'/masuk'?>" class="btn btn-<?=$sudah_masuk==true?'danger':'primary'?> btn-lg btn-block"><?=$sudah_masuk==true?'Pulang':'Masuk'?></a>
                                            @else
                                            <a href="#" class="btn btn-secondary btn-lg btn-block btn-disabled">Anda Sudah Pulang</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Data Presensi
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <table class="table table-bordered table-striped table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>Masuk</th>
                                                        <th>Pulang</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($list_presensi)>=1)
                                                        @foreach($list_presensi as $presensi)
                                                        <tr>
                                                            <td>{{$presensi->masuk}}</td>
                                                            <td>{{$presensi->pulang}}</td>
                                                        </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="2">Tidak ada data presensi</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop