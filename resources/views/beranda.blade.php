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
                                            <form action="<?=$sudah_masuk==true?'/pulang':'/masuk'?>">
                                            @if($sudah_pulang==false)
                                            <textarea name="catatan_<?=$sudah_masuk==true?'pulang':'masuk'?>" rows="3" class="form-control" placeholder="catatan <?=$sudah_masuk==true?'pulang':'masuk'?> bila ada"></textarea><br>
                                            <?php /*<a href="<?=$sudah_masuk==true?'/pulang':'/masuk'?>" class="btn btn-<?=$sudah_masuk==true?'danger':'primary'?> btn-lg btn-block btn-will-disabled"><?=$sudah_masuk==true?'Pulang':'Masuk'?></a>*/ ?>
                                            <input type="submit" class="btn btn-<?=$sudah_masuk==true?'danger':'primary'?> btn-lg btn-block btn-will-disabled" value="<?=$sudah_masuk==true?'Pulang':'Masuk'?>">
                                            </form>
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
                                                        <th>Tanggal</th>
                                                        <th>Masuk</th>
                                                        <th>Keterangan Masuk</th>
                                                        <th>Pulang</th>
                                                        <th>Keterangan Pulang</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($list_presensi)>=1)
                                                        @foreach($list_presensi as $presensi)
                                                        <tr>
                                                            <td>{{$presensi->tanggal_masuk}}</td>
                                                            <td>{{substr($presensi->jam_masuk,0,5)}}</td>
                                                            <td>{{$presensi->catatan_masuk}}</td>
                                                            <td>
                                                                <?php
                                                                if($presensi->jam_pulang!=null) echo substr($presensi->jam_pulang,0,5);
                                                                else echo substr($presensi->jam_pulang_temp,0,5).' (Jam otomatis)';
                                                                ?>
                                                            </td>
                                                            <td>{{$presensi->catatan_pulang}}</td>
                                                        </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="3">Tidak ada data presensi</td>
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