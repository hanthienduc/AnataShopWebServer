<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                <div class="title">Hóa đơn</div>
                </div>
            </div>
            <div class="card-body">
              <table class="datatable table table-striped" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                        <th>Mã</th>
                        <th>Ngày mua</th>
                        <th>Ngày giao</th>
                        <th>Trạng thái</th>
                        <th>Tên người nhận</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      LayDanhSachHoaDon();
                      ?>
                  </tbody>
              </table>
            </div>
        </div>
    </div>
</div>

<?php


  function LayDanhSachHoaDon(){
    global $conn;
    $truyvan = "SELECT * FROM hoadon";
    $ketqua = mysqli_query($conn,$truyvan);
    if($ketqua){
      while ($dong = mysqli_fetch_array($ketqua)) {
        echo "<tr>";
        echo "<td>".$dong["MAHD"]."</td>";
        echo "<td>".$dong["NGAYMUA"]."</td>";
        echo "<td>".$dong["NGAYGIAO"]."</td>";
        echo "<td>".$dong["TRANGTHAI"]."</td>";
        echo "<td>".$dong["TENNGUOINHAN"]."</td>";
        echo "<td>".$dong["SODT"]."</td>";
        echo "<td>".$dong["DIACHI"]."</td>";
        echo "</tr>";
      }
    }
  }
?>
