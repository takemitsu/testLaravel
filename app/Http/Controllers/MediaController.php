<?php namespace bbs\Http\Controllers;

use bbs\Http\Requests;
use bbs\Http\Controllers\Controller;

use Illuminate\Http\Request;

use bbs\Media;

class MediaController extends Controller {

	protected $media;
	public function __construct(Media $media) {
		$this->middleware('auth');
		$this->media = $media;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// とりあえず。
		return response()->json($this->media->orderBy('created_at','desc')->get());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$file = null;

		if($request->hasFile('file')) {
			if($request->file('file')->isValid()) {
				$file = $request->file('file');

				$media = $this->media->create([
					'uuid'      => uuid_create(UUID_TYPE_TIME),
					'filename'  => $file->getClientOriginalName(),
					'ext'       => $file->getClientOriginalExtension(),
					'filepath'  => "", // とりあえず入れないｗ
					'filesize'  => $file->getClientSize(),
					'mime_type' => $file->getMimeType()
				]);

				$paths = $media->make_media_storedname();
				if($paths == null) {
					return response()->error('500');
				}
				$file->move($paths['root'].$paths['path'], $paths['name']);

				$media->make_thumbnail_360();
			}
		}
		if($file == null) {
			return response()->error('500');
		}

		return response()->json(array(
			'success' => true,
			'id' => $media->id,
			'uuid' => $media->uuid,
			'ext'  => $media->ext,
			'filepath' => $media->filepath,
			'filesize' => $media->filesize,
			'mime_type' => $media->mime_type
		));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$media = $this->media->findOrFail($id);
		$paths = $media->make_media_storedname();
		if($paths == null) {
			return response()->error('500');
		}
		return response()->json(array(
			'url' => $paths['path'] . "/" . $paths['name'],
			'mime_type' => $media->mime_type
		));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// とりあえず
		$this->media->findOrFail($id)->delete();
		return response()->json(array('success' => true));
	}

}
