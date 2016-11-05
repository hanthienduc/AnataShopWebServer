<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">

                <div class="card-title">
                <div class="title">Khuyến mãi</div>
                </div>
            </div>
            <div class="card-body">
              <table class="datatable table table-striped" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                        <th>Mã</th>
                        <th>Tên loại sản phẩm</th>
                        <th>Tên khuyến mãi</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Hình khuyến mãi</th>
                        <th>P/T</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      LayDanhSachKhuyenMai();
                      ?>
                  </tbody>
              </table>
            </div>
        </div>
    </div>
</div>

<?php


  function LayDanhSachKhuyenMai(){
    global $conn;
    $truyvan = "SELECT * FROM khuyenmai km, chitietkhuyenmai ctkm, loaisanpham lsp WHERE km.MALOAISP = lsp.MALOAISP AND km.MAKM = ctkm.MAKM";
    $ketqua = mysqli_query($conn,$truyvan);
    $base_url = "http://".$_SERVER["SERVER_NAME"].":8080"."/webanata";
    if($ketqua){
      while ($dong = mysqli_fetch_array($ketqua)) {
        echo "<tr>";
        echo "<td>".$dong["MAKM"]."</td>";
        echo "<td>".$dong["TENLOAISP"]."</td>";
        echo "<td>".$dong["TENKM"]."</td>";
        echo "<td>".$dong["NGAYBATDAU"]."</td>";
        echo "<td>".$dong["NGAYKETTHUC"]."</td>";
        echo "<td>";
        	echo '<img height="40" width="80" id="image1" src="'.$dong["HINHKHUYENMAI"].'" />';
        echo "</td>";
        echo "<td>".$dong["PHANTRAMKM"]."</td>";
        echo "</tr>";
      }
    }
  }
?>
