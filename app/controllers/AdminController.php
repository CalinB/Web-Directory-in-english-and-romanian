<?php

class AdminController extends BaseController {
	
	public function getPendingDomains()
	{
		$domains = Domain::where('status', 0)->paginate(6);
		
		return View::make('admin.pending_domains')->with(compact('domains'));
	}
	
	public function pendingComments()
	{
		$comments = Comment::where('status', 0)->paginate(8);
		
		return View::make('admin.pending_comments')->with(compact('comments'));
	}
	
	public function allComments()
	{
		$comments = Comment::paginate(8);
		
		return View::make('admin.pending_comments')->with(compact('comments'));
	}
	
	public function getAttempts()
	{
		$attempts = Attempt::paginate(8);
				
		return View::make('admin.attempts')->with(compact('attempts'));
	}
	
	public function attemptDetails($id)
	{
		$attempt = Attempt::find($id);
		
		$category = Category::find($attempt->category_id) ? Category::find($attempt->category_id)->name : 'N/A';
		
		$similar_domains = Domain::where('url', 'LIKE', '%'.$attempt->url.'%')->get();
		
		return View::make('admin.attempt_details')->with(compact('attempt', 'category', 'similar_domains'));
	}
	
	public function attemptDelete($attempt_id)
	{
		$attempt = Attempt::find($attempt_id);
		
		$attempt->delete();
		
		$next_attempt = Attempt::first();
		
		if($next_attempt) 
		{
			return $this->attemptDetails($next_attempt->id);
		}
		
		return Redirect::route('home')->with('success', 'Attempts deleted!');
	}
	
	public function attemptAdd($attempt_id)
	{
		$attempt = Attempt::find($attempt_id);
		
		$categories = Category::getCategories();
		
		return View::make('admin.attempt_add')->with(compact('attempt', 'categories'));
	}
}