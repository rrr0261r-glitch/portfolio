<div class="modal fade" id="toggle-post-{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h5 modal-title text-danger">
                        <i class="fa-solid fa-eye-slash"></i> Hide Post
                </h3>
            </div>
            <div class="modal-body">
                <p>
                    Are you sure you want to {{ $post->admin ? 'unhide' : 'hide' }}
                    post?
                </p>
                <img src="{{ $post->image }}" style="width:80px;height:80px;object-fit:cover;">
                <p class=""> {{ $post->description}}</p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('admin.posts.toggle', $post->id) }}" method="post">
                    @csrf
                    @method('PATCH')

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Hide</button>
                </form>
            </div>
        </div>
    </div>
</div>
