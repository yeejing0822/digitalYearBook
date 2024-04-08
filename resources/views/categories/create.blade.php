@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Class</h2>
    <form action="{{route('category-store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Enter name"><br>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" class="form-control" name="description" id="description" placeholder="Enter description"><br>
    </div>

    <div class="form-group">
        <label for="cover-image">Cover Image</label>
        <input type="file" class="form-control" name="cover-image" id="cover-image"><br>
    <button type="submit">Submit</button>
    </form>
</div>
@endsection