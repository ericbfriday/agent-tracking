@extends('layouts.app')

@section('page-title','Spymasters Posts')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Spymasters Posts
            <small>- list of spymasters posts</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">Spymasters Posts</li>
                </ol>
            </div>

        </h1>
    </div>
</div>

@include('partials.messages')

<div class="row tab-search">
    <div class="col-md-2">
        <a href="{{ route('posts.create') }}" class="btn btn-success" id="add-group">
            <i class="glyphicon glyphicon-plus"></i>
            Create Post
        </a>
    </div>
    <div class="col-md-7"></div>
    <form method="GET" action="" accept-charset="UTF-8" id="groups-form">
        <div class="col-md-3">
            <div class="input-group custom-search-form">
                <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="Search Posts">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="search-groups-btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    @if (Input::has('search') && Input::get('search') != '')
                        <a href="{{ route('group.list') }}" class="btn btn-danger" type="button" >
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    @endif
                </span>
            </div>
        </div>
    </form>
</div>

<div class="table-responsive top-border-table" id="groups-table-wrapper">
    <table class="table" id="posts">
        <thead>
            <th> @sortablelink('id', 'Post ID')</th>
            <th> @sortablelink('author', 'Author')</th>
            <th> @sortablelink('subject', 'Subject')</th>
            <th> @sortablelink('created_at', 'Created')</th>
            <th class="text-center">@lang('app.action')</th>
        </thead>
        <tbody>
            @if (count($posts))
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->author }}</td>
                        <td>{{ $post->subject }}</td>
                        <td>{{ $post->created_at->diffForHumans() }}</td>
                        <td class="text-center">
                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-success btn-circle"
                               title="View Post" data-toggle="tooltip" data-placement="top">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a>
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary btn-circle edit" title="Edit Post"
                                    data-toggle="tooltip" data-placement="top">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                            <a href="{{ route('posts.delete', $post->id) }}" class="btn btn-danger btn-circle" title="Delete Post"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    data-method="DELETE"
                                    data-confirm-title="Please Confirm"
                                    data-confirm-text="Are you Sure"
                                    data-confirm-delete="Yes Delete">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6"><em>@lang('app.no_records_found')</em></td>
                </tr>
            @endif
        </tbody>
    </table>

    {!! $posts->render() !!}
</div>

@stop
