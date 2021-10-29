<?php 
error_reporting(0);
include('dbconn.php');
include('getmethodsqlinjectprotect.php');
session_start();
$username = $_SESSION['username'];
$wallet = $_SESSION['wallet'];
$active = $_SESSION['active'];

if(!$username)
{
  header('location: index.php');
}

$category = $_GET['category'];

$limit = 10;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit; 

?>

<style>
.alert-success {
  padding: 20px;
  background-color: Green;
  color: white;
}

.alert-failed {
  padding: 20px;
  background-color: Green;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>

<?php include('include.doctypehtml.php') ?>
<?php include('include.navbar.php') ?>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <button class="navbar-toggler navbar-toggler-fixed" type="button" data-toggle="collapse" data-target="#collapsingNavbar" aria-controls="collapsingNavbar" aria-expanded="false" aria-label="Toggle navigation">☰</button>
      <div class="collapse navbar-collapse" id="collapsingNavbar">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="marketplace.php?category=All&page=1">All</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="marketplace.php?category=Scrolls&page=1">Scrolls</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="marketplace.php?category=Option&page=1">Option</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="marketplace.php?category=Etc&page=1">Etc</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="marketplace.php?category=Pet&page=1">Pet</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="marketplace.php?category=Forging&page=1">Forging</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="marketplace.php?category=Talismans&page=1">Talismans</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="marketplace.php?category=Crafting&page=1">Crafting</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="marketplace.php?category=Costumes&page=1">Costumes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="marketplace.php?category=Mounts&page=1">Mounts</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- /.navbar -->
  <br>
    <!-- /.content area -->
  </header>
  <!-- /.header -->

  <!-- main content -->
  <main class="main-content">
    <br><br><br>
    <!-- content area -->
    <section class="content-section top_sellers carousel-spotlight ig-carousel pt-0 text-light">
      <div class="container">
        <div class="position-relative">
          <div class="row">
            <div class="col-lg-8">
              <div id="color_sel_Carousel-content_02" class="tab-content position-relative w-100">
                <!-- tab item -->
                <div class="tab-pane fade active show" id="mp-2-01-c" role="tabpanel" aria-labelledby="mp-2-01-tab">
                  <div class="row">
                    <?php 
                      if($found)
                      {
                        echo '<script> alert("Forbidden character, do not use special characters.") </script>';
                        echo '<meta http-equiv="refresh" content="0;url=404.php" />';  
                      }
                      else
                      {
                        if($category == "All")
                        {
                          $qq = sqlsrv_query($db, "SELECT * FROM RohanWeb_Aureus.dbo.TCategoryItems ORDER BY id ASC OFFSET $start_from ROWS FETCH NEXT $limit ROWS ONLY;");
                        }
                        else
                        {
                          $qq = sqlsrv_query($db, "SELECT * FROM RohanWeb_Aureus.dbo.TCategoryItems WHERE category = '$category' ORDER BY id ASC OFFSET $start_from ROWS FETCH NEXT $limit ROWS ONLY;");
                        }
                      }
                      while($row = sqlsrv_fetch_array($qq)){
                    ?>
                    <!-- item -->
                    <div class="col-md-12 mb-4">
                      <div class="row align-items-center no-gutters">
                        <div class="item_img d-none d-sm-block">
                        <img src="img/shop/<?php echo $row['img']?>" width="64px" height="64px"/>
                        </div>
                        <div class="item_content flex-1 flex-grow pl-0 pl-sm-6 pr-6">
                          <p class="item_title ls-1 small-1 fw-600 text-uppercase mb-1"><?php echo $row['name']?></p>
                          <div class="position-relative">
                            <span class="item_genre small fw-600">
                              <small><?php echo $row['description']?></small>
                            </span>
                          </div>
                          <div class="position-relative">
                            <span class="item_genre small fw-600">
                              <?php echo $row['stack']?>pcs.
                            </span>
                          </div>
                        </div>
                        <div class="item_discount d-none d-sm-block">
                          <div class="row align-items-center h-100 no-gutters">
                            <div class="text-right text-secondary px-6">
                              <span class="fw-600 btn bg-warning"><?php echo $row['price'];?> AT</span>
                            </div>
                          </div>
                        </div>
                        <div class="item_price">
                          <div class="row align-items-center h-100 no-gutters">
                            <div class="text-right">

                              <input type="hidden" id="id<?php echo $row['id']; ?>" name="id" value="<?php echo $row['id']; ?>">
                              <button type="submit" id="submit<?php echo $row['id'];?>" class="fw-600 btn bg-light">
                                <span>Purchase</span>
                              </button>

                              <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
                              <script>
                                $(document).ready(function() {
                                
                                $("#submit<?php echo $row['id']; ?>").click(function() {
                                
                                var id = $("#id<?php echo $row['id']; ?>").val();
                                
                                $.ajax({
                                  type: "POST",
                                  url: "zzz/func_buy.php",
                                  data: {
                                  id: id,
                                  },
                                  cache: false,
                                  success: function(data) {
                                  $("#mydiv").load("getpoints.php")
                                  $("#mydiv").load("getpoints.php")
                                  $("#mydiv").load("getpoints.php")
                                  $('#message').fadeIn().html(data);  
                                  setTimeout(function(){  
                                      $('#message').fadeOut("Slow");  
                                  }, 3000); 
                                  },
                                  error: function(xhr, status, error) {
                                  console.error(xhr);
                                  }
                                });
                                
                                });
                                
                                });
                                </script>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php } ?>
                    <!-- /.item -->
                  </div>
                </div>
                <!-- /.tab item -->
                <!-- /.tab item -->
              </div>
              <!-- /.tab panes -->

              <!-- pagination -->
              <?php  
                  if($found)
                  {
                    echo '<script> alert("Forbidden character, do not use special characters.") </script>';
                    echo '<meta http-equiv="refresh" content="0;url=404.php" />';  
                  }
                  else
                  {
                    if($category == "All")
                    {
                      $sql = "SELECT COUNT(id) FROM RohanWeb_Aureus.dbo.TCategoryItems";  
                    }
                    else
                    {
                      $sql = "SELECT COUNT(id) FROM RohanWeb_Aureus.dbo.TCategoryItems WHERE category = '$category'";  
                    }
                  }

                  echo 
                  '
                  <nav class="mt-4 pt-4 border-top border-secondary" aria-label="Page navigation">
                  <ul class="pagination justify-content-end">
                    <li class="page-item">
                  ';

                  $rs_result = sqlsrv_query($db, $sql);  
                  $row = sqlsrv_fetch_array($rs_result);  
                  $total_records = $row[0];  
                  $total_pages = ceil($total_records / $limit);  
                  $pagLink = "<div class='pagination'>";
                  $previous = $page - 1;
                  $next = $page + 1;
                  
                  if($_GET['page'] > 1){
                    if($category == "All")
                    {
                      
                      echo 
                      '
                        <a class="page-link" href="marketplace.php?category=All&page='.$previous.'" aria-label="Previous">
                          <span class="ti-angle-left small-7" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        </li>
                      ';
                    }
                    else
                    {
                      echo 
                      ' 
                        <a class="page-link" href="marketplace.php?category='.$category.'&page='.$previous.'" aria-label="Previous">
                          <span class="ti-angle-left small-7" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        </li>
                      ';
                    }
                    
                  }
                  else{
                  } 
                  $skipped = false;
                  for ($i = 1; $i <= $total_pages; $i++)  {
                    if ($i < 2 || $total_pages- $i < 2 || abs($page - $i) < 2) {
                      if ($skipped)
                        echo "<span> ... </span>";
                      $skipped = false;
                      if($category == "All")
                      {
                        echo '<li class="page-item"><a class="page-link" href="marketplace.php?category=All&page='.$i.'">'.$i.'</a></li>';
                      }
                      else
                      {
                        echo '<li class="page-item"><a class="page-link" href="marketplace.php?category='.$category.'&page='.$i.'">'.$i.'</a></li>';
                      }
                    } else {
                      $skipped = true;
                    }
                  }
                  echo
                  '
                  <li class="page-item">
                  ';
                  if($category == "All")
                    {
                      
                      echo 
                      '
                        <a class="page-link" href="marketplace.php?category=All&page='.$next.'" aria-label="Next">
                          <span class="ti-angle-right small-7" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                        </li>
                      ';
                    }
                    else
                    {
                      echo 
                      ' 
                        <a class="page-link" href="marketplace.php?category='.$category.'&page='.$next.'" aria-label="Next">
                          <span class="ti-angle-right small-7" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                        </li>
                      ';
                    }
                  echo '
                  </ul>
                  </nav>
                  ';
                ?>
              <!-- /.pagination -->
            </div>
            <div class="col-lg-4">
              <div class="filters border border-secondary rounded p-4">
                <ul class="sidebar-nav-light-hover list-unstyled mb-0 text-unset small-3 fw-600">

                  <li class="nav-item text-light transition mb-2 active">
                    <a href="" aria-expanded="false" data-toggle="collapse" class="nav-link py-2 px-3 text-uppercase  collapsed collapser collapser-active nav-link-border">
                        <span class="p-collapsing-title">Account Information</span>
                    </a>
                    <div class="collapse nav-collapse show">
                        <ul class="list-unstyled py-2">
                          <li class="nav-item">
                            <div class="py-1 px-3">
                              <label><i class="fa fa-user" aria-hidden="true"></i> <?php echo $username;?></label>
                            </div>
                          </li>
                          <li class="nav-item">
                            <div class="py-1 px-3" id="mydiv">
                              <?php 
                                include('getpoints.php');
                              ?>
                            </div>
                          </li>
                          <li class="nav-item">
                            <div class="py-1 px-3">
                              <label><i class="fa fa-cog" aria-hidden="true"></i> <small><?php echo $wallet; ?></small></label>
                            </div>
                          </li>
                        </ul>
                    </div>
                  </li>
                  <li class="nav-item text-light transition mt-4">
                    <a  data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-warning d-block">Request Withdraw</a>
                  </li>

                  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content" style="color:black;">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <div class="form-group">
                            <label id="emailHelp" class="form-text text-muted">Amount to Withdraw</label>
                            <input type="number" class="form-control" name="amount" id="amount" value="0" required>
                        </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <input type="hidden" id="check" name="check" value="check">
                            <button type="button" name="withdraw" id="withdraw<?php echo $wallet; ?>" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <script>
                      $(document).ready(function() {
                      
                      $("#withdraw<?php echo $wallet; ?>").click(function() {
                      
                      var check = $("#check").val();
                      var amount = $("#amount").val();
                      
                      $.ajax({
                        type: "POST",
                        url: "zzz/func_withdraw.php",
                        data: {
                          check: check,
                          amount: amount,
                        },
                        cache: false,
                        success: function(data) {
                        $("#mydiv").load("getpoints.php")
                        $("#mydiv").load("getpoints.php")
                        $("#mydiv").load("getpoints.php")
                        $('#message').fadeIn().html(data);  
                        setTimeout(function(){  
                            $('#message').fadeOut("Slow");  
                        }, 10000000); 
                        setTimeout(function(){
                          $('#exampleModalCenter').modal('hide')
                        }, 500);
                        },
                        error: function(xhr, status, error) {
                        console.error(xhr);
                        }
                      });
                      
                      });
                      
                      });
                  </script>
                </ul>
              </div>
              <div class="filters border border-secondary rounded p-4">
                <ul class="sidebar-nav-light-hover list-unstyled mb-0 text-unset small-3 fw-600">

                  <li class="nav-item text-light transition mb-2 active">
                    <a href="" aria-expanded="false" data-toggle="collapse" class="nav-link py-2 px-3 text-uppercase  collapsed collapser collapser-active nav-link-border">
                        <span class="p-collapsing-title">Action Message</span>
                    </a>
                    <div class="collapse nav-collapse show">
                        <ul class="list-unstyled py-2">
                          <li class="nav-item">
                            <div class="py-1 px-3">
                              <label id="message"></label>
                            </div>
                          </li>
                        </ul>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>  
    </section>
    <!-- /.content area -->

  </main>
<!-- footer -->

<!--
  <footer>
    <div class="bg-dark-end py-6 text-center" style="position:fixed;bottom:0;width:100%;">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <span class="ls-1 fw-500">Copyright © 2021 Aureus Token. All Rights Reserved.</span>
            <div class="social-buttons lead-1" section id="contact">
              <a class="social-facebook" href="https://www.facebook.com/aureustoken"><i class="fab fa-facebook-f"></i></a>
              <a class="social-twitter" href="https://www.twitter.com/aureustoken"><i class="fab fa-twitter"></i></a>
              <a class="social-dribbble" href="https://www.t.me/aureustokenofficial"><i class="fab fa-telegram"></i></a>
              <a class="social-instagram" href="#"><i class="fab fa-instagram"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- /.footer -->


  <!-- jQuery -->
  <script src="assets/js/jquery.min.js"></script>

  <!-- Bootstrap -->
  <script src="assets/js/bootstrap.min.js"></script>

  <script src="https://use.fontawesome.com/36c7432c34.js"></script>

  <!-- User JS -->
  <script src="assets/js/scripts.js"></script>

  <!-- Main JS -->
  <script src="assets/js/main.js" id="_mainJS" data-plugins="load"></script>
</body>
</html>