<!-- Create Post Button div -->
<div class="create-post-btn btn" type="div" data-bs-toggle="modal" data-bs-target="#createPostModal">
    <img src="icons/add.svg" alt="Create Post Button" style="height: 36px; width: 36px;">
</div>

<!-- Create Post Modal -->
<div class="modal fade p-3" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-create-post modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="more-option-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="icons/close-btn.svg" alt="">
                </div>
            </div>

            <!-- Modal body -->
            <div class=" create-post-modal-body d-flex flex-column justify-content-center align-items-center w-100 p-3">
                <h3 class="mb-3">Create a New Post</h3>
                <form action="#" method="POST" enctype="multipart/form-data" class="w-100">

                    <!-- Description -->
                    <div class="mb-3 d-flex flex-column align-items-start">
                        <label for="postDescription" class="form-label ms-2">Description</label>
                        <textarea class="form-control" id="postDescription" rows="5" placeholder="Write something..."
                            required name="description"></textarea>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3 d-flex flex-column align-items-start">
                        <label for="postImage" class="form-label ms-2">Upload
                            Image</label>
                        <input type="file" class="form-control" id="postImage" accept="image/*" name="image">
                    </div>

                    <!-- Post Button -->
                    <div class="d-flex justify-content-end mb-2">
                        <button type="submit" class="btn btn-primary">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>