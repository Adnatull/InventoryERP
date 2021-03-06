<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

      <meta name="viewport" content="width=1024">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
      @yield('title')
    </title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('/')}}AdminAssets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="{{asset('/')}}AdminAssets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('/')}}AdminAssets/css/sb-admin.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}AdminAssets/css/sb-admin.css" />

    @stack('customcss')


</head>

<body id="page-top">

<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="{{route('admin')}}">Inventory System</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>



    <!-- Navbar -->
    <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">{{ Auth::user()->name }}</a>
                <a class="dropdown-item" href="{{route('homepage')}}">Home Page</a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();" >Logout</a>
                <form action="{{route('logout')}}" id="logoutForm" method="POST">
                    @csrf
                </form>
            </div>
        </li>
    </ul>

</nav>

<div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="{{route('admin')}}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if(Auth::user()->hasRole('admin'))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-folder"></i>
                <span>Categories</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Category Screens:</h6>
                <a class="dropdown-item" href="{{route('add_category')}}">Add New Category</a>
                <a class="dropdown-item" href="{{route('manage_category')}}">Manage Categories</a>
            </div>
        </li>
        @endif
        @if(Auth::user()->hasRole('admin'))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-folder"></i>
                <span>Product Brands</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Brand Screens:</h6>
                <a class="dropdown-item" href="{{route('add-brand')}}">Add New Brand</a>
                <a class="dropdown-item" href="{{route('manage-brands')}}">Manage Brands</a>
            </div>
        </li>
        @endif
        @if(Auth::user()->hasRole('admin'))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-folder"></i>
                <span>Product Unit</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Product Unit Screens:</h6>
                <a class="dropdown-item" href="{{route('add-unit')}}">Add New Unit</a>
                <a class="dropdown-item" href="{{route('manage-units')}}">Manage Units</a>
            </div>
        </li>
        @endif
        @if(Auth::user()->hasRole('executive'))
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Products</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">

                    <a class="dropdown-item" href="{{route('add-product')}}">Add New Product</a>
                    <a class="dropdown-item" href="{{route('manage-products')}}">Manage Product</a>
                </div>
            </li>
        @endif
        @if(Auth::user()->hasRole('admin'))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-folder"></i>
                <span>Suppliers</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Suppliers Screens:</h6>
                <a class="dropdown-item" href="{{route('add-supplier')}}">Add New Supplier</a>
                <a class="dropdown-item" href="{{route('manage-suppliers')}}">Manage Suppliers</a>
            </div>
        </li>
        @endif
        @if(Auth::user()->hasRole('executive'))
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Customers</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">

                    <a class="dropdown-item" href="{{route('add-customer')}}">Add New Customer</a>
                    <a class="dropdown-item" href="{{route('manage-customers')}}">See All Customers</a>
                </div>
            </li>
        @endif









        @if(Auth::user()->hasRole('executive'))
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Purchase</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">

                    <a class="dropdown-item" href="{{route('buy-products')}}">Purchase New Products</a>
                    <a class="dropdown-item" href="{{route('see-all-purchases')}}">See All Purchases</a>
                </div>
            </li>
        @endif


        @if(Auth::user()->hasRole('seller'))
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Sales</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">

                    <a class="dropdown-item" href="{{route('sell-products')}}">Sell Products</a>
                    <a class="dropdown-item" href="{{route('see-all-sales')}}">See All Sells</a>
                </div>
            </li>
        @endif
        @if(Auth::user()->hasRole('admin'))
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Users</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">

                    <a class="dropdown-item" href="{{route('manage-users')}}">Manage Users</a>
                </div>
            </li>
        @endif

    </ul>

    <div id="content-wrapper" >

        <div class="container-fluid">

            @yield('body')

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © Aloha 2020</span>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{asset('/')}}AdminAssets/vendor/jquery/jquery.min.js"></script>
<script src="{{asset('/')}}AdminAssets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('/')}}AdminAssets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugin JavaScript-->
<script src="{{asset('/')}}AdminAssets/vendor/chart.js/Chart.min.js"></script>
<script src="{{asset('/')}}AdminAssets/vendor/datatables/jquery.dataTables.js"></script>
<script src="{{asset('/')}}AdminAssets/vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('/')}}AdminAssets/js/sb-admin.min.js"></script>

<!-- Demo scripts for this page-->
<script src="{{asset('/')}}AdminAssets/js/demo/datatables-demo.js"></script>
<script src="{{asset('/')}}AdminAssets/js/demo/chart-area-demo.js"></script>



@stack('jscripts')


</body>

</html>
