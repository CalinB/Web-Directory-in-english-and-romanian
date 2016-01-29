<?php

class CommentsController extends BaseController 
{
	
	public function getCreateComment($domain_id)
	{
		$domain = Domain::find($domain_id);
		
		return View::make('comments.create', compact('domain'));
	}
	
	public function createComment()
	{
		$comment_text = e(Input::get('comment'));
		
		$nice_input_names = ['comment' => trans('directory.comment')];
		
		$validator = Validator::make(['comment' => $comment_text], ['comment' => 'required|between:10,1000'], [], $nice_input_names);
		
		if($validator->fails())
		{
			return '';
		}
		
		$comment = new Comment;
		
		$comment->domain_id = e(Input::get('domain_id'));
		$comment->user_id = Auth::check() ? Auth::user()->id : null;
		$comment->status = (Acl::isSuperAdmin()) ? 1 : 0;	
		$comment->comment = $comment_text;
		$comment->save();
		
		return trans('directory.comment_added');
	}
	
	public function getEditComment($id)
	{
		$comment = Comment::find($id);
				
		return View::make('comments.edit', compact('comment'));	
	}
	
	public function editComment()
	{
		if( ! Acl::isSuperAdmin()) 
		{
			return Redirect::route('home');
		}
		
		$id = e(Input::get('id'));
		
		$comment = Comment::find($id);
		
		$comment->comment = e(Input::get('comment'));
		$comment->save();
		
		return Redirect::to(Domain::seoURL($comment->domain->id))->with('success', trans('directory.comment_updated'));
	}
	
	public function approveDisapproveHandle()
	{
		if( ! Acl::isSuperAdmin()) 
		{
			return Redirect::route('home');
		}
		
		$id = e(Input::get('id'));
		
		$comment = Comment::find($id);
		
		$comment->status = (bool)e(Input::get('status'));
		$comment->save();
		
		return Redirect::back()->with('success', trans('directory.approve-disapprove'));
	}
	
	public function deleteComment()
	{
		if( ! Acl::isSuperAdmin()) 
		{
			return Redirect::route('home');
		}
		
		$id = e(Input::get('id'));
		
		$comment = Comment::find($id);
		$comment->delete();		
		
		return Redirect::back()->with('success', trans('directory.comment_deleted'));
	}
}