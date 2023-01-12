<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LubusStore | {{p_name}}</title>
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
                            <h1 class="m-0">{{title}}</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{URL}}/dashboard">Home</a></li>
                                <li class="breadcrumb-item active">{{p_name}}</li>
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
                        <h1><img alt="image" class="rounded-circle edit-image" src="{{p_img}}"> "{{p_name}}"</h1>
                        <hr>
                        <a href="{{URL}}/dashboard/products">
                            <button type="button" class="btn btn-warning">Back</button>
                        </a>
                        <hr>
                        <form method="POST">
                            <div class="form-group">
                                Do you really want to delete this product?
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger">Delete</button>
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