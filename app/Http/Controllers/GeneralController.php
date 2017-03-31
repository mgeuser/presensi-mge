<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Presensi;
class GeneralController extends Controller
{
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
        $data['list_presensi'] = Presensi::where('user_id',session('id'))->get();
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
        $data['list_presensi'] = Presensi::with('userInfo')->get();
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
        $presensi = new Presensi();
        $presensi->user_id = session('id');
        $presensi->masuk = \Carbon\Carbon::now();
        $presensi->save();
        return redirect()->route('beranda');
    }

    public function pulang(Request $request)
    {
        $this->cekSesi2($request);
        $presensi = Presensi::where('user_id',session('id'))->whereRaw('Date(masuk) = CURDATE()')->where('pulang','=',null)->first();
        if($presensi!=null){
            $presensi->pulang = \Carbon\Carbon::now();
            $presensi->save();
        }
        return redirect()->route('beranda');
    }

    public function tambahUser(Request $request)
    {
        $this->cekSesi3($request);
        User::create([
            'username'=>$request->input('username'),
            'password'=>bcrypt($request->input('password')),
            'role'=>$request->input('role'),
            'kantor'=>$request->input('kantor')
        ]);
        return redirect('/manajemen');
    }

    public function hapusUser(Request $request, $id)
    {
        $this->cekSesi3($request);
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
        $user->username = $request->input('username');
        $user->role = $request->input('role');
        $user->kantor = $request->input('kantor');
        if($request->input('password')!=''){
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
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
}
