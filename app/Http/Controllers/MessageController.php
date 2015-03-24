<?php namespace bbs\Http\Controllers;

use bbs\Http\Requests;
use bbs\Http\Controllers\Controller;

use Illuminate\Http\Request;

use bbs\Message;

class MessageController extends Controller {

	protected $message;
	public function __construct(Message $message) {
		$this->message = $message;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return response()->json($this->message->orderBy('created_at','desc')->get());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Requests\CreateMesssageRequest $request)
	{
		$this->message->create($request->all());
		return response()->json(array('success' => true));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return response()->json($this->message->findOrFail($id));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->message->findOrFail($id)->delete();
		return response()->json(array('success' => true));
	}
}
