<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LubusStore | {{title}}</title>
  {{links}}
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    {{preloader}}

    {{header}}

    {{sidebar}}

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">{{title}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{URL}}/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Forms</li>
                <li class="breadcrumb-item active">{{title}}</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
      <div class="container-fluid">
      <form method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Product</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
            </div>

            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input name="name" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter catalog name">
              </div>
              <div class="form-group">
                <label for="inputDescription">Description</label>
                <textarea name="description" id="inputDescription" class="form-control" rows="4"></textarea>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Price</label>
                <input name="price" type="number" min="1" step="any" class="form-control form-control-border" id="exampleInputEmail1" placeholder="Enter the price">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Discount Price</label>
                <input name="discount_price" type="number" min="1" step="any" class="form-control form-control-border" id="exampleInputEmail1" placeholder="Enter the price">
              </div>
              <div class="row w-50">
                    <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label>Categorie</label>
                        <select name="cat_id" class="form-control" >
                          <option value=""></option>
                          {{categories}}
                        </select>
                      </div>
                    </div>
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
              {{statusSuccess}}
              {{statusError}}
              <div class="col float-right">
                <button type="submit" class="btn btn-success float-right">Submit</button>
                <input type="hidden" name="reg_product" value="reg_product">
              </div>
            </div>
          </div>
        </div>
      </form>
       </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    {{footer}}

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  {{scriptlinks}}
</body>

</html>