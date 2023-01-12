<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LubusStore | {{title}}</title>
    {{links}}
    <link rel="stylesheet" href="{{URL}}/resources/views/admin/styles/views.css">
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
                            <h1 class="m-0">"{{title}}"</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{URL}}/dashboard">Home</a></li>
                                <li class="breadcrumb-item active">{{title}}</li>
                                <li class="breadcrumb-item active">Edit</li>
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
                                        <h3 class="card-title">Edit</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <img alt="image" class="rounded-circle edit-image" src="{{p_img}}">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Name</label>
                                            <input value="{{p_name}}" name="name" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter product name">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Description</label>
                                            <textarea name="description" id="inputDescription" class="form-control">{{p_desc}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Price</label>
                                            <input value="{{p_price}}" name="price" type="number" min="1" step="any" class="form-control form-control-border" id="exampleInputEmail1" placeholder="Enter the price">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Discount Price</label>
                                            <input value="{{p_dis_price}}" name="discount_price" type="number" min="1" step="any" class="form-control form-control-border" id="exampleInputEmail1" placeholder="Enter the discount price">
                                        </div>
                                        <div class="row w-50">
                                            <div class="col-sm-6">
                                                <!-- select -->
                                                <div class="form-group">
                                                    <label>Categorie</label>
                                                    <select name="cat_id" class="form-control">
                                                        <option value="{{actual_cat_id}}">Atual : {{actual_cat_name}}</option>
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
                                    {{statusError}}
                                    {{statusSuccess}}
                                    <div class="col float-right">
                                        <button type="submit" class="btn btn-success float-right">Submit</button>
                                    </div>
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