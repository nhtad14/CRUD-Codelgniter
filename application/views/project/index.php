<h2 class="text-center mt-5 mb-3"><?php echo $title; ?></h2>
<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-primary showModal" style="margin-bottom:15px">
            Create New Product
        </button>
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('success')) {?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php } ?>

        <table class="table table-bordered" id="tblUser">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th width=50px>Edit</th>
                    <th width=50px>Delete</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Product</h5>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="formProject">
                    <input type="hidden" class="form-control " id="id_products" name="id_products" value="">
                    <div class=" form-group">
                        <label for="formGroupExampleInput">Name Product</label>
                        <input type="text" class="form-control" id="name_products" name="name_products"
                            placeholder="Name Product">
                        <span style="color:red" id="name_error" class="error"></span>
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput2">Description</label>
                        <textarea class="form-control" id="content" rows="3" name="content" value=""></textarea>
                        <span style="color:red" id="description_error" class="error"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="btn" class="btn btn-primary saveItem">Save product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>