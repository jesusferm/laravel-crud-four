<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Users;
use Auth;

class UsersController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$userId 	= Auth::user()->id;
		$profile 	= Users::find($userId);
		$input['id'] 		= Auth::user()->id;
		if ($profile->files=="") {
			$input['files'] = 'files/'.$this->randomStr(8).$userId.'/';
			$todoStatus 		= $profile->update($input);
		}

		$path = public_path().'/'.$profile->files;
		if(!File::exists($path)) {
			File::makeDirectory($path, $mode = 0777, true, true);
		}
		return 	view('profile', ['profile' => $profile]);
	}

	public function upProfile(Request $request){
		$userId 	= Auth::user()->id;
		$input 		= $request->input();
		$profile 	= Users::find($userId);
		$input['id'] = $userId;
		$todoStatus 		= $profile->update($input);
		if ($todoStatus) {
			$msg = array("type" => 'success',
						"icon" 	=> 'fa fa-check',
						"msg" 	=> 'Actualizado correctamente.');
		} else {
			$msg = array("type" => 'danger',
						"icon" 	=> 'fa fa-times',
						"msg" 	=> 'Error con la base de datos.');
		}
		return response()->json($msg);
	}

	public function upImage(Request $request){
		$userId 	= Auth::user()->id;
		$profile 	= Users::find($userId);
		$delImg 	= public_path().'/'.$profile->files.$profile->image;
		if($request->hasfile('images')){
			$up = false;
			foreach($request->file('images') as $image){
				$imageName 			= $this->randomStr(4).'-'.$this->randomStr(4).'.'.$image->getClientOriginalExtension();
				$image->move(public_path().'/'.$profile->files, $imageName);
				$input['image'] = $imageName;
				$todoStatus 		= $profile->update($input);
				$insert['image'] 	= "$imageName";
				$up 				= true;
			}
			if ($up) {
				if(File::exists($delImg)){
					File::delete($delImg);
				}
				$msg = array("type" => 'success',
							"icon" 	=> 'fa fa-check',
							"msg" 	=> 'Archivo subido correctamente.');
			}
		}else{
			$msg = array("type" => 'danger',
						"icon" 	=> 'fa fa-times',
						"msg" 	=> 'Seleccione al menos una imagen.');
		}
		return response()->json($msg);
	}

	public function upPassword(Request $request){
		/*return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
		]);*/

		$userId 	= Auth::user()->id;
		$profile 	= Users::find($userId);

		/*$this->validate($request, [
			'current' 		=> 'required',
			'password' 		=> 'required',
			'confirmed' 	=> 'confirmed',
		]);*/
		$validator = $request->validate([
			'current' => ['required'],
			'password' => ['required'],
			'confirmed' => ['same:password'],
		]);

		if ($validator) {
			$validate_admin = DB::table('users')
							->select('*')
							->where('id', $userId)
							->first();
			if ($validate_admin && Hash::check($request->input('current'), $validate_admin->password)) {
				$pass['password'] 	= Hash::make($request->input('password'));
				$pass['id'] 		= $userId;
				$todoStatus 		= $profile->update($pass);
				if ($todoStatus) {
					$msg = array("type" => 'success',
								"icon" 	=> 'fa fa-check',
								"msg" 	=> 'Contraseña actualizada.');
				} else {
					$msg = array("type" => 'danger',
								"icon" 	=> 'fa fa-times',
								"msg" 	=> 'Error con la base de datos.');
				}
			}else{
				$msg = array("type" => 'danger',
						"icon" 	=> 'fa fa-times',
						"msg" 	=> 'La contraseña actual no es correcta.');
			}
		}else{
			$msg = array("type" => 'danger',
						"icon" 	=> 'fa fa-times',
						"msg" 	=> 'Las contraseñas no coinciden.');
		}
		
		return response()->json($msg);
	}

	public function loadImage(){
		$userId 	= Auth::user()->id;
		$profile 	= Users::find($userId);

		if ($profile->image!="" && File::exists(public_path().'/'.$profile->files.$profile->image)) {
			$img = asset($profile->files.$profile->image);
		}else{
			$img = asset('images/default.svg');
		}

		$result['img'] = '<div class="box-img-evt">
						<a href="'.$img.'" data-lightbox="img-gallery-1" data-title="Imagen de perfil">
							<img class="img-fluid" src="'.$img.'" alt="Imagen de perfil"/>
						</a>
						<ul class="icon">
							<li>
								<a href="'.$img.'" class="btn btn-primary btn-sm" data-lightbox="img-gallery-2" data-title="Imagen">
									<svg class="bi bi-eye" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"/>
										<path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
									</svg>
								</a>
							</li>';

		if ($profile->image!=="") {
			$result['img'] .= '<li>
							<button id="btn-del-img-evt" type="button" class="btn btn-danger btn-sm btn-del-img">
								<svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
									<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
								</svg>
							</button>
						</li>';
		}

		$result['img'] .= '</ul></div>';
		
		//public_path().'/'.$profile->files;
		return response()->json($result);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(){
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

	public function randomStr($length=8){
		$characters 		= '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength 	= strlen($characters);
		$randomString 		= '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		
		return $randomString;
	}
}