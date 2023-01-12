<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LubusStore | {{title}}</title>
    {{links}}
    <link rel="stylesheet" href="{{URL}}/resources/views/admin/styles/views.css">
    <link rel="stylesheet" href="{{URL}}/resources/views/admin/styles/products.css">
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
                                <li class="breadcrumb-item active">{{title}}</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card">
                    <div class="card-body p-0">
                        <table class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th style="width: 1%">
                                        #
                                    </th>
                                    <th style="width: 10%">
                                        Product Name
                                    </th>
                                    <th style="width: 10%">
                                        Image
                                    </th>
                                    <th style="width: 5%">
                                        Price
                                    </th>
                                    <th style="width: 10%; text-align:center;">
                                        Discount Price
                                    </th>
                                    <th style="width: 10%;">
                                        Categorie
                                    </th>
                                    <th style="width: 30%">
                                        Description
                                    </th>
                                    <th style="width: 20%">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                {{itens}}

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="col">
                    {{status}}
                    {{pagination}}
                </div>
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