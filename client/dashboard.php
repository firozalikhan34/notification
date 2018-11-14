
<?php include_once 'includes/header.php'; ?>
        <!-- /top navigation -->
      
        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Earing</span>
              <div class="count"> <i class="fa fa-inr" aria-hidden="true"></i> <?php 
                $query = mysqli_query($con, "SELECT sum(payment) as total FROM `service` WHERE `payment_status` = '1'");
                while($row = mysqli_fetch_assoc($query)){
                echo $row['total'];
                        }
              ?></div>
              <span class="count_bottom"><i class="green">4% </i> From last Week</span>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Today Earing</span>
              <div class="count"> <i class="fa fa-inr" aria-hidden="true"></i> 123.50</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Clients </span>
              <div class="count green"><?php 
                  $query = mysqli_query($con, "SELECT * FROM `user_profile`");
                  $rows = mysqli_num_rows($query);
                  echo $rows;
              ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Services</span>
              <div class="count"> 4,567</div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
            </div>
          <!--   <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Cycle</span>
              <div class="count">5</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Direct</span>
              <div class="count"> <i class="fa fa-inr" aria-hidden="true"></i>7,325</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div> -->
          </div>
          <!-- /top tiles -->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row x_title client_table_dashboard text-center">
                  <h3>Latest Service Request</h3>
                  <?php

                   $query = mysqli_query($con, "SELECT * FROM `service` WHERE `service_activation` = '0' ORDER BY `service_id` DESC LIMIT 6");
                         
                     while ( $row = mysqli_fetch_array($query)) {
                        ?>
                  <div class="col-sm-2 panel panel_box text-center">
                    <label><i class="fa fa-inr"></i> <?php echo $row['payment']?>/-</label>
                      <p class="panel_border"><?php echo $row['child_service']?></p>
                  <p><span style="font-size: 15px;">Payment Status :-</span> <br> <?php if($row['payment_status']='1'){ echo "<span style='color:green; font-size:15px;'>".'Done'."</span>";} else {echo "<span style='color:red; font-size:15px;'>".'Pending'."</span>";}?>
                  <input type="hidden" name="" value="<?php echo $row['service_id']?>" id="service_id"></p>
                      <div class="row">
                      <div class="col-md-6">
                      <button class="btn_panel btn btn-success" id="activate">Activate</button>
                    </div>

                    <div class="col-md-6">
                      <button class="btn_panel btn btn-primary" id="view">View</button>
                    </div>
                  </div>
                   <br>
                  
                </div>
                  <?php } ?>


                    <div id="myModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

    <!-- Modal content-->
                

              </div>
            </div>
         </div>
         
          </div>
              <script type="text/javascript">
                          $(document).ready(function(){

                            $("#activate").click(function(){
                              
                              var service_id = $("#service_id").val();

                          $.ajax({
                            type: "POST",
                            url: "service_activation.php",
                            data: { service_id:service_id},
                            dataType: "json",
                            success:function(data){
                            if(data.status == 'success' ){
                              alert("Service Activated");
                              window.open('service_request.php', '_SELF');
                           
                             }
                                else if(data.status == 'error'){
                            alert("Something error");
                                
                                 }
                                  },
                                  error:function (){
                                     console.log();
                                      },
                                         }); 
                                        });
                            $("#Deactivate").click(function(){

                              
                              var service_id = $("#service_id").val();

                          $.ajax({
                            type: "POST",
                            url: "service_activation.php",
                            data: { dservice_id:service_id},
                            dataType: "json",
                            success:function(data){
                            if(data.dstatus == 'dsuccess' ){
                              alert("Service Deactivated");
                              window.open('service_request.php', '_SELF');
                           
                             }
                                else if(data.dstatus == 'derror'){
                            alert("Something error");
                                
                                 }
                                  },
                                  error:function (){
                                     console.log();
                                      },
                                         }); 
                                        });
                               $("#view").click(function(){

                              
                              var service_id = $("#service_id").val();

                          $.ajax({
                            type: "POST",
                            url: "service_view.php",
                            data: {service_id:service_id},
                            dataType: "json",
                            success:function(data){
                            if(data.status == 'success' ){
                              
                              $("#myModal").modal('show');
                              $(".modal-dialog").empty();
                              $(".modal-dialog").append('<div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Service Details</h4></div><div class="modal-body"><div class="row"><div class="col-sm-12"> <div class="heading"><div class="tab-content" id="nav-tabContent"><div class=""><table class="table table_main" spacing="0"><thead class="table_head"><tr><th>Labels</th><th>Value</th></tr></thead><tbody><tr><td><a href="#">Service Name</a></td><td>'+data.service_name+'</td></tr><tr><td><a href="#">Payment</a></td><td>'+data.payment+'</td></tr><tr><td><a href="#">Payment Status</a></td><td>'+data.payment_status+'</td></tr><tr><td><a href="#">Service Status</a></td><td>'+data.service_activation+'</td></tr><tr><td><a href="#">Service Request Date</a></td><td>'+data.service_request_date+'</td></tr><tr><td><a href="#">Service Activation Date</a></td><td>'+data.service_activation_date+'</td></tr><tr><td><a href="#">Service Time Period</a></td><td>'+data.service_time+'</td></tr></tbody></table></div</div></div></div></div> </div></div>');                           
                             }
                                else if(sata.status == 'failed'){
                            alert("Something error");
                                
                                 }
                                  },
                                  error:function (){
                                     console.log();
                                      },
                                         }); 
                                        });

                            });

                                     
                      </script>
                      
                      <div class="row client_table_dashboard text-center">
                        <h3>Latest Clients Register</h3>
                        <div class="col-md-12 col-sm-12">
                          
                            <table id="" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Client Name</th>
                          <th>Mobile No</th>
                          <th>Join Date</th>
                          <th>Kyc Status</th>
                          <th>Service Status</th>
                          <th>RPM Status</th>
                          <th>View Details</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                        $n = 1;
                        $query = mysqli_query($con, "SELECT * FROM `user_profile` ORDER BY `user_id` DESC LIMIT 10");
                        while($rows = mysqli_fetch_array($query)){

                        
                        ?>
                        <tr>
                          <td><?php echo $n++;?></td>
                          <td><?php echo $rows['user_name'];?></td>
                          <td><?php echo $rows['mobile_no']?></td>
                          <td><?php echo $rows['user_date']?></td>
                          <td><?php if ($rows['kyc_status'] == 0) { echo "<span style='color:red;'>".'Pending'."</span>"; }else { echo "<span style='color:green;'>".'Success'."</span>";} ?></td>
                          <td><?php if ($rows['service_status'] == 0) { echo "<span style='color:red;'>".'Pending'."</span>"; }else { echo "<span style='color:green;'>".'Success'."</span>";} ?></td>
                          <td><?php if ($rows['rpm_status'] == 0) { echo "<span style='color:red;'>".'Pending'."</span>"; }else { echo "<span style='color:green;'>".'Success'."</span>";} ?></td>
                          <td><div class="btn btn-success">View</div></td>
                        </tr>
                      <?php }?>
                      </tbody>
                    </table>
                        </div>
                      </div>
          <br />
          

        </div>
        <!-- /page content -->

        <!-- footer content -->
        <?php include_once'includes/footer.php'; ?>