@extends('layouts.app')

@section('title','Admin: Categories')

@section('content')
    <main class="container">
        <div class="row justify-content-center">
                 <div class="mb-3">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="row gx-2">
                            <div class="col">
                                <input type="text" name="name" class="form-control" placeholder="Add a categorie">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary w-80">
                                    <i class="fa-solid fa-plus"></i>ADD
                                </button>
                            </div>
                        </div>
                    </form>
                 </div>
                     <table class="table table-sm ">
                        <thead class="table-warning">
                            <tr>
                                <th>#</th>
                                <th>NAME</th>
                                <th>COUNT</th>
                                <th>LAST UPDATED</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $categorie)
                                <tr>
                                    <td>{{ $categorie->id }}</td>
                                    <td>{{ $categorie->name }}</td>
                                    <td>{{ $categorie->category_post_count }}</td>
                                    <td>{{ $categorie->created_at}}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#edit-category-{{ $categorie->id }}"><i class="fa-solid fa-pencil"></i></button>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-category-{{ $categorie->id }}"><i class="fa-solid fa-trash-can"></i></button>
                                        @include('admin.categories.modals.status')
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                            <tr>
                                <td></td>
                                <td>Uncategorized</td>
                                <td>{{ $uncategorizedCount }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                     </table>
        </div>
</main>
@endsection
