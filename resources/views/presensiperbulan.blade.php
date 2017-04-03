@extends('master')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{session('username')}}</li>
        <li class="breadcrumb-item"><a href="#">Presensi Perbulan</a>
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
            @foreach($presensi as $tahun => $data1)
            <h4>Data Presensi tahun {{$tahun}}</h4>
            <div class="row">
                <div class="col-md-12 mb-2">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php $_count=0; ?>
                        @foreach($data1 as $bulan=>$data2)
                        <li class="nav-item">
                            <a class="nav-link <?php if($_count==0)echo'active'; ?>" data-toggle="tab" href="#tab-tahun-{{$tahun}}-bulan-{{$bulan}}" role="tab" aria-controls="home"> Bulan {{$bulan}} </a>
                            <?php $_count++; ?>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        <?php $_count=0; ?>
                        @foreach($data1 as $bulan=>$data2)
                        <div class="tab-pane <?php if($_count==0)echo'active'; ?>" id="tab-tahun-{{$tahun}}-bulan-{{$bulan}}" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <ul class="nav nav-tabs" role="tablist">
                                        @foreach($data2 as $user=>$data3)
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tab-tahun-{{$tahun}}-bulan-{{$bulan}}-user-{{$user}}" role="tab" aria-controls="home"> User {{$user}} </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content">
                            <?php /*
                            @foreach($data2 as $user=>$data3)
                            <div class="tab-pane" id="tab-tahun-{{$tahun}}-bulan-{{$bulan}}-user-{{$data3['user_id']}}" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum earum dolorem adipisci ex accusamus atque aperiam quibusdam error consequuntur repudiandae hic numquam eos ipsa amet, asperiores repellendus inventore consequatur perferendis.
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            */ ?>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@stop