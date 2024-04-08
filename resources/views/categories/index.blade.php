@extends('layouts.app')

@section('content')

<div class="category py-5 bg-light">  
    <div class="container">
        @can('logged-in')
        <a href="{{route('category-userfavList')}}">Users Class Enrollment List</a> <br><br>
        @endcan

    @if (count($categories) > 0)  
                <div class="row">
                    @foreach ($categories as $category)
                        <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img src="/storage/category_covers/{{$category->cover_image}}" alt="{{ $category->cover_image }}" height="200px">
    
                            <div class="card-body">
                            <p class="card-text">{{ $category->name }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                            @can('logged-in')
                                <div class="btn-group">
                                    
                                   

                                    <a href="{{ route('category-show', $category->id)}}" class="btn btn-sm btn-outline-secondary">View</a>
                                    
                                </div>
                               
                                @endcan
                                <small class="text-muted">{{ $category->description }}</small>
                            </div>
                            </div>
                        </div>
                </div>
            @endforeach
        </div>
    @else
        <h3>No class yet</h3>
    @endif
</div>



@endsection


