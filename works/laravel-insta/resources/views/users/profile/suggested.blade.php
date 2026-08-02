@extends('layouts.app')

@section('title','suggestes')

@section('content')
   @if($suggested_users->count())
         <h2 class="text-muted text-center">Suggested Users</h2>
           @foreach ($suggested_users as $user)
            <div class="row align-items-center w-50 mx-auto">
              <div class="col-auto">
                <a href="{{route('profile.show', $user->id)}}">
                    @if($user->avatar)
                    <img src="{{$user->avatar}}" alt="{{$user->name}}" class="rounded-circle avatar-sm">
                    @else
                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                    @endif
                </a>
            </div>
            <div class="col">
                <a href="{{route('profile.show',$user->id)}}" class="text-decoration-none text-dark fw-bold">{{$user->name}}</a>
            </div>
            <div class="col-auto">
                 <form action="{{route('follow.store', $user->id)}}" method="post">
                    @csrf
        
                    <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                </form>
            </div>
            </div>
           @endforeach
    @endif
  
@endsection


