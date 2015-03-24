<?php namespace bbs\Http\Controllers;

use bbs\Http\Requests;
use bbs\Http\Controllers\Controller;

use Illuminate\Http\Request;

use bbs\Comment;

class CommentController extends Controller {

	protected $comment;
	public function __construct(Comment $comment) {
		$this->comment = $comment;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($message_id)
	{
		return response()->json(
			$this->comment
				->where('message_id', '=', $message_id)
				->orderBy('created_at','desc')->get()
		);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($message_id, Requests\CreateCommentRequest $request)
	{
		$comment = $request->all();
		$comment['message_id'] = $message_id;
		$this->comment->create($comment);
		return response()->json(array('success' => true));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($message_id, $comment_id)
	{
		$this->comment->findOrFail($comment_id)->delete();
		return response()->json(array('success' => true));
	}
}
