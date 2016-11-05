
<div class="themsanpham">
	<div class="page-title form-style">
	    <span class="title">Sản phẩm</span>
	    <div class="description">Quản lý nội dung liên tới sản phẩm</div>

	   	<table cellspacing="10" cellpadding="10">
	   		<tr>
	   			<th>
	   				<label for="ip_tensanpham">Tên sản phẩm</label>
    				<input type="text" class="form-control" id="ip_tensanpham" placeholder="Nhập tên sản phẩm" />
	   			</th>

	   			<th>
	   				<label for="ip_giasanpham">Giá sản phẩm</label>
    				<input type="number" class="form-control" id="ip_giasanpham" placeholder="Nhập giá sản phẩm" />
	   			</th>
	   		</tr>

	   		<tr>
	   			<th>
	   				<label for="sl_loaisanpham">Loại sản phẩm</label></br>
			    	<select id="sl_loaisanpham">
			            <optgroup label="Tên loại">
			            	<option value="0">Không</option>
			               <?php
			               	HienThiDanhMucLoaiSanPham();
			               ?>
			            </optgroup>

			        </select>

	   			</th>

	   			<th>
	   				<label for="ip_soluong">Số lượng</label>
    				<input type="number" class="form-control" id="ip_soluong" placeholder="Nhập số lượng" />
	   			</th>
	   		</tr>

	   		<tr>
	   			<th>
	   				<label for="sl_thuonghieu">Thương hiệu</label></br>
			    	<select id="sl_thuonghieu">
			            <optgroup label="Tên thương hiệu">
			               <?php
			               	LayDanhSachThuongHieu();
			               ?>
			            </optgroup>

			        </select>

	   			</th>

	   			<th rowspan="2">
	   				<label for="ip_thongtin">Mô tả</label>
    				<textarea rows="10" id="ip_thongtin" class="form-control"></textarea>
	   			</th>
	   		</tr>

	   		<tr>
	   			<th>
	   				<label for="ip_anhlon">Ảnh lớn</label>
    				<div class="form-group">
	                    <input id="ip_anhlon" name="ip_anhlon" class="file" type="file" data-preview-file-type="any" data-upload-url="uploadhinh.php">
	                </div>


	   			</th>
	   		</tr>

	   		<tr>
	   			<th>
	   				<label for="ip_anhnho">Ảnh nhỏ</label>
    				<div class="form-group">
	                    <input id="ip_anhlon" name="ip_anhlon" class="file" type="file" multiple data-preview-file-type="any" data-upload-url="uploadhinh.php">
	                </div>
	   			</th>
	   		</tr>

	   		<tr>
	   			<th>
	   				Chi tiết sản phẩm
	   				<div id="khungchitietsanpham">
	   					<table>
	   						<tr>
	   							<th>
	   								Tên chi tiết : <input style="margin:5px; padding:5px; width:60%" name="mangtenchitietsanpham[]" type="text"  />
	   							</th>

	   							<th>
	   								Giá trị : <input style="margin:5px; padding:5px; width:60%" name="manggiatrichitietsanpham[]" type="text"  />
	   								<a class="btn btn-primary btnthemchitietsanpham">Thêm</a> <a class="btn btn-danger anbutton btnxoachitietsanpham">Xóa</a>
	   							</th>
	   						</tr>
	   					</table>
	   				</div>
	   			</th>
	   		</tr>
	   	</table>
        <input type="button" class="btn btn-success" id="btn-themsanpham" value="Thêm sản phẩm">
        <div class="thongbaoloi"></div>
        <div class="anchitietsanpham">
        	<table>
				<tr>
					<td>
						Tên chi tiết : <input style="margin:5px; padding:5px; width:60%" name="mangtenchitietsanpham[]" type="text"  />
					</td>

					<td>
						Giá trị : <input style="margin:5px; padding:5px; width:60%" name="manggiatrichitietsanpham[]" type="text"  />
					</td>

				</tr>
			</table>
        </div>

    </div>
</div>

<div>

  <div class="row">
  <div class="col-xs-12">
      <div class="card">
          <div class="card-header">
              <div class="card-title">
              <div class="title">Table</div>
              </div>
          </div>
          <div class="card-body">
              <table class="datatable table table-striped" cellspacing="0" width="100%">
                  <thead>
                      <tr>
													<th>Tất cả </th>
                          <th>Tên sản phẩm</th>
                          <th>Loại sản phẩm</th>
                          <th>Thương hiệu</th>
                          <th>Giá</th>
                          <th>Số lượng</th>
                          <th>Hình </th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                          LayDanhSachSanPhamLimit();
                       ?>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>

<?php
  function LayDanhSachSanPhamLimit(){
    global $conn;
    $truyvan = "SELECT * FROM sanpham ";
    $ketqua = mysqli_query($conn,$truyvan);
		$base_url = "http://".$_SERVER['SERVER_NAME'].":8080"."/webanata";
    if($ketqua){
      while ($dong = mysqli_fetch_array($ketqua)) {

        echo "<tr>";
        echo '<td>';
				echo '<div class="checkbox3 checkbox-round checkbox-check checkbox-light">';
        echo '<input name="cb-mang[]" data-id="'.$dong["MASP"].'" type="checkbox" id="cb-'.$dong["MASP"].'"/>';
        echo '<label for="cb-'.$dong["MASP"].'" >'.$dong["MASP"].'</label>';
        echo '</div></td>';
        echo '<td>'.$dong["TENSP"].'</td>';
        LayLoaiSanPhamTheoMa($dong["MALOAISP"]);
        LayDanhSachThuongHieuTheoMa($dong["MATHUONGHIEU"]);
        echo '<td>'.$dong["GIA"].'</td>';
        echo '<td>'.$dong["SOLUONG"].'</td>';
				echo "<td>";
				echo '<img height="40" width="80" id="image1" src="'.$dong["ANHLON"].'" />';
				echo "</td>";
        echo "</tr>";

      }
    }
  }

	function LayDanhSachThuongHieu(){
		global $conn;
		$truyvan = "SELECT * FROM thuonghieu";
		$ketqua = mysqli_query($conn,$truyvan);
		if($ketqua){
			while ($dong = mysqli_fetch_array($ketqua)) {
				echo "<option value='".$dong["MATHUONGHIEU"]."'>".$dong["TENTHUONGHIEU"]."</option>";
			}
		}
	}


  function LayDanhSachThuongHieuTheoMa($math){
    global $conn;
    $truyvan = "SELECT * FROM thuonghieu WHERE MATHUONGHIEU=".$math;
    $ketqua = mysqli_query($conn,$truyvan);
    if($ketqua){
      while ($dong = mysqli_fetch_array($ketqua)) {
        echo "<td>".$dong["TENTHUONGHIEU"]."</td>";
      }
    }
  }

  function LayLoaiSanPhamTheoMa($maloaisp){
    global $conn;
    $truyvan = "SELECT * FROM loaisanpham WHERE MALOAISP=".$maloaisp;
    $ketqua = mysqli_query($conn,$truyvan);
    if($ketqua){
      while ($dong = mysqli_fetch_array($ketqua)) {
        echo "<td>".$dong["TENLOAISP"]."</td>";
      }
    }
  }

	function HienThiDanhMucLoaiSanPham(){
		global $conn;
		$truyvan = "SELECT * FROM loaisanpham";
		$ketqua = mysqli_query($conn,$truyvan);
		if($ketqua){
			while ($dong = mysqli_fetch_array($ketqua)) {
				echo "<option value='".$dong["MALOAISP"]."'>".$dong["TENLOAISP"]."</option>";
			}
		}
	}
?>
