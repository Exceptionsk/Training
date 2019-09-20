@extends('layouts.master')
@section('title','User')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">
        @if(isset($profile))
            Update Post
        @else
            {{ isset($post) ?  'Post Edit' : 'Post Entry' }}
        @endif
    </h1>

    {{--check new or edit--}}
    @if(isset($post))
        {!! Form::open(array('url' => '/frontend/post/update', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/frontend/post/store', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($post)? $post->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="user_name">Post Name<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input required type="text" class="form-control" id="name" name="name" placeholder="Enter Post Name" value="{{ isset($post)? $post->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('user_name')}}</p>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="address">Descriptions</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
             <textarea rows="4" cols="50"class="form-control" id="descriptions" name="descriptions" placeholder="Enter Descriptions">{{ isset($post)? $post->descriptions:Request::old('address') }}</textarea>
            <p class="text-danger">{{$errors->first('address')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($post)? 'UPDATE' : 'ADD'}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('post')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
@stop
