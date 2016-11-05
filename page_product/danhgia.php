<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                <div class="title">Đánh giá</div>
                </div>
            </div>
            <div class="card-body">
              <table class="datatable table table-striped" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                        <th>Mã</th>
                        <th>Tên sản phẩm</th>
                        <th>Người đánh giá</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Số sao</th>
                        <th>Ngày đánh giá</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      LayDanhSachDanhGia();
                      ?>
                  </tbody>
              </table>
            </div>
        </div>
    </div>
</div>

<?php


  function LayDanhSachDanhGia(){
    global $conn;
    $truyvan = "SELECT * FROM danhgia dg, sanpham sp WHERE dg.MASP = sp.MASP";
    $ketqua = mysqli_query($conn,$truyvan);
    if($ketqua){
      while ($dong = mysqli_fetch_array($ketqua)) {
        echo "<tr>";
        echo "<td>".$dong["MADG"]."</td>";
        echo "<td>".$dong["TENSP"]."</td>";
        echo "<td>".$dong["TENNGUOIDANHGIA"]."</td>";
        echo "<td>".$dong["TIEUDE"]."</td>";
        echo "<td>".$dong["NOIDUNG"]."</td>";
        echo "<td>".$dong["SOSAO"]."</td>";
        echo "<td>".$dong["NGAYDANHGIA"]."</td>";
        echo "</tr>";
      }
    }
  }
?>
