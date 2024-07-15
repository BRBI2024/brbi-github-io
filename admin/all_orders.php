<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>All Orders</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
        </svg>
    </div>
    <div id="main-wrapper">
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="dashboard.php">
                        <span><img src="images/icn.png" alt="homepage" class="dark-logo" /></span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0"></ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="images/bookingSystem/user-icn.png" alt="user" class="profile-pic" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-label">Home</li>
                        <li><a href="dashboard.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a></li>
                        <li class="nav-label">Log</li>
                        <li><a href="all_users.php"><span><i class="fa fa-user f-s-20"></i></span><span>Users</span></a></li>
                        <li> <a href="all_orders.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Orders</span></a></li>

                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-history" aria-hidden="true"></i><span class="hide-menu">History</span></a>
                            <ul aria-expanded="false" class="collapse">
								<li><a href="order_rejected.php">Cancelled Orders</a></li>
								<li><a href="order_approved.php">Approved Orders</a></li>
                              
                                
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <i class="fa fa-archive f-s-20 color-warning"></i><span class="hide-menu">Supplier</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="all_restaurant.php">All Supplier</a></li>
                                <li><a href="add_category.php">Add Category</a></li>
                                <li><a href="add_restaurant.php">Add Supplier</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <i class="fa fa-cutlery" aria-hidden="true"></i><span class="hide-menu">Supply</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="all_menu.php">All Supply</a></li>
                                <li><a href="add_menu.php">Add Supply</a></li>
                            </ul>
                        </li>
                        <!-- <li><a href="all_orders.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Orders</span></a></li> -->
                    </ul>
                </nav>
            </div>
        </div>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">All Orders</h4>
                            </div>
                            <div class="table-responsive m-t-40">
                            <div class="card-body">
                                <form method="GET" action="all_orders.php">
                                    <div class="form-row">
                                        <!-- <div class="form-group col-md-4">
                                            <input type="text" class="form-control" name="search_title" placeholder="Search" value="<?php echo isset($_GET['search_title']) ? $_GET['search_title'] : ''; ?>">
                                        </div> -->
                                        <div class="form-group col-md-3">
                                            <input type="date" class="form-control" name="start_date" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="date" class="form-control" name="end_date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <table id="myTable" class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Branch</th>
                                            <th>Supply</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total Price</th>
                                            <!-- <th>Address</th> -->
                                            <th>Status</th>
                                            <th>Reg-Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $search_title = isset($_GET['search_title']) ? $_GET['search_title'] : '';
                                        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
                                        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

                                        $sql = "SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id = users_orders.u_id WHERE (users_orders.status IS NULL OR users_orders.status = '' OR users_orders.status = 'in process')";

                                        if (!empty($search_title)) {
                                            $sql .= " AND users_orders.title LIKE '%$search_title%'";
                                        }

                                        if (!empty($start_date) && !empty($end_date)) {
                                            $sql .= " AND users_orders.date BETWEEN '$start_date' AND '$end_date'";
                                        } elseif (!empty($start_date)) {
                                            $sql .= " AND users_orders.date >= '$start_date'";
                                        } elseif (!empty($end_date)) {
                                            $sql .= " AND users_orders.date <= '$end_date'";
                                        }

                                        $query = mysqli_query($db, $sql);

                                        if (!mysqli_num_rows($query) > 0) {
                                            echo '<td colspan="8"><center>No Orders</center></td>';
                                        } else {
                                            while ($rows = mysqli_fetch_array($query)) {
                                                echo '<tr>
                                                    <td>' . $rows['username'] . '</td>
                                                    <td>' . $rows['title'] . '</td>
                                                    <td>' . $rows['quantity'] . '</td>
                                                    <td>₱' . $rows['price'] . '</td>
                                                    <td>₱' . ($rows['price'] * $rows['quantity']) . '</td>';

                                                $status = $rows['status'];
                                                if ($status == "" or $status == "NULL") {
                                                    echo '<td> <button type="button" class="btn btn-info"><span class="fa fa-bars" aria-hidden="true"></span> Pending</button></td>';
                                                } 
                                                //   elseif ($status == "in process") {
                                                //     echo '<td> <button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin" aria-hidden="true"></span> On The Way!</button></td>';
                                                // } 
                                                  elseif ($status == "closed") {
                                                    echo '<td> <button type="button" class="btn btn-success"><span  class="fa fa-check-circle" aria-hidden="true"> Approved</button></td>';
                                                } elseif ($status == "rejected") {
                                                    echo '<td> <button type="button" class="btn btn-danger"> <i class="fa fa-close"></i> Rejected</button></td>';
                                                }
                                                echo '<td>' . $rows['date'] . '</td>
                                                      <td>
                                                          
                                                          <a href="view_order.php?user_upd=' . $rows['o_id'] . '" class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="fa fa-edit"></i></a>
                                                      </td>
                                                  </tr>';
                                            }
                                        }
                                        ?>
                                        <!-- <a href="delete_orders.php?order_del=' . $rows['o_id'] . '" onclick="return confirm(\'Are you sure?\');" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-trash-o" style="font-size:16px"></i></a> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <footer class="footer">© 2022 - Online Food Ordering System</footer> -->
        </div>
    </div>
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    
</body>

</html>