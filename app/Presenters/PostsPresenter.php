<?php

namespace Vanguard\Presenters;

use Illuminate\Support\Str;
use Laracasts\Presenter\Presenter;

use Vanguard\Posts;

class PostsPresenter extends Presenter
{

	public function author()
	{
		return sprintf("%s", $this->entity->author);
	}

	public function subject()
	{
		return sprintf("%s", $this->entity->subject);
	}

	public function category()
	{
		return sprintf("%s", $this->entity->category);
	}

	public function description()
	{
		return sprintf("%s", $this->entity->description);
	}
   

}
