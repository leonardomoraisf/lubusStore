<section class="content">
      <div class="container-fluid">
      <form method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Categorie</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
            </div>

            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input value="" name="name" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter categorie name">
              </div>
              <div class="form-group">
                <label for="inputDescription">Description</label>
                <textarea name="description" id="inputDescription" class="form-control " rows="4"></textarea>
              </div>
              <div class="form-group">
                <label for="exampleInputFile">Image</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="row">
                <div class="col-4 alert alert-danger alert-dismissible float-left w-25">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    Error!
                </div>
                <div class="col-4 alert alert-success alert-dismissible float-left">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i> Success!</h5>
                    Success!
                </div>
              <div class="col float-right">
                <button type="submit" class="btn btn-success float-right">Submit</button>
              </div>
            </div>
          </div>
        </div>
       </div><!-- /.container-fluid -->
    </section>