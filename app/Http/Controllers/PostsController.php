<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Posts;
use Auth;

class PostsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$userId = Auth::user()->id;
		$posts = Posts::where(['user_id' => $userId])->get();
		return view('posts.list', ['posts' => $posts]);
	}

	public function main()
	{
		$data = Posts::where('status', '=', 'publicado')
					->paginate(10);
		return view('main', compact('data'));
	}

	public function ajaxAdd(Request $request){
		$userId 			= Auth::user()->id;
		$input 				= $request->input();
		$input['user_id'] 	= $userId;
		$input['slug'] 		= $this->slugify($this->get_words($input['title'], 5));
		$input['files'] = 'files/'.$this->randomStr(8).'/';

		$path = public_path().'/'.$input['files'];
		if(!File::exists($path)) {
			File::makeDirectory($path, $mode = 0777, true, true);
		}
		if($request->hasfile('image')){
			foreach($request->file('image') as $image){
				$imageName = $input['image'] 	= $this->randomStr(4).'-'.$this->randomStr(4).'.'.$image->getClientOriginalExtension();
				$image->move(public_path().'/'.$input['files'], $imageName);
				$insert['image'] 	= "$imageName";
			}
		}
		$postStatus 		= Posts::create($input);
		if ($postStatus) {
			$msg = array("type" => 'success',
						"id" 	=> $postStatus->id,
						"url" 	=> route('posts.edit', $postStatus->id),
						"icon" 	=> 'fa fa-check',
						"msg" 	=> 'Registro agregado correctamente.');
		} else {
			$msg = array("type" => 'danger',
						"icon" 	=> 'fa fa-times',
						"msg" 	=> 'Error con la base de datos.');
		}

		return response()->json($msg);
	}

	public function ajaxUpdate(Request $request){
		$input 		= $request->input();
		$userId 	= Auth::user()->id;
		$post 		= Posts::find($input['id']);
		if (!$post) {
			return redirect('posts')->with('error', 'Registro no encoentrado.');
		}
		$input['user_id'] 	= $userId;
		$input['slug'] 		= $this->slugify($this->get_words($input['title'], 5)).'-'.$input['id'];
		$postStatus 		= $post->update($input);
		if ($postStatus) {
			$msg = array("type" => 'success',
						"icon" 	=> 'fa fa-check',
						"msg" 	=> 'Registro actualizado correctamente.');
		} else {
			$msg = array("type" => 'danger',
						"icon" 	=> 'fa fa-times',
						"msg" 	=> 'Error con la base de datos.');
		}

		return response()->json($msg);
	}

	public function ajaxDelete(Request $request){
		$input 		= $request->input();
		$userId 	= Auth::user()->id;
		$post 		= Posts::find($input['id']);
		
		$postDelStatus = $post->delete();
		if ($postDelStatus) {
			$msg = array("type" => 'success',
						"icon" 	=> 'fa fa-check',
						"msg" 	=> 'Registro elimiando correctamente.');
		} else {
			$msg = array("type" => 'danger',
						"icon" 	=> 'fa fa-exclamation-circle',
						"msg" 	=> 'Error con la base de datos.');
		}

		return response()->json($msg);
	}

	public function load(Request $request){
		$userId 			= Auth::user()->id;
		$input['user_id'] 	= $userId;

		$data['page'] 		= ($request->input('page')) 	? $request->input('page'): 1;
		$data['order'] 		= ($request->input('order')) 	? $request->input('order'): "desc";
		$data['order_by'] 	= ($request->input('order_by')) ? $request->input('order_by'): "id";
		$data['search'] 	= ($request->input('search')) 	? trim($request->input('search')) : "";
		$data['per_page'] 	= ($request->input('limite')) 	? $request->input('limite'): 10;
		$data['filter'] 	= ($request->input('filter')) 	? $request->input('filter')-1: 1;
		$data['offset'] 	= ($data['page'] - 1) * $data['per_page'];
		$data['adyacentes'] = 2;

		$total = DB::table('posts')
			->join('users', 'users.id', '=', 'posts.user_id')
			->select('posts.*', 'users.*')
			->where('posts.user_id', '=', $userId)
			->where('title', 'like', '%'.$data['search'].'%')
			->count();

		$results = DB::table('posts')
			->join('users', 'users.id', '=', 'posts.user_id')
			->select('posts.*')
			->where('posts.user_id', '=', $userId)
			->where('title', 'like', '%'.$data['search'].'%')
			->offset($data['offset'])
			->limit($data['per_page'])
			->orderBy($data['order_by'], $data['order'])
			->get();

		$total_pages = ceil($total/$data['per_page']);
		$reload 			= url('/page');
		$response['total']  = "Total de resultados: ".$total;

		$response['data'] 	= "";
		if ($total>0) {
			$response['data'] .= '<table class="table table-bordered table-hover">
				<thead class="thead-light">
					<tr class="row-link">
						<th data-field="id" class="th-link w-10"><i class="far fa-sort"></i> #</th>
						<th data-field="title" class="th-link"><i class="far fa-sort"></i> Nombre</th>
						<th data-field="status" class="w-15 th-link text-center"><i class="far fa-sort"></i> Estado</th>
						<th class="w-15 text-center">Acción</th>
					</tr>
				</thead>
				<tbody>';
			foreach ($results as $post) {
				$response['data'] .='<tr>
							<th>
								'.$post->id.'
							</th>
							<td>
								<a href="'.route('posts.post', $post->slug).'">'.$post->title.'</a>
							</td>
							<td>
								<center>'.$post->status.'</center>
							</td>
							<td class="text-center">
								<a href="'.route('posts.edit', $post->id).'" class="btn btn-success btn-sm">
									<svg class="bi bi-check2-square" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
										<path fill-rule="evenodd" d="M1.5 13A1.5 1.5 0 0 0 3 14.5h10a1.5 1.5 0 0 0 1.5-1.5V8a.5.5 0 0 0-1 0v5a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h8a.5.5 0 0 0 0-1H3A1.5 1.5 0 0 0 1.5 3v10z"/>
									</svg> <span class="d-none d-md-inline">Editar</span>
								</a> 
								<button type="button" id="btn-del-'.$post->id.'" name="btn-del-'.$post->id.'" class="btn btn-danger btn-sm mdl-del-reg" data-toggle="modal" data-target="#mdl-del-reg" data-idreg="'.$post->id.'" data-nomreg="'.$post->title.'">
									<svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
										<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
									</svg>
								</button>
							</td>
						</tr>';
			}
			$response['data'] .= '</tbody></table>';
			$response['data'] .= '<span class="pull-right">'.$this->paginate($reload, $data['page'], $total_pages, $data['adyacentes'], 'load').'</span>';
		}else{
			$response['data'] 	= '<div class="alert alert-info text-center" role="alert"><i class="fas fa-search"></i> Búsqueda sin resultados.</div>';
		}
		
		return response()->json($response);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('posts.add');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		$userId 			= Auth::user()->id;
		$input 				= $request->input();
		$input['user_id'] 	= $userId;
		$postStatus 		= Posts::create($input);
		if ($postStatus) {
			$request->session()->flash('success', 'Todo successfully added');
		} else {
			$request->session()->flash('error', 'Oops something went wrong, Todo not saved');
		}
		return redirect('posts');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$userId = Auth::user()->id;
		$post = Posts::where(['user_id' => $userId, 'id' => $id])->first();
		if (!$post) {
			return redirect('todo')->with('error', 'Todo not found');
		}
		return view('posts.view', ['todo' => $post]);
	}

	public function view($slug){
		$userId 	= Auth::user()->id;
		$post 		= Posts::where(['user_id' => $userId, 'slug' => $slug])->first();
		if (!$post) {
			return redirect('todo')->with('error', 'Registro no encontrado, por favor revise.');
		}
		return view('posts.view', ['todo' => $post]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$userId = Auth::user()->id;
		$post = Posts::where(['user_id' => $userId, 'id' => $id])->first();
		if ($post) {
			return view('posts.edit', [ 'todo' => $post ]);
		} else {
			return redirect('posts')->with('error', 'Todo not found');
		}
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id){
		$userId 	= Auth::user()->id;
		$post 		= Posts::find($id);
		$input 		= $request->input();
		if (!$post) {
			return redirect('posts')->with('danger', 'Regitro no encontrado.');
		}

		$path = public_path().'/'.$post->files;
		if(!File::exists($path)) {
			File::makeDirectory($path, $mode = 0777, true, true);
		}
		if($request->hasfile('image')){
			foreach($request->file('image') as $image){
				$imageName = $input['image'] 	= $this->randomStr(4).'-'.$this->randomStr(4).'.'.$image->getClientOriginalExtension();
				$image->move(public_path().'/'.$post->files, $imageName);
				$insert['image'] 	= "$imageName";
			}
			$delImg 	= public_path().'/'.$post->files.$post->image;
			if(File::exists($delImg)){
				File::delete($delImg);
			}
		}

		$input['user_id'] 	= $userId;
		$postStatus 		= $post->update($input);
		if ($postStatus) {
			return redirect(route('posts.edit', $post->id))->with('success', 'Actualizanción correcta.');
		} else {
			return redirect(route('posts.edit', $post->id))->with('danger', 'Error, ntenta mástarde.');
		}
	}
	/**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $request->file('upload')->move(public_path('images'), $fileName);
   
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function upsdate(Request $request, Product $product){
		$request->validate([
			'name' => 'required',
			'detail' => 'required',
		]);
  
		$product->update($request->all());
  
		return redirect()->route('products.index')
						->with('success','Product updated successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$userId = Auth::user()->id;
		$post = Posts::where(['user_id' => $userId, 'id' => $id])->first();
		$respStatus = $respMsg = '';
		if (!$post) {
			$respStatus = 'error';
			$respMsg = 'Todo not found';
		}
		$postDelStatus = $post->delete();
		if ($postDelStatus) {
			$respStatus = 'success';
			$respMsg = 'Todo deleted successfully';
		} else {
			$respStatus = 'error';
			$respMsg = 'Oops something went wrong. Todo not deleted successfully';
		}
		return redirect('todo')->with($respStatus, $respMsg);
	}

	public function get_words($sentence, $count = 10) {
		preg_match("/(?:[^\s,\.;\?\!]+(?:[\s,\.;\?\!]+|$)){0,$count}/", $sentence, $matches);
		return $matches[0];
	}

	public function slugify($text){
		// replace non letter or digits by -
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
		// trim
		$text = trim($text, '-');
		// transliterate
		if (function_exists('iconv')){
			$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		}
		// lowercase
		$text = strtolower($text);
		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		if(strlen($text)>=80){
			$text = substr($text, 0, 80);
		}

		if (empty($text)){
			return 'n-a';
		}
		return $text;
	}

	public function paginate($reload, $page, $tpages, $adjacents, $fuc_load) {
		$prevlabel 	= '<i class="fas fa-chevron-left"></i>';
		$nextlabel 	= '<i class="fas fa-chevron-right"></i>';
		$out 		= '<nav aria-label="..."><ul class="pagination pagination-large justify-content-end">';
		
		// previous label
		if($page==1) {
			$out .= '<li class="page-item disabled"><a class="page-link">'.$prevlabel.'</a></li>';
		} else if($page==2) {
			$out .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="'.$fuc_load.'(1);">'.$prevlabel.'</a></li>';
		}else {
			$out .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="'.$fuc_load.'('.($page-1).');">'.$prevlabel.'</a></li>';
		}
		
		// first label
		if($page>($adjacents+1)) {
			$out .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="'.$fuc_load.'(1);">1</a></li>';
		}

		// interval
		if($page>($adjacents+2)) {
			$out .= '<li class="page-item"><a class="page-link">...</a></li>';
		}

		// pages
		$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
		$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
		for($i=$pmin; $i<=$pmax; $i++) {
			if($i==$page) {
				$out .= '<li class="page-item active"><a class="page-link">'.$i.'</a></li>';
			}else if($i==1) {
				$out .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="'.$fuc_load.'(1);">'.$i.'</a></li>';
			}else {
				$out .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="'.$fuc_load.'('.$i.');">'.$i.'</a></li>';
			}
		}

		// interval
		if($page<($tpages-$adjacents-1)) {
			$out .= '<li class="page-item"><a class="page-link">...</a></li>';
		}

		// last
		if($page<($tpages-$adjacents)) {
			$out .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="'.$fuc_load.'('.$tpages.');">'.$tpages.'</a></li>';
		}

		// next
		if($page<$tpages) {
			$out .= '<li class="page-item"><a class="page-link" href="javascript:void(0);"" onclick="'.$fuc_load.'('.($page+1).');">'.$nextlabel.'</a></li>';
		}else {
			$out .= '<li class="page-item disabled"><a class="page-link">'.$nextlabel.'</a></li>';
		}
		
		$out .= '</ul></nav>';
		return $out;
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

	public static function nicetime($date){
		if(empty($date)) {
			return "No date provided";
		}
		
		$periods 	= array("segundo", "minuto", "hora", "día", "semana", "mes", "año", "decada");
		$lengths 	= array("60","60","24","7","4.35","12","10");
		$now 		= time();
		$unix_date 	= strtotime($date);
		
		   // check validity of date
		if(empty($unix_date)) {    
			return "Error en la fecha";
		}

		// is it future date or past date
		if($now > $unix_date) {    
			$difference     = $now - $unix_date;
			$tense         = "hace";
			
		} else {
			$difference     = $unix_date - $now;
			$tense         = "justo ahora";
		}
		
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
		
		$difference = round($difference);
		
		if($difference != 1) {
			if ($periods[$j]=="mes") {
				$periods[$j].= "es";
			}else{
				$periods[$j].= "s";
			}
		}
		return "{$tense} $difference $periods[$j]";
	}
}
