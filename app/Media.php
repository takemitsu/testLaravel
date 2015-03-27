<?php namespace bbs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model {

	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $thumb_width = 240;

	// 代入を許す属性
	protected $fillable = [
		'uuid',
		'filename',
		'ext',
		'filepath',
		'filesize',
		'mime_type'
	];

	/*
	| サムネイルのURLを生成
	*/
	public function thubnail_url() {
		$paths = $this->make_media_storedname();
		$thumb_url = $paths['path'] . "/" . $this->uuid ."_" . $this->thumb_width . ".png";
		if(file_exists($paths['root'].$thumb_url)) {
			return $thumb_url;
		}
		else {
			return null;
		}
	}

	/*
	| 横幅360のサムネイルを生成する
	*/
	public function make_thumbnail_360() {
		// $thumb_width = 360;
		$thumb_width = $this->thumb_width;

		$paths = $this->make_media_storedname();
		if($paths == null) {
			return response()->error('500');
		}
		$file_name  = $paths['root'] . $paths['path'] . "/" . $paths['name'];
		$thumb_name = $paths['root'] . $paths['path'] . "/" . $this->uuid . "_$thumb_width.png";

		// オリジナルリソース準備
		$original_image = null;
		if(preg_match('/^image/', $this->mime_type)) {

			if(preg_match('/png/',$this->mime_type)) {
				$original_image = imagecreatefrompng($file_name);
			}
			else if(preg_match('/jpe?g/', $this->mime_type)) {
				$original_image = imagecreatefromjpeg($file_name);
			}
			else if(preg_match('/gif/', $this->mime_type)) {
				$original_image = imagecreatefromgif($file_name);
			}
		}
		if($original_image == null) {
			// png/jpg/gif以外は無視
			return false;
		}
		// オリジナル画像の横幅・高さを取得
		list($original_width, $original_height) = getimagesize($file_name);
		// 高さを算出
		$thumb_height = round( $original_height * $thumb_width / $original_width );

		// サムネファイルリソース準備(黒画像らしい)
		$thumb_image = imagecreatetruecolor($thumb_width, $thumb_height);

		// オリジナルをリサイズしてサムネ画像作成
		if(!imagecopyresized(
			$thumb_image,		// サムネファイルリソース
			$original_image,	// オリジナルファイルリソース
			0,	// サムネ x
			0,	// サムネ y
			0,	// オリジナル x
			0,	// オリジナル y
			$thumb_width,	// サムネ width
			$thumb_height,	// サムネ height
			$original_width,	// オリジナル width
			$original_height	// オリジナル height
			)) {
			return response()->error('500');
		}
		// サムネ画像ファイル出力
		if(!imagepng($thumb_image, $thumb_name)) {
			return response()->error('500');
		}

		// 画像リソースを破棄
		imagedestroy($original_image);
		imagedestroy($thumb_image);

	}
	/*
	| ファイル格納パスを作る
	*/
	public function make_media_storedname() {
		$media_storepath = config('filesystems.media_storepath');
		if(!$media_storepath) {
			// return response()->error('500');
			return null;
		}
		$document_root = $_SERVER['DOCUMENT_ROOT'];
		$path = "/$media_storepath/" . substr($this->uuid,0,1) . "/" . substr($this->uuid,1,1);
		$uuid_filename = $this->uuid . "." . $this->ext;

		if(!file_exists($document_root.$path)) {
			if(!mkdir($document_root.$path, 0755, true)) {
				// error
				return null;
			}
		}

		return array(
			'root' => $document_root,
			'path' => $path,
			'name' => $uuid_filename
		);
	}

}
