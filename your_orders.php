<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

if(empty($_SESSION['user_id']))  
{
	header('location:login.php');
}
else
{
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>My Orders</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css" rel="stylesheet">

.indent-small {
  margin-left: 5px;
}
.form-group.internal {
  margin-bottom: 0;
}
.dialog-panel {
  margin: 10px;
}
.datepicker-dropdown {
  z-index: 200 !important;
}
.panel-body {
  background: #e5e5e5;
  background: -moz-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
  background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, #e5e5e5), color-stop(100%, #ffffff));
  background: -webkit-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
  background: -o-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
  background: -ms-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
  background: radial-gradient(ellipse at center, #e5e5e5 0%, #ffffff 100%);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e5e5e5', endColorstr='#ffffff', GradientType=1);
  font: 600 15px "Open Sans", Arial, sans-serif;
}
label.control-label {
  font-weight: 600;
  color: #777;
}

table { 
	width: 100%; 
	border-collapse: collapse; 
	margin: auto;
	}

tr:nth-of-type(odd) { 
	background: #eee; 
	}

th { 
	background: #404040; 
	color: white; 
	font-weight: bold; 
	}

td, th { 
	padding: 10px; 
	border: 1px solid #ccc; 
	text-align: left; 
	font-size: 14px;
	}

@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
	}

	td:before { 
		position: absolute;
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
		content: attr(data-column);
		color: #000;
		font-weight: bold;
	}
}

</style>

</head>

<body>
    
<header id="header" class="header-scroll top-header headrom">

    <nav class="navbar navbar-dark">
        <div class="container">
            <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
            <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/icn.png" alt=""> </a>
            <div class="collapse navbar-toggleable-md float-lg-right" id="mainNavbarCollapse">
                <ul class="nav navbar-nav">
                    <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
                    <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Supplier <span class="sr-only"></span></a> </li>
                    
					<?php
				if(empty($_SESSION["user_id"]))
					{
						echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
					  <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
					}
				else
					{
						echo  '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Order</a> </li>';
						echo  '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
					}
				?>
					 
                </ul>
            </div>
        </div>
    </nav>

</header>
<div class="page-wrapper">

    <div class="inner-page-hero bg-image" data-image-src="images/img/office1.jpg">
        <div class="container"> </div>
    </div>
    <div class="result-show">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div>

    <section class="restaurants-page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12"></div>
                <div class="col-xs-12">
                    <div class="bg-gray">
                        <div class="row">
                        
                        <!-- Add date filter inputs -->
                        <div class="form-group col-md-4">
                            <!-- <label>Search by date:</label> -->
                            <label for="start-date"></label>
                            <input type="date" id="start-date" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="end-date"></label>
                            <input type="date" id="end-date" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <button onclick="filterByDate()" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                            <button onclick="downloadExcel()" class="btn btn-success" style="margin-top: 25px;">Download Excel</button>
                        </div>

                        <table class="table table-bordered table-hover">
                          <thead style="background: #404040; color:white;">
                            <tr>
                              <th>Item</th>
                              <th>Quantity</th>
                              <th>Price</th>
                              <th>Total Price</th>
                              <th>Status</th>
                              <th>Date</th>
                              <!-- <th>Action</th> -->
                            </tr>
                          </thead>
                          <tbody id="order-table">
                          
                            <?php 
            
                            $query_res= mysqli_query($db,"select * from users_orders where u_id='".$_SESSION['user_id']."'");
                            if(!mysqli_num_rows($query_res) > 0 )
                            {
                                echo '<td colspan="7"><center>You have No orders Placed yet. </center></td>';
                            }
                            else
                            {			      
                              
                              while($row=mysqli_fetch_array($query_res))
                              {
                            ?>
                                <tr>	
                                 <td data-column="Item"> <?php echo $row['title']; ?></td>
                                  <td data-column="Quantity"> <?php echo $row['quantity']; ?></td>
                                  <td data-column="price">₱<?php echo $row['price']; ?></td>
                                  <td data-column="totalprice">₱<?php echo $row['price'] * $row['quantity']; ?>.00</td>
                                   <td data-column="status"> 
                                   <?php 
                                                $status=$row['status'];
                                                if($status=="" or $status=="NULL")
                                                {
                                                ?>
                                                <button type="button" class="btn btn-info"><span class="fa fa-bars"  aria-hidden="true" ></span>Pending</button>
                                               <?php 
                                                  }
                                                   if($status=="in process")
                                                 { ?>
                                                    <button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin"  aria-hidden="true" ></span>On The Way!</button>
                                                <?php
                                                    }
                                                if($status=="closed")
                                                    {
                                                ?>
                                                 <button type="button" class="btn btn-success" ><span  class="fa fa-check-circle" aria-hidden="true"></span>Approved</button> 
                                                <?php 
                                                } 
                                                ?>
                                                <?php
                                                if($status=="rejected")
                                                    {
                                                ?>
                                                 <button type="button" class="btn btn-danger"> <i class="fa fa-close"></i>Rejected</button>
                                                <?php 
                                                } 
                                                ?>
                                   </td>
                                  <td data-column="Date"> <?php echo $row['date']; ?></td>
                                   <!-- <td data-column="Action"> <a href="delete_orders.php?order_del=<?php echo $row['o_id'];?>" onclick="return confirm('Are you sure you want to cancel your order?');" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-trash-o" style="font-size:16px"></i></a> 
                                    </td> -->
                                 
                                </tr>
                            <?php }} ?>					
                          </tbody>
                          
                        </table>
                        <div id="no-orders" style="display:none;"><center>No orders found for the selected date range.</center></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
    <div class="container">
        <div class="bottom-footer">
            <div class="row">
                <div class="col-xs-12 col-sm-3 payment-options color-gray">
                    <h5>Contact Us</h5>
                    <p>(088) 858 4252 | 0917-623-6564</p>
                    <p>rb_balingasag@yahoo.com | binhiruralbank@gmail.com | brbihrd@gmail.com</p>
                </div>
                <div class="col-xs-12 col-sm-4 address color-gray">
                    <h5>Address</h5>
                    <p>CM Recto 2F, Leope Building, #833, CM Recto Avenue, Cagayan de Oro City (Formerly Sacred Heart of Jesus Montessori School).</p>
                </div>
                <div class="col-xs-12 col-sm-5 additional-info color-gray">
                    <h5>Additional Information</h5>
                    <p>Binhi Rural Bank Inc (BRBI) is regulated by the Bangko Sentral ng Pilipinas (https://www.bsp.gov.ph).</p>
                </div>
            </div>
        </div>
    </div>
    </footer>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/animsition.min.js"></script>
<script src="js/bootstrap-slider.min.js"></script>
<script src="js/jquery.isotope.min.js"></script>
<script src="js/headroom.js"></script>
<script src="js/foodpicky.min.js"></script>

<script>
function downloadExcel() {
    var startDate = document.getElementById("start-date").value;
    var endDate = document.getElementById("end-date").value;
    window.location.href = 'download_excel.php?start_date=' + startDate + '&end_date=' + endDate;
}
</script>

<!-- Add JavaScript to filter table by date -->
<script>
function filterByDate() {
    var startDate = new Date(document.getElementById("start-date").value);
    var endDate = new Date(document.getElementById("end-date").value);
    var table = document.getElementById("order-table");
    var tr = table.getElementsByTagName("tr");
    var hasOrders = false;

    for (var i = 0; i < tr.length; i++) {
        var td = tr[i].getElementsByTagName("td")[5]; // Column index for Date
        if (td) {
            var orderDate = new Date(td.textContent || td.innerText);
            if (orderDate >= startDate && orderDate <= endDate) {
                tr[i].style.display = "";
                hasOrders = true;
            } else {
                tr[i].style.display = "none";
            }
        }       
    }

    if (hasOrders) {
        document.getElementById("no-orders").style.display = "none";
    } else {
        document.getElementById("no-orders").style.display = "block";
    }
}
</script>

</body>

</html>
<?php
}
?>
