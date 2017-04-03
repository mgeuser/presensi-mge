<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = "new_presensi";
    protected $fillable = ['user_id','masuk','pulang','jam_masuk','jam_pulang','tanggal_masuk','tanggal_pulang','bulan_masuk','bulan_pulang','tahun_masuk','tahun_pulang','jam_pulang_temp'];
    public $timestamps = false;

    public function userInfo()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
