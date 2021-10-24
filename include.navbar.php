    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top border-nav">
      <div class="container">
        <a class="navbar-brand align-items-center logo" href="#">
          <img src="assets/img/logo-gaming.png" alt="Wicodus" class="logo-light mx-auto">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">☰</button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="nav navbar-nav ml-lg-auto">
            <li class="nav-item"><a class="nav-link mr-2" href="Aureus-Token-Whitepaper.pdf" target="_blank">Whitepaper</a></li>
            <li class="nav-item"><a class="nav-link mr-2" href="" data-scroll="#overview">ROI</a></li>
            <!--<li class="nav-item"><a class="nav-link mr-2" href="" data-scroll="#gallery">Whitepaper</a></l0i>-->
            <li class="nav-item"><a class="nav-link mr-2" href="https://drive.google.com/file/d/1k_7cLdXp4R7kTq-5l38GPqj-m6u7VZNq/view" target="_blank">Download (GDrive)</a></li>
			<li class="nav-item"><a class="nav-link mr-2" href="https://aureus-token.com/Aureus_Full.exe" target="_blank">Download (Direct)</a></li>
            <?php if(!$username) {?>
            <li class="nav-item"><a class="nav-link mr-2" href="#" data-toggle="modal" data-target="#Registration">Register</a></li>
            <li class="nav-item"><a class="nav-link mr-2" href="#" data-toggle="modal" data-target="#Login">Login</a></li>
            <?php } else {?>
              <?php if($active == 0) {?>
                <li class="nav-item"><a class="nav-link mr-2" href="#" data-toggle="modal" data-target="#Activate">Activate</a></li>
              <?php } ?>
              <li class="nav-item"><a class="nav-link mr-2" href="marketplace.php?category=All&page=1">Marketplace</a></li>
              <li class="nav-item"><a class="nav-link mr-2" href="logout.php" style="color:red;">Logout</a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </nav>
    <!-- /.navbar -->