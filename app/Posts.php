<?php

/*
 * Goonswarm Federation - Black Hand Tools
 *
 * Developed by scopehone <scopeh@gmail.com>
 * In conjuction with Izzy, such a hard customer! 
 *
 */

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Vanguard\Presenters\PostsPresenter;
use Laracasts\Presenter\PresentableTrait;
use Kyslik\ColumnSortable\Sortable;

class Posts extends Model
{
    use 
	PresentableTrait,
	Notifiable,
    Sortable;

	protected $presenter = PostsPresenter::class;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'author', 'subject', 'category', 'description'
    ];

    public $sortable = ['id', 'author', 'subject', 'category', 'description', 'created_at'];

}



