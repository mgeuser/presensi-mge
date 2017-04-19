<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Presensi;
use App\Bookmark;
use App\File as FileManager;
use App\TagBookmark;
use App\BookmarkTag;

class GeneralController extends Controller
{
    private function curlMail($url,$data){
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_exec($handle);
        $result = curl_exec($handle);
        curl_close($handle);
    }
	private function cekSesi($request){
		if($request->session()->has('login')){
    		header("Location: ".route('beranda'));
    		die();
    	}
	}
    private function cekSesi2($request){
        if(!$request->session()->has('login')){
            header("Location: ".route('login'));
            die();
        }
    }
    private function cekSesi3($request){
        $this->cekSesi2($request);
        if(session('role')!='admin'){
            header("Location: ".route('login'));
            die();
        }
    }
    public function loginPage(Request $request)
    {
    	$this->cekSesi($request);
    	return view('login');
    }

    public function loginCheck(Request $request)
    {
    	$this->cekSesi($request);
    	$user = User::where('username',$request->input('username'))->first();
    	if($user!=null){
    		if(\Hash::check($request->input('password'), $user->password)){
                session()->put('id',$user->id);
    			session()->put('username',$request->input('username'));
	            session()->put('role', $user->role);
	            session()->put('login',true);
	            return redirect()->route('beranda');
    		}
    	}
    	session()->put('error','username atau password tidak cocok DOR');
    	return redirect()->route('login');
    }

    public function beranda(Request $request)
    {
        $this->cekSesi2($request);
        $data['TAG'] = 'beranda';
        $data['list_presensi'] = Presensi::where('user_id',session('id'))->where('bulan_masuk',\Carbon\Carbon::now()->month)->get();
        $presensi = Presensi::where('user_id',session('id'))->whereRaw('Date(masuk) = CURDATE()')->first();
        $data['sudah_masuk'] = false;
        $data['sudah_pulang'] = false;
        if($presensi!=null){
            if($presensi->pulang!=null){
                $data['sudah_pulang'] = true;   
            }
            $data['sudah_masuk'] = true;
        }
        return view('beranda',$data);
    }

    public function manajemen(Request $request)
    {
        $this->cekSesi3($request);
        $data['list_user'] = User::all();
        // $data['list_presensi'] = Presensi::with('userInfo')->whereMonth('masuk','=',\Carbon\Carbon::now()->month)->orWhere(\DB::raw('DATE(masuk)','>',\Carbon\Carbon::now()->addMonths(-1)->toDateString()))->get();
        $data['list_presensi'] = Presensi::with('userInfo')->orderBy('id','desc')->get();
        $data['TAG'] = 'manajemen';
        return view('manajemen',$data);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }

    public function masuk(Request $request)
    {
        $this->cekSesi2($request);
        $now = \Carbon\Carbon::now();
        $next = \Carbon\Carbon::now()->addHours(8);
        $presensi = new Presensi();
        $presensi->user_id = session('id');
        $user = User::find(session('id'));
        $presensi->masuk = $now;
        $presensi->jam_pulang_temp = "?";
        $presensi->jam_masuk = $now->toTimeString();
        $presensi->tanggal_masuk = $now->toDateString();
        $presensi->bulan_masuk = $now->month;
        $presensi->tahun_masuk = $now->year;
        $presensi->catatan_masuk = $request->input('catatan_masuk');
        $presensi->save();
        $data['text'] = User::find(session('id'))->username." masuk kerja pada ".\Carbon\Carbon::now();
        
        \Mail::queue('mail', $data, function($message) use($user){
            $message->to("nandi.kristian@mgesolution.com", "Pak Nandi")->subject("MGE masuk ".$user->username);
            $message->from(env('MAIL_USERNAME'),env("KANTOR"));
        });
        \Mail::queue('mail', $data, function($message) use($user){
            $message->to("upload.kurniawan@gmail.com", "Developer")->subject("MGE masuk ".$user->username);
            $message->from(env('MAIL_USERNAME'),env("KANTOR"));
        });
        \Mail::queue('mail', $data, function($message) use($user){
            $message->to("sindu@mgesolution.com", "Sindu")->subject("MGE masuk ".$user->username);
            $message->from(env('MAIL_USERNAME'),env("KANTOR"));
        });
        
        // $url = 'http://47.88.240.48/presensi_mail_curl/mailing.php';
        // $data = array('to'=>"upload.kurniawan@gmail.com",'Kurniawan' => 'MGE', 'subject' => "MGE masuk ".$user->username, "pesan"=>urlencode(User::find(session('id'))->username." masuk kerja pada ".\Carbon\Carbon::now()));
        // $this->curlMail($url,$data);

        // $data = array('to'=>"nandi.kristian@mgesolution.com",'Nandi' => 'MGE', 'subject' => "MGE masuk ".$user->username, "pesan"=>urlencode(User::find(session('id'))->username." masuk kerja pada ".\Carbon\Carbon::now()));
        // $this->curlMail($url,$data);

        // $data = array('to'=>"sindu@mgesolution.com",'nama' => 'Sindu', 'subject' => "MGE masuk ".$user->username, "pesan"=>urlencode(User::find(session('id'))->username." masuk kerja pada ".\Carbon\Carbon::now()));
        // $this->curlMail($url,$data);

        return redirect()->route('beranda');
    }
    public function pulang(Request $request)
    {
        $this->cekSesi2($request);
        $now = \Carbon\Carbon::now();
        $presensi = Presensi::where('user_id',session('id'))->whereRaw('Date(masuk) = CURDATE()')->where('pulang','=',null)->first();
        $user = User::find(session('id'));
        if($presensi!=null){
            $presensi->pulang = $now;
            $presensi->jam_pulang = $now->toTimeString();
            $presensi->tanggal_pulang = $now->toDateString();
            $presensi->bulan_pulang = $now->month;
            $presensi->tahun_pulang = $now->year;
            $presensi->catatan_pulang = $request->input('catatan_pulang');
            $presensi->save();
        }
        $data['text'] = User::find(session('id'))->username." pulang kerja pada ".\Carbon\Carbon::now();
        
        \Mail::queue('mail', $data, function($message) use($user){
            $message->to("nandi.kristian@mgesolution.com", "Pak Nandi")->subject("MGE pulang ".$user->username);
            $message->from(env('MAIL_USERNAME'),env("KANTOR"));
        });
        \Mail::queue('mail', $data, function($message) use($user){
            $message->to("upload.kurniawan@gmail.com", "Developer")->subject("MGE pulang ".$user->username);
            $message->from(env('MAIL_USERNAME'),env("KANTOR"));
        });
        \Mail::queue('mail', $data, function($message) use($user){
            $message->to("sindu@mgesolution.com", "Sindu")->subject("MGE pulang ".$user->username);
            $message->from(env('MAIL_USERNAME'),env("KANTOR"));
        });
        
        // $url = 'http://47.88.240.48/presensi_mail_curl/mailing.php';
        // $data = array('to'=>"upload.kurniawan@gmail.com",'Kurniawan' => "MGE", 'subject' => "MGE pulang ".$user->username, "pesan"=>User::find(session('id'))->username." pulang kerja pada ".\Carbon\Carbon::now());
        // $this->curlMail($url,$data);
        
        // $data = array('to'=>"nandi.kristian@mgesolution.com",'Nandi' => "MGE", 'subject' => "MGE pulang ".$user->username, "pesan"=>User::find(session('id'))->username." pulang kerja pada ".\Carbon\Carbon::now());
        // $this->curlMail($url,$data);

        // $data = array('to'=>"sindu@mgesolution.com",'nama' => "Sindu", 'subject' => "MGE pulang ".$user->username, "pesan"=>User::find(session('id'))->username." pulang kerja pada ".\Carbon\Carbon::now());
        // $this->curlMail($url,$data);

        return redirect()->route('beranda');
    }

    public function tambahUser(Request $request)
    {
        $this->cekSesi3($request);
        $user = User::create([
            'username'=>$request->input('username'),
            'password'=>bcrypt($request->input('password')),
            'role'=>$request->input('role'),
            'kantor'=>$request->input('kantor')
        ]);
        $data['text'] = User::find(session('id'))->username." menambah user baru dengan username : ".$request->input('username').", role :  ".$request->input('role').", kantor : ".$request->input('kantor')." dan password : ".$request->input('password')." pada ".\Carbon\Carbon::now();
        
        \Mail::queue('mail', $data, function($message) use($user){
            $message->to("nandi.kristian@mgesolution.com", "Pak Nandi")->subject("MGE tambah user ".$user->username);
            $message->from(env('MAIL_USERNAME'),env("KANTOR"));
        });
        \Mail::queue('mail', $data, function($message) use($user){
            $message->to("upload.kurniawan@gmail.com", "Developer")->subject("MGE tambah user ".$user->username);
            $message->from(env('MAIL_USERNAME'),env("KANTOR"));
        });
        \Mail::queue('mail', $data, function($message) use($user){
            $message->to("sindu@mgesolution.com", "Sindu")->subject("MGE tambah user ".$user->username);
            $message->from(env('MAIL_USERNAME'),env("KANTOR"));
        });
        
        
        // $url = 'http://47.88.240.48/presensi_mail_curl/mailing.php';
        // $data = array('to'=>"upload.kurniawan@gmail.com",'Kurniawan' => "MGE", 'subject' => "MGE tambah user ".$user->username, "pesan"=>User::find(session('id'))->username." menambah user baru dengan username : ".$request->input('username').", role :  ".$request->input('role').", kantor : ".$request->input('kantor')." dan password : ".$request->input('password')." pada ".\Carbon\Carbon::now());
        // $this->curlMail($url,$data);

        // $data = array('to'=>"nandi.kristian@mgesolution.com",'Nandi' => "MGE", 'subject' => "MGE tambah user ".$user->username, "pesan"=>User::find(session('id'))->username." menambah user baru dengan username : ".$request->input('username').", role :  ".$request->input('role').", kantor : ".$request->input('kantor')." dan password : ".$request->input('password')." pada ".\Carbon\Carbon::now());
        // $this->curlMail($url,$data);

        // $data = array('to'=>"sindu@mgesolution.com",'Sindu' => "MGE", 'subject' => "MGE tambah user ".$user->username, "pesan"=>User::find(session('id'))->username." menambah user baru dengan username : ".$request->input('username').", role :  ".$request->input('role').", kantor : ".$request->input('kantor')." dan password : ".$request->input('password')." pada ".\Carbon\Carbon::now());
        // $this->curlMail($url,$data);
        return redirect('/manajemen');
    }

    public function hapusUser(Request $request, $id)
    {
        $this->cekSesi3($request);
        $username = User::find($id)->username;
        $user = User::find(session('id'));
        $data['text'] = User::find(session('id'))->username." menghapus user ".$username." pada ".\Carbon\Carbon::now();
        
        \Mail::queue('mail', $data, function($message) use($user){
            $message->to("nandi.kristian@mgesolution.com", "Pak Nandi")->subject("MGE hapus user ".$user->username);
            $message->from(env('MAIL_USERNAME'),env("KANTOR"));
        });
        \Mail::queue('mail', $data, function($message) use($user){
            $message->to("upload.kurniawan@gmail.com", "Developer")->subject("MGE hapus user ".$user->username);
            $message->from(env('MAIL_USERNAME'),env("KANTOR"));
        });
        \Mail::queue('mail', $data, function($message) use($user){
            $message->to("sindu@mgesolution.com", "Sindu")->subject("MGE hapus user ".$user->username);
            $message->from(env('MAIL_USERNAME'),env("KANTOR"));
        });
        
        
        // $url = 'http://47.88.240.48/presensi_mail_curl/mailing.php';
        // $data = array('to'=>"upload.kurniawan@gmail.com",'Kurniawan' => "MGE", 'subject' => "MGE hapus user ".$user->username, "pesan"=>User::find(session('id'))->username." menghapus user ".$username." pada ".\Carbon\Carbon::now());
        // $this->curlMail($url,$data);

        // $data = array('to'=>"nandi.kristian@mgesolution.com",'Nandi' => "MGE", 'subject' => "MGE hapus user ".$user->username, "pesan"=>User::find(session('id'))->username." menghapus user ".$username." pada ".\Carbon\Carbon::now());
        // $this->curlMail($url,$data);

        // $data = array('to'=>"sindu@mgesolution.com",'Sindu' => "MGE", 'subject' => "MGE hapus user ".$user->username, "pesan"=>User::find(session('id'))->username." menghapus user ".$username." pada ".\Carbon\Carbon::now());
        // $this->curlMail($url,$data);
        User::where('id',$id)->delete();
        return redirect('/manajemen');
    }

    public function getSingleUser(Request $request, $id)
    {
        $this->cekSesi3($request);
        return response()->json(User::find($id));
    }

    public function updateUser(Request $request,$id)
    {
        $this->cekSesi3($request);
        $user = User::find($id);
        
        $username = $user->username;

        $user->username = $request->input('username');
        $user->role = $request->input('role');
        $user->kantor = $request->input('kantor');
        if($request->input('password')!=''){
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
        $data['text'] = User::find(session('id'))->username." mengedit user ".$username." pada ".\Carbon\Carbon::now();
        
        \Mail::queue('mail', $data, function($message) use($user){
            $message->to("nandi.kristian@mgesolution.com", "Pak Nandi")->subject("MGE update user ".$user->username);
            $message->from(env('MAIL_USERNAME'),env("KANTOR"));
        });
        \Mail::queue('mail', $data, function($message) use($user){
            $message->to("upload.kurniawan@gmail.com", "Developer")->subject("MGE update user ".$user->username);
            $message->from(env('MAIL_USERNAME'),env("KANTOR"));
        });
        \Mail::queue('mail', $data, function($message) use($user){
            $message->to("sindu@mgesolution.com", "Sindu")->subject("MGE update user ".$user->username);
            $message->from(env('MAIL_USERNAME'),env("KANTOR"));
        });
        
        
        // $url = 'http://47.88.240.48/presensi_mail_curl/mailing.php';
        // $data = array('to'=>"upload.kurniawan@gmail.com",'Kurniawan' => "MGE", 'subject' => "MGE update user ".$user->username, "pesan"=>User::find(session('id'))->username." mengedit user ".$username." pada ".\Carbon\Carbon::now());
        // $this->curlMail($url,$data);

        // $data = array('to'=>"nandi.kristian@mgesolution.com",'Nandi' => "MGE", 'subject' => "MGE update user ".$user->username, "pesan"=>User::find(session('id'))->username." mengedit user ".$username." pada ".\Carbon\Carbon::now());
        // $this->curlMail($url,$data);

        // $data = array('to'=>"sindu@mgesolution.com",'Sindu' => "MGE", 'subject' => "MGE update user ".$user->username, "pesan"=>User::find(session('id'))->username." mengedit user ".$username." pada ".\Carbon\Carbon::now());
        // $this->curlMail($url,$data);
        return redirect('/manajemen');
    }

    public function deletePresensi(Request $request, $id)
    {
        $this->cekSesi3($request);
        Presensi::where('id',$id)->delete();
        return redirect('/manajemen');   
    }

    public function updatePresensi(Request $request, $id)
    {
        $this->cekSesi3($request);
        $presensi = Presensi::find($id);
        Presensi::where('id',$id)->update($request->except(['_token','_method']));
        return redirect('/manajemen');
    }

    public function getSinglePresensi(Request $request,$id)
    {
        $this->cekSesi3($request);
        return response()->json(Presensi::find($id));
    }

    public function tambahPresensi(Request $request)
    {
        $masuk = \Carbon\Carbon::parse($request->input('masuk'));
        $pulang = \Carbon\Carbon::parse($request->input('pulang'));
        // dd($pulang);
        $presensi = new Presensi();
        $presensi->user_id = $request->input('user_id');
        $presensi->masuk = $masuk;
        $presensi->jam_pulang_temp = $masuk->addHours(8);
        $presensi->jam_masuk = $masuk->toTimeString();
        $presensi->tanggal_masuk = $masuk->toDateString();
        $presensi->bulan_masuk = $masuk->month;
        $presensi->tahun_masuk = $masuk->year;
        $presensi->pulang = $pulang;
        $presensi->jam_pulang = $pulang->toTimeString();
        $presensi->tanggal_pulang = $pulang->toDateString();
        $presensi->bulan_pulang = $pulang->month;
        $presensi->tahun_pulang = $pulang->year;
        $presensi->save();
        return redirect('/manajemen');
    }

    public function bookmark(Request $request){
        $this->cekSesi2($request);
        $data['TAG'] = 'bookmark';
        $data['list_bookmark_private'] = Bookmark::where('user_id',session('id'))->where('privasi','private')->get();
        $data['list_bookmark_umum'] = Bookmark::with('userInfo')->where('privasi','umum')->get();
        return view('bookmark',$data);
    }

    public function tambahBookmark(Request $request){
        $this->cekSesi2($request);
        $bookmark = new Bookmark();
        $bookmark->alamat = $request->input('alamat');
        $tags = $request->input('tag');
        $tags = str_replace(["; "," ;"," ; "], ";", $tags);
        $tags = strtolower($tags);
        $bookmark->tag = $tags;
        $bookmark->judul = $request->input('judul');
        $bookmark->privasi = $request->input('privasi');
        $bookmark->user_id = session('id');
        $bookmark->save();
        $tags = explode(";",$tags);
        foreach($tags as $tag){
            $tagBookmark = TagBookmark::where('tag',$tag)->first();
            if($tagBookmark==null){
                $tagBookmark = TagBookmark::create(['tag'=>$tag]);
            }
            BookmarkTag::create([
                'bookmark_id'=>$bookmark->id,
                'tag_bookmark_id'=>$tagBookmark->id
            ]);
        }
        return redirect('/bookmark');
    }

    public function deleteBookmark(Request $request, $id){
        Bookmark::where('id',$id)->delete();
        return redirect('/bookmark');
    }

    public function fileServerPage(Request $request){
        $data["TAG"] = "file_manager";
        return view("file_manager",$data);
    }

    public function uploadFileManager(Request $request){
        \Storage::disk('local')->put(strtotime(time()).'-'.$request->input("nama").'.'.$request->file('file')->getClientOriginalExtension(),  \File::get($request->file('file')));
        FileManager::create([
            'nama'=>$request->input('nama'),
            'user_id'=>session('id'),
            'privasi'=>$request->input('privasi')
        ]);

        $url = "http://47.88.240.48/presensi_mail_curl/file_manager_upload.php"; // e.g. http://localhost/myuploader/upload.php // request URL
        $filename = $_FILES['file']['name'];
        $filedata = $_FILES['file']['tmp_name'];
        $filesize = $_FILES['file']['size'];
        if ($filedata != '')
        {
            $headers = array("Content-Type:multipart/form-data"); // cURL headers for file uploading
            $postfields = array("filedata" => "@$filedata", "filename" => $filename);
            $ch = curl_init();
            $options = array(
                CURLOPT_URL => $url,
                CURLOPT_HEADER => true,
                CURLOPT_POST => 1,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => $postfields,
                CURLOPT_INFILESIZE => $filesize,
                CURLOPT_RETURNTRANSFER => true
            ); // cURL options
            curl_setopt_array($ch, $options);
            curl_exec($ch);
            if(!curl_errno($ch))
            {
                $info = curl_getinfo($ch);
                if ($info['http_code'] == 200)
                    $errmsg = "File uploaded successfully";
            }
            else
            {
                $errmsg = curl_error($ch);
            }
            curl_close($ch);
        }
        else
        {
            $errmsg = "Please select the file";
        }
        print_r($errmsg);
        //return redirect('/file_manager');
    }


// BUREK


    public function presensiPerBulan(Request $request){
        $this->cekSesi3($request);
        $data['TAG'] = 'presensiperbulan';
        $data['presensi'] = collect(Presensi::with('userInfo')->where('bulan_masuk','<>','')->where('tahun_masuk','<>','')->orderBy('tahun_masuk')->get())->groupBy('tahun_masuk')->map(function ($item) {
            return $item->groupBy('bulan_masuk')->map(function ($item2){
                return $item2->sortBy('user_id')->sortBy('tanggal_masuk')->groupBy('user_id');
            });
        })->toArray();
        return view('presensiperbulan',$data);
    }

    public function generatePresensi(){
        for($i=0;$i<=20;$i++){
            $now = \Carbon\Carbon::now()->addDays($i);
            $pulang = \Carbon\Carbon::parse($now)->addHours(4);
            $presensi = new Presensi();
            $presensi->user_id = 1; 
            $presensi->masuk = $now;
            $presensi->jam_masuk = $now->toTimeString();
            $presensi->tanggal_masuk = $now->day;
            $presensi->bulan_masuk = $now->month;
            $presensi->tahun_masuk = $now->year;
            $presensi->pulang = $pulang;
            $presensi->jam_pulang = $pulang->toTimeString();
            $presensi->tanggal_pulang = $now->day;
            $presensi->bulan_pulang = $now->month;
            $presensi->tahun_pulang = $now->year;
            $presensi->save();
        }
    }

    public function exportTable(Request $request){
        $this->cekSesi3($request);
        $data['allData'] = User::with('listPresensi')->whereHas('listPresensi',function($q){
            $q->whereMonth('masuk','=',\Carbon\Carbon::now()->month)->orWhere(\DB::raw('DATE(masuk)','>',\Carbon\Carbon::now()->addMonths(-1)->toDateString()));
        })->get();
        // dd($data['allData']);
        return view('export_table',$data);
        // $presensi = Presensi::where('user_id',1)->where('tanggal_pulang','<>','null')->get();
        // echo "<div style='display:inline-table;margin-right:10px;'>";
        //     foreach($presensi as $p){
        //         echo $p->tanggal_masuk;
        //         echo "<br>";
        //         echo "<br>";
        //         echo "<br>";
        //         echo "<br>";
        //     }
        // echo "</div>";
        // echo "<div style='display:inline-table;'>";
        //     foreach($presensi as $p){
        //         echo str_replace(":",",",substr($p->jam_masuk,0,5))."<br>";
        //         echo "00,00<br>";
        //         echo "00,00<br>";
        //         echo str_replace(":",",",substr($p->jam_pulang,0,5))."<br>";
        //     }
        // echo "</div>";
    }

    public function normalisasi(Request $request)
    {
        $presensi = Presensi::all();
        foreach ($presensi as $p) {
            $masuk = \Carbon\Carbon::parse($p->masuk);
            $p->jam_masuk = $masuk->toTimeString();
            $p->tanggal_masuk = $masuk->toDateString();
            $p->bulan_masuk = $masuk->month;
            $p->tahun_masuk = $masuk->year;
            $p->tanggal_pulang = $masuk->toDateString();
            $p->bulan_pulang = $masuk->month;
            $p->tahun_pulang = $masuk->year;
            $p->jam_pulang_temp = $masuk->addHours(8)->toTimeString();
            $p->save();
        }
    }
}
