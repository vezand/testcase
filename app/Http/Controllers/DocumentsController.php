<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;


class DocumentsController extends Controller
{
    public function index(){

		$documents = Document::orderBy('created_at','asc')->paginate(20);

		$data = array(
			'documents'=>$documents
		);


		return view('home')->with($data);
	}
	
	function getDocument(request $request, $id)
	{
	
		$data = array(
			'document'=>Document::find($id)
		);

		return view('documents/single')->with($data);
		
		
	}

	function saveDocument(request $request){
		
		if(!is_array(getimagesize($request->filedata->getPathname()))){
			
			return json_encode(array("st"=>3));
		}

		if(!$request->hasFile('filedata'))
		{
			return json_encode(array("st"=>2));
		}

		$document = new Document;

		$filepath = $request->filedata->store('public/upload/');

		$ext = \File::extension($filepath);

		$name = basename($filepath);

		$file = str_replace(".".$ext, "", $name);
        $thumb = $file."_1.".$ext;

		$document->filepath = $name;
		$document->thumbpath = $thumb;

		$document->save();

		$image = $request->file('filedata');

		$filename = $image->getClientOriginalName();

		$image_resize = Image::make($image->getRealPath());    
          
		$image_resize->resize(300, null, function ($constraint) {
			$constraint->aspectRatio();
		});

		$image_resize->save(storage_path('app/public/upload/' .$thumb));


		return json_encode(array("st"=>1));
	}

	

}
