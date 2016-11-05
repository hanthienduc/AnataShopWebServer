<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                <div class="title">Thương hiệu</div>
                </div>
            </div>
            <div class="card-body">
              <table class="datatable table table-striped" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                        <th>Mã</th>
                        <th>Tên thương hiệu</th>
                        <th>Hình thương hiệu</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      LayDanhSachThuongHieu();

                      ?>

                  </tbody>
              </table>
            </div>
        </div>
    </div>


</div>
<?php

?>


<?php


  function LayDanhSachThuongHieu(){
    global $conn;
    $truyvan = "SELECT * FROM thuonghieu";
    $ketqua = mysqli_query($conn,$truyvan);
    $base_url = "http://".$_SERVER['SERVER_NAME'].":8080"."/webanata";
    if($ketqua){
      while ($dong = mysqli_fetch_array($ketqua)) {
        echo "<tr>";
        echo "<td>".$dong["MATHUONGHIEU"]."</td>";
        echo "<td>".$dong["TENTHUONGHIEU"]."</td>";
        echo "<td>";
        echo '<img height="40" width="80" id="image1" src="'.$dong["HINHTHUONGHIEU"].'" />';
        echo "</td>";
        echo "</tr>";
      }
    }
  }
?>
