<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.login');
    }

    public function get_update_password(){
        $akses = get_url_akses();
        if($akses){
           return redirect()->route("pad.index");
        }else{
            return view('admin.update_password_opd');
        }
    }
    public function update_password(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'password_baru' => 'required|min:8',
        ], [
            'password_baru.required' => 'Password baru tidak boleh kosong!',
            'password_baru.min' => 'Password baru harus memiliki minimal 8 karakter!',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }else{
            $passwordBaru = $request->input('password_baru');
            $passwordBaruMD5 = Hash::make($passwordBaru);

            $update = DB::table('auth.user_account')
                ->where('id', $id)
                ->update(['password' => $passwordBaruMD5]);

            if ($update) {
                return response()->json(['success' => true, 'message' => 'Password berhasil diperbarui']);
            } else {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui password']);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     *\Illuminate\Http\Response
     */

    public function doLogin(Request $request) {
        $redirect_route = null;
        $user_attr = trim($request->login['username']);
        $password = trim($request->login['password']);

        $user_data = $this->login_query($user_attr);

        if($user_data) {
            // Debugging password
            // dd(['entered_password' => $password, 'hashed_password' => $user_data->password]);

            $password_check = Hash::check($password, $user_data->password);
            if($password_check) {
                // Set session
                $this->setSession($user_data);

                $redirect_route = route('dashboard');

                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil melakukan login, Mohon tunggu sebentar',
                    'route_redirect' => $redirect_route
                ]);

            } else {
                return response()->json([
                    'status' => "error",
                    'message' => 'Password salah'
                ]);
            }

        } else {
            return response()->json([
                "status" => "error",
                'message' => 'Username tidak ditemukan'
            ]);
        }

        return redirect()->route($redirect_route);
    }

    private function login_query($user_attr) {
        $username = strtolower($user_attr);
        $user_data = DB::table("auth.user as aua")
            ->where(function($query) use($user_attr, $username) {
                $query->whereRaw("aua.username ilike '$username'")
                    ->orWhere("aua.email", $user_attr);
            })
            ->selectRaw("
                aua.id as user_id,
                aua.nama,
                aua.email,
                aua.username,
                aua.no_telp,
                aua.password
            ")
            ->first();

        return $user_data;
    }



    private function setSession($data){
        // dd($data);
        $user_id = encrypt($data->user_id);

        Session::put(
            'user_app', [
                'user_id' => $user_id,
        ]);
    }

    private function saveOldSession($data){
        // dd($data);
        Session::put('old_user_app', $data);
    }

    public function userResetPassword(Request $request)
    {

        $sessions = getSession();
        $userid = decrypt($sessions["user_id"]);
        $data['userakun'] = DB::table("auth.user")->where('id',$userid)->first();

        return view('Auth.user_reset_password',$data);
    }

    public function userDoResetPassword(Request $request)
    {
        // dd($request->all());
        $redirect_route = route('logout');
        $now = date('Y-m-d');
        $user_id = decrypt($request->user_id);
        $password_lama = $request->password_old;
        $password_baru = Hash::make($request->password_new);
        $user_data = DB::table("auth.user_account")->where("id",$user_id)->first();
        // dd($user_data);
        $password_check = Hash::check($password_lama,$user_data->password);

        $result = [
            'status' => "error",
            'message' => 'Terjadi Kesalahan Pada Server'
        ];

        if ($password_check) {
            # code...
            $password_lama_check = Hash::check($request->passwordBaru,$user_data->password);
            // dd($password_lama_check);
            if ($password_lama_check) {
                $result = [
                    'status' => "error",
                    'message' => 'Password Tidak boleh sama dengan yang lama'
                ];
            }else{
                $data_password['password'] = $password_baru;
                $data_password['password_updated_at'] = $now;
                DB::table("auth.user")
                ->where('id',$user_id)
                ->update($data_password);

                $result = [
                    'status' => 'success',
                    'message' => 'Berhasil melakukan reset Password, silahkan login kembali',
                    'route_redirect' => $redirect_route
                ];
            }

        }else{

            $result = [
                'status' => "error",
                'message' => 'Password Lama salah, Mohon cek kembali !!!'
            ];
        }

        return response()->json($result);

    }

    public function resetPassword(Request $request)
    {
        // dd($request->all());
        $data['user_id'] = $request->user_id;

        return view('Auth.reset_password',$data);
    }

    public function doResetPassword(Request $request)
    {
        // dd($request->all());
        $redirect_route = route('login.page');
        $now = date('Y-m-d');
        $user_id = decrypt($request->user_id);
        $password_lama = $request->passwordLama;
        $password_baru = Hash::make($request->passwordBaru);
        $user_data = DB::table("auth.user")->where("id",$user_id)->first();
        // dd($password_lama);
        $password_check = Hash::check($password_lama,$user_data->password);

        $result = [
            'status' => "error",
            'message' => 'Terjadi Kesalahan Pada Server'
        ];

        if ($password_check) {
            # code...
            $password_lama_check = Hash::check($request->passwordBaru,$user_data->password);
            // dd($password_lama_check);
            if ($password_lama_check) {
                $result = [
                    'status' => "error",
                    'message' => 'Password Tidak boleh sama dengan yg lama'
                ];
            }else{
                $data_password['password'] = $password_baru;
                $data_password['password_updated_at'] = $now;
                DB::table("auth.usert")
                ->where('id',$user_id)
                ->update($data_password);

                $result = [
                    'status' => 'success',
                    'message' => 'Berhasil melakukan reset Password, silahkan login kembali',
                    'route_redirect' => $redirect_route
                ];
            }


        }else{

            $result = [
                'status' => "error",
                'message' => 'Password salah'
            ];

        }

        return response()->json($result);

    }

    public function doImpersonate(Request $request)
    {
        $old_session = getSession();
        $redirect_route = route('pad.index');
        $user_id = decrypt($request->id_user);
        $user_data = DB::table("auth.user as aua")
        ->where("aua.id",$user_id)
        ->whereNull("aua.deleted_at")
        ->selectRaw("
            aua.id as user_id,
            aua.nama,
            aua.email,
            aua.username,
            aua.no_telp,
            aua.password,
            aua.password_updated_at,
        ")
        ->first();

        $this->saveOldSession($old_session);
        $this->setSession($user_data);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil melakukan impersonate',
            'route_redirect' => $redirect_route
        ]);
    }

    public function stopImpersonate()
    {
        $old_session = getOldSession();
        Session::put('user_app',$old_session);
        Session::forget('old_user_app');

        return redirect()->route("master.user.index");
    }
    public function logout(){
        $session = Session::get("user_app");
        // dd("logout");
        if(isset($session)){
            Session::flush();
        }

        return Redirect()->route("login.page");
        // return Redirect()->route("dashboard");
    }

}
