<?php

class UrlController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Url::all();
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = [
			'url' => 'required|url|unique:urls',
			'title' => 'required'
		];

		$input = Input::only('url','title');

		$validator = Validator::make($input,$rules);

		if ($validator->fails())
		{
	       return Response::json(array(
		        'errors' => $validator->getMessageBag()->toArray()
		    ), 400); 
		}

		$input['user_id'] = Sentry::getUser()->id;

		$url = Url::create($input);

		return Response::json(array(
		        'url' => $url->toArray()
		    ), 201);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{	
		$rules = [
			'url' => 'required|url|unique:urls,url,'.$id,
			'title' => 'required'
		];

		$input = Input::only('url','title');

		$validator = Validator::make($input,$rules);

		if ($validator->fails())
		{
	       return Response::json(array(
		        'errors' => $validator->getMessageBag()->toArray()
		    ), 400); 
		}

		$url = Url::find($id);

		$url->fill($input);

		$url->save();

		return $url;

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Url::destroy($id);

		return Response::json('success', 200);
	}


}
