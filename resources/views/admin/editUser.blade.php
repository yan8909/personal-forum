@extends('layouts.admin')

@section('title')
    Editing {{ $user->name }}
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            Editing {{ $user->name }}
                        </div>
                        @if(Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif   
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('adminEditUserPost', $user->id) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="normal-input" class="form-control-label">Name</label>
                                            <input name="name" id="normal-input" value="{{ $user->name }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="normal-input" class="form-control-label">Email</label>
                                            <input name="email" type="email" id="normal-input" value="{{ $user->email }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="normal-input" class="form-control-label">Permissions</label>
                                                <br>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="admin" value=1 {{ $user->admin == true ? 'checked' : '' }} id="defaultCheck1">
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        Admin
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                </div>
    
                                <button class="btn btn-success" type="submit">Update user</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection