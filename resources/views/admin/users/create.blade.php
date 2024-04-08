@extends('templates.main')

@section('content')
<h1>Create New User</h1>
<div class="card">
    <form method="post" action="{{ route('admin.users.store') }}">
        <!-- To pass the exact variables -->
        @include('admin.users.partials.form', ['create' => true])
    </form>
</div>
@endsection

