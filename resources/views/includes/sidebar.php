<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{URL}}" class="brand-link">
      <img src="{{URL}}/resources/assets/images/logo-lubus-wolf.png" alt="LubusStore Logo" class="brand-image " style="opacity: .8">
      <span class="brand-text font-weight-light">LS Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{URL}}/resources/assets/images/blank-user.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item {{menu_open_forms}}">
            <a href="#" class="nav-link {{active_forms}}">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Forms
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="" class="nav-link {{active_forms_account}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Account</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{URL}}/forms/categorie" class="nav-link {{active_forms_categorie}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Categorie</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link {{active_forms_product}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Product</p>
                </a>
              </li>
            </ul>
            <li class="nav-item">
                <a href="{{URL}}/categories" class="nav-link {{active_categories}}">
                <i class="nav-icon fa fa-images"></i>
                  <p>Categories</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link {{active_products}}">
                <i class="nav-icon fa fa-cart-shopping"></i>
                  <p>Products</p>
                </a>
            </li>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>