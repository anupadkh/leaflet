      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
                  <p class="centered"><a href="profile.html"><img src="assets/img/logo.png" class="img-circle" width="60"></a></p>
                  <h5 class="centered"><?php echo organization::find_by_id(1)->nepl_name; ?></h5>
                  <?php 
if ($hide_menu != true) {
  

                  // mymenu::hello("world");
                  
                  $menu = mymenu::find_all_parent();

                  // print_r($menu);
                  $op = "";
                  $main_active = "";
                  $sidebar_active_id = $_GET['position'];
                  $sidebar_active= mymenu::find_by_id($sidebar_active_id);
                  if(!is_null($sidebar_active->parent_id)){
                    $main_active = mymenu::find_by_id($sidebar_active->parent_id);
                  }
                  
                  foreach ($menu as $item) {
                    if ($item->id == 0) {
                      continue;
                    }
                    $aditem = "";
                    $subs = mymenu::find_children($item->id);

                    if (count($subs) !=0){
                      if($main_active->id == $item->id){
                        $aditem = "class = \"active\" ";
                      }

                      $op .= "<li class =\"sub-menu\"> 
                        <a {$aditem} href=\"javascript:;\">
                          <i class=\"fa ". $item->icon." \"></i><span>".
                          $item->nepl_name .
                          "</span>
                        </a>";
                      

                      $op .= "<ul class=\"sub\">";
                      $aditem = "";
                      $adsub = "";
                      foreach ($subs as $sub_item) {
                        if ($sub_item->id == $sidebar_active->id){
                          $adsub = "class =\"active\"";
                        }

                        $op .= "<li {$adsub}><a href=\"". $sub_item->href ;
                        if(strpos($sub_item->href, "?") == NULL){
                          $op .= "?position=". $sub_item->id;
                        }else{
                          $op .= "&position=". $sub_item->id;
                        }
                        $op .= "\">".$sub_item->nepl_name." </a></li>";
                        $adsub = "";
                      }
                        
                      $op .= "</ul>";
                      $op .= "</li>";

                      
                      
                    } else{
//Checking the Active Menu
                      if ($sidebar_active_id==$item->id) { 
                        $aditem = "class = \"active\""; 
                      }
                      $op .= "<li class=\"mt\">
                      <a {$aditem} href=\"".$item->href."\">
                          <i class=\"fa ".$item->icon. "\"></i>
                          <span>".$item->nepl_name."</span>
                      </a>
                  </li>";
                    }                  

                  }

                  echo $op;

                   ?>

              </ul>
              <?php
} //print_r($sub_item); ?>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
