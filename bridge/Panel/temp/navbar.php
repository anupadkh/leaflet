            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                
            </div>
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="logout.php">Logout</a></li>
                    <?php if (isset($header)) {
                        
                    ?> 
                    <li><a class="logout" href="<?php echo $header."&position={$_GET['position']}";?>">नयाँ थप्नुहोस्</a></li>
                    <?php 

                    }  // end if 
                    ?>
            	</ul>
            </div>
        </header>
      <!--header end-->
