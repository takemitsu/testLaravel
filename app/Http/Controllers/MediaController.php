<?php namespace bbs\Http\Controllers;

use bbs\Http\Requests;
use bbs\Http\Controllers\Controller;

use Illuminate\Http\Request;

use bbs\Media;

class MediaController extends Controller {

	protected $media;
	public function __construct(Media $media) {
		$this->media = $media;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// ファイルリストは不要か
		return response()->json(array('success' => true));
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

				$uuid = uuid_create(UUID_TYPE_TIME);
				$mime_type = $file->getMimeType();
				$filename = $file->getClientOriginalName();
				$filesize = $file->getClientSize();
				$ext = $file->getClientOriginalExtension();

				$media_storepath = config('filesystems.media_storepath');

				if(!$media_storepath) {
					return response()->error('500');
				}

				$path = $_SERVER['DOCUMENT_ROOT'] . "/$media_storepath/" . substr($uuid,0,1) . "/" . substr($uuid,1,1);
				$uuid_filename = "$uuid.$ext";

				if(!file_exists($path)) {
					if(!mkdir($path, 0755, true)) {
						// error
						return response()->error('500');
					}
				}
				$file->move($path, $uuid_filename);

				$media = $this->media->create([
					'uuid'      => $uuid,
					'filename'  => $filename,
					'ext'       => $ext,
					'filepath'  => "", // とりあえず入れないｗ
					'filesize'  => $filesize,
					'mime_type' => $mime_type
				]);

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
		// ファイルパスやらを返す
		$media_storepath = config('filesystems.media_storepath');
		if(!$media_storepath) {
			return response()->error('500');
		}

		$media = $this->media->findOrFail($id);
		$path = "/$media_storepath/" . substr($media->uuid,0,1) . "/" . substr($media->uuid,1,1);
		$uuid_filename = $media->uuid . "." . $media->ext;

		return response()->json(array(
			'url' => "$path/$uuid_filename"
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
		// 削除は不要か
	}

}
