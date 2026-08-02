<!-- Edit -->
<div class="modal fade" id="edit-category-{{ $categorie->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title">
                    <i class="fa-regular fa-pen-to-square"></i> Edit Category
                </h3>
            </div>
            <form action="{{ route('admin.categories.update', $categorie->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <input type="text" name="name" class="form-control" value="{{ $categorie->name }}">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-warning btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete-category-{{ $categorie->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h5 modal-title text-danger">
                    <i class="fa-solid fa-trash-can"></i> Delete Category
                </h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <span class="fw-bold">{{ $categorie->name }}</span>category?</p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('admin.categories.destroy', $categorie->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
