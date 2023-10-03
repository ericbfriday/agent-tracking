<?php

/*
 * Goonswarm Federation - Black Hand Tools
 *
 * Developed by scopehone <scopeh@gmail.com>
 * In conjuction with Izzy, such a hard customer! 
 *
 */

namespace Vanguard\Http\Controllers\Web;

use Vanguard\Events\Group\UpdatedByAdmin;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\Posts\CreatePostsRequest;
use Vanguard\Http\Requests\Posts\UpdateDetailsRequest;
use Vanguard\Http\Requests\Posts\UpdateLoginDetailsRequest;
use Vanguard\Repositories\Posts\PostsRepository;
use Vanguard\Group;
use Vanguard\Agent;
use Vanguard\Handler;
use Vanguard\Posts;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
{
    /**
     * @var SpymasterPostRepository
     */
    private $posts;

    /**
     * SpymasterPostController constructor.
     * @param SpymasterPostRepository $posts
     */
    public function __construct(PostsRepository $posts)
    {
        $this->middleware('auth');
        $this->middleware('permission:posts.manage');
        $this->posts = $posts;
    }

    /**
     * Display paginated list of all posts.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $posts = $this->posts->paginate(
            $perPage = 50,
            Input::get('search')
        );    

        return view('posts.list', compact('posts'));
    }


    /**
     * Displays form for creating a new group.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

    	$author = Auth::user();
    	
        return view('posts.add', compact('author'));
    }


    /**
     * Stores new post into the database.
     *
     * @param CreateSpymasterPostsRequest $request
     * @return mixed
     */
    public function store(CreatePostsRequest $request)
    {

        $data = $request->all();

        $post = $this->posts->create($data);

        return redirect()->route('posts.list')
        ->withSuccess('Post Created');
    }

        /**
     * Displays post page.
     *
     * @param SpymaterPosts $posts
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
        public function view(Posts $post)
        {

            return view('posts.view', compact('post'));
        }

    /**
     * Displays edit post form.
     *
     * @param SpymasterPosts $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Posts $post)
    {
        $edit = true;
        $author = Auth::user();

        return view(
            'posts.edit',
            compact('edit', 'post', 'author')
        );
    }

    /**
     * Updates post details.
     *
     * @param SpymasterPosts $post
     * @param UpdateDetailsRequest $request
     * @return mixed
     */
    public function updateDetails(Posts $post, UpdateDetailsRequest $request)
    {
        $data = $request->all();

        $this->posts->update($post->id, $data);

        return redirect()->route('posts.show', $post->id)
        ->withSuccess('Post Updated');
    }

    public function delete(Posts $post) 
    {

      $this->posts->delete($post->id);
      
      return redirect()->back()->withSuccess('Post Removed');

   }


}