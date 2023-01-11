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
        <form method="post" enctype="multipart/form-data">
          <div class="container-fluid">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">New User</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Full Name</label>
                  <input name="name" type="text" class="form-control " id="exampleInputEmail1" placeholder="Enter full name">
                </div>
                <label for="exampleInputEmail1">Username</label>
                <div class="input-group mb-3" id="exampleInputEmail1">
                  <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                  </div>
                  <input name="user" type="text" class="form-control" placeholder="Enter username">
                </div>
                <label for="exampleInputEmail1">Email</label>
                <div class="input-group mb-3" id="exampleInputEmail1">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  </div>
                  <input name="email" type="email" class="form-control" placeholder="Enter email">
                </div>
                <label for="exampleInputEmail1">Password</label>
                <div class="input-group mb-3" id="exampleInputEmail1">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  </div>
                  <input name="password" type="password" class="form-control" placeholder="Enter password">
                </div>
                <label for="exampleInputEmail1">Confirm password</label>
                <div class="input-group mb-3" id="exampleInputEmail1">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  </div>
                  <input name="confirmPassword" type="password" class="form-control" placeholder="Enter copnfirm password">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Profile Photo</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                  </div>
                </div>
                <div class="row w-50">
                  <div class="col-sm-6">
                    <!-- select -->
                    <div class="form-group">
                      <label>Position</label>
                      <select name="position" class="form-control ">
                        <option value=""></option>
                        {{positions}}
                      </select>
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
              </div>
            </div>
        </form>
    </div>
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