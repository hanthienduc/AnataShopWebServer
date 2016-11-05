<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                <div class="title">Quản lý người dùng</div>
                </div>
            </div>
            <div class="card-body">
              <table class="datatable table table-striped" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                        <th>Mã</th>
                        <th>Tên người dùng</th>
                        <th>Email đăng nhập</th>
                        <th>Mật khẩu</th>
                        <th>Tên loại người dùng</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      LayDanhSachNhanVien();
                      ?>
                  </tbody>
              </table>
            </div>
        </div>
    </div>
</div>

<?php


  function LayDanhSachNhanVien(){
    global $conn;
    $truyvan = "SELECT * FROM nhanvien nv, loainhanvien lnv WHERE nv.MALOAINV = 2 AND nv.MALOAINV = lnv.MALOAINV";
    $ketqua = mysqli_query($conn,$truyvan);
    if($ketqua){
      while ($dong = mysqli_fetch_array($ketqua)) {
        echo "<tr>";
        echo "<td>".$dong["MANV"]."</td>";
        echo "<td>".$dong["TENNV"]."</td>";
        echo "<td>".$dong["TENDANGNHAP"]."</td>";
        echo "<td>".$dong["MATKHAU"]."</td>";
        echo "<td>".$dong["TENLOAINV"]."</td>";
        echo "</tr>";
      }
    }
  }
?>
