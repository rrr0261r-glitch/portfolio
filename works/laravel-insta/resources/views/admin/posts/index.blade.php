@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')
<table class="table align-middle">
    <thead class="table-primary">
        <tr>
            <th></th>
            <th></th>
            <th>CATEGORY</th>
            <th>OWNER</th>
            <th>CREATED AT</th>
            <th>STATUS</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach( $all_posts as $post)
        <tr>
            <td>{{ $post->id }}</td>
            <td><img src="{{ $post->image }}" style="width:80px;height:80px;object-fit:cover;"></td>
            <td>
                @forelse($post->categoryPost as $categoryPost)
                    <span class="badge bg-secondary">{{ $categoryPost->category->name }}</span>
                @empty
                    <span class="badge bg-dark">Uncategorized</span>
                @endforelse
            </td>
            <td>{{ $post->user->name }}</td>
            <td>{{ $post->created_at }}</td>
                        <td>
                @if(!$post->admin)
                    <i class="fa-solid fa-circle text-success"></i>&nbsp; Visible
                @else
                    <i class="fa-solid fa-circle text-secondary"></i>&nbsp; Hidden
                @endif
            </td>
            <td>
               <div class="dropdown">
                <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-ellipsis"></i>
                </button>
                <div class="dropdown-menu">
                    @if($post->admin)
                    <button class="dropdown-item" data-bs-toggle="modal"
                    data-bs-target="#toggle-post-{{ $post->id }}">
                        <i class="fa-solid fa-eye"></i> Unhide post
                    </button>
                    @else
                     <button class="dropdown-item text-danger" data-bs-toggle="modal"
                        data-bs-target="#toggle-post-{{ $post->id }}">
                     <i class="fa-solid fa-eye-slash"></i> Hide post
                    </button>
                    @endif
                </div>
               </div>
               @include('admin.posts.modals.status')
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $all_posts->links() }}
@endsection
