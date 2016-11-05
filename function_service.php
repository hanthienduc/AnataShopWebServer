
<?php
  include_once("config.php");

  //$ham = $_GET["ham"];
  $ham = $_POST["ham"];

  switch($ham){

      case 'LayDanhSachMenu':
        $ham();
        break;

      case 'DangKyThanhVien':
        $ham();
        break;

      case 'KiemTraDangNhap':
        $ham();
        break;

      case 'LayDanhSachCacThuongHieuLon':
        $ham();
        break;

      case 'LayDanhSachTopDienThoaiVaMayTinhBang':
        $ham();
        break;

      case 'LayDanhSachTopPhuKien':
        $ham();
        break;

      case 'LayDanhSachPhuKien':
        $ham();
        break;

      case 'LayDanhSachTienIch':
        $ham();

      case 'LayTopTienIch':
        $ham();
      break;

      case 'LayLogoThuongHieuLon':
        $ham();
      break;

      case 'LayDanhSachSanPhamMoi':
        $ham();
      break;

      case 'LayDanhSachSanPhamTheoMaloaiDanhMuc':
        $ham();
      break;

      case 'LayDanhSachSanPhamTheoMaThuongHieu':
        $ham();
      break;

      case 'LaySanPhamVaChiTietTheoMASP':
        $ham();
      break;

      case 'ThemDanhGia':
        $ham();
      break;

      case 'LayDanhSachDanhGiaTheoMASP':
        $ham();
      break;

      case 'ThemHoaDon':
        $ham();
      break;
      case 'LayDanhSachKhuyenMai':
        $ham();
      break;
      case 'LayDanhSachSanPhamNoiBat':
        $ham();
      break;
      case 'TimKiemSanPhamTheoTenSP':
        $ham();
      break;
    }




    function TimKiemSanPhamTheoTenSP(){
  			global $conn;
  			$chuoijson = array();

  			if(isset($_POST["tensp"]) || isset($_POST["limit"])){
  				$tensp = $_POST["tensp"];
  				$limit = $_POST["limit"];
  			}

  			$ngayhientai = date("Y/m/d");
  			$truyvan = " SELECT *, DATEDIFF(km.NGAYKETTHUC,'".$ngayhientai."') AS THOIGIANKM  FROM sanpham sp, khuyenmai km, chitietkhuyenmai ctkm WHERE sp.TENSP like '%".$tensp."%' AND sp.MASP = ctkm.MASP AND ctkm.MAKM = km.MAKM ORDER BY sp.MASP LIMIT ".$limit.",10";
  			$ketqua = mysqli_query($conn,$truyvan);

  			echo "{";
  			echo "\"DANHSACHSANPHAM\":";

  			if($ketqua){
          	$phantramkm = 0;
  				while ($dong = mysqli_fetch_array($ketqua)) {
  						$thoigiankm = $dong["THOIGIANKM"];

  						if($thoigiankm > 0){
  							$phantramkm = $dong["PHANTRAMKM"];

  						}

  						array_push($chuoijson, array("MASP"=>$dong["MASP"], "TENSP"=>$dong["TENSP"], "GIATIEN"=>$dong["GIA"]
  							,"HINHSANPHAM"=>$dong["ANHLON"],"HINHSANPHAMNHO"=>$dong["ANHNHO"], "PHANTRAMKM"=>$phantramkm,"MANV"=>$dong["MANV"]));

  					}
  			}

  			echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
  			echo "}";
  		}
    function LayDanhSachSanPhamNoiBat(){
      global $conn;
      $chuoijson = array();
      $truyvan = "SELECT * FROM loaisanpham lsp, sanpham sp WHERE lsp.MALOAISP = sp.MALOAISP ORDER BY sp.LUOTMUA DESC LIMIT 10";
      $ketqua = mysqli_query($conn,$truyvan);
      echo "{";
      echo "\"DANHSACHNOIBAT\":";
      if($ketqua){
          while($dong = mysqli_fetch_array($ketqua)){
                $truyvansanpham = "SELECT * FROM sanpham WHERE MALOAISP = ".$dong["MALOAISP"]." ORDER BY LUOTMUA DESC LIMIT 10";
                $ketquasanpham = mysqli_query($conn,$truyvansanpham);
                $chuoijsonsanpham = array();
                if($ketquasanpham){
                  while ($dongsanpham = mysqli_fetch_array($ketquasanpham)) {
                      $chuoijsonsanpham[] = $dongsanpham;
                  }
                }
                array_push($chuoijson,array("TENLOAISP" =>$dong["TENLOAISP"],"DANHSACHSANPHAMNOIBAT"=>$chuoijsonsanpham));
          }
      }
      echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
      echo "}";
      mysqli_close($conn);

    }

    function LayDanhSachKhuyenMai(){
      global $conn;
      $chuoijson = array();

      $ngayhientai = date("Y/m/d");
      $truyvan = "SELECT * FROM khuyenmai km, loaisanpham lsp WHERE DATEDIFF(km.NGAYKETTHUC,'".$ngayhientai."') >= 0 AND km.MALOAISP = lsp.MALOAISP";
      $ketqua = mysqli_query($conn,$truyvan);

      echo "{";
      echo "\"DANHSACHKHUYENMAI\":";
      if($ketqua){
          while($dong = mysqli_fetch_array($ketqua)){
            $truyvanchitietkhuyenmai = "SELECT * FROM chitietkhuyenmai ctkm, sanpham sp WHERE ctkm.MAKM = '".$dong["MAKM"]."' AND ctkm.MASP = sp.MASP";
            $ketquakhuyenmai = mysqli_query($conn,$truyvanchitietkhuyenmai);
            $chuoijsondanhsachsanpham = array();
            if($ketquakhuyenmai){
                while($dongkhuyenmai = mysqli_fetch_array($ketquakhuyenmai)){
                    $chuoijsondanhsachsanpham[] = $dongkhuyenmai;
                }
            }
            array_push($chuoijson, array("MAKM"=>$dong["MAKM"],"TENKM"=>$dong["TENKM"],"TENLOAISP"=>$dong["TENLOAISP"],"HINHKHUYENMAI"=>$dong["HINHKHUYENMAI"],"DANHSACHSANPHAMKHUYENMAI"=>$chuoijsondanhsachsanpham));
          }
      }

      echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
      echo "}";
      mysqli_close($conn);
    }

    function ThemHoaDon(){
			global $conn;

			if(isset($_POST["danhsachsanpham"]) || isset($_POST["tennguoinhan"]) || isset($_POST["sodt"]) || isset($_POST["diachi"]) || isset($_POST["hinhthucthanhtoan"]) ){
				$danhsachsanpham = $_POST["danhsachsanpham"];
				$tennguoinhan = $_POST["tennguoinhan"];
				$sodt = $_POST["sodt"];
				$diachi = $_POST["diachi"];
				$hinhthucthanhtoan = $_POST["hinhthucthanhtoan"];

			}

			$ngaymua = date("Y-m-d");
			$ngaygiao = date_create($ngaymua);
			$ngaygiao = date_modify($ngaygiao,"+3 days");
			$ngaygiao = date_format($ngaygiao,"Y-m-d");

			$trangthai = "chờ kiểm duyệt";

			$truyvan = " INSERT INTO hoadon (NGAYMUA,NGAYGIAO,TRANGTHAI,TENNGUOINHAN,SODT,DIACHI,HINHTHUCTHANHTOAN) VALUES ('".$ngaymua."','".$ngaygiao."','".$trangthai."','".$tennguoinhan."','".$sodt."','".$diachi."','".$hinhthucthanhtoan."' );";
			$ketqua = mysqli_query($conn,$truyvan);
			if($ketqua){

				$mahd = mysqli_insert_id($conn);
				$chuoijsonandroid = json_decode($danhsachsanpham);
				$arrayDanhSachSanPham = $chuoijsonandroid->DANHSACHSANPHAM;
				$dem = count($arrayDanhSachSanPham);

				for($i=0; $i<$dem; $i++){
					$jsonObject = $arrayDanhSachSanPham[$i];

					$masp = $jsonObject->masp;
					$soluong = $jsonObject->soluong;

					$truyvan = " INSERT INTO chitiethoadon (MAHD,MASP,SOLUONG) VALUES ('".$mahd."', '".$masp."', '".$soluong."')";
					$ketqua1 = mysqli_query($conn,$truyvan);


				}

				echo "{ketqua:true}" ;

			}else{
				echo "{ketqua:false}";
			}
    //  mysqli_close($conn);

		}

    function LayDanhSachDanhGiaTheoMASP(){
      global $conn;
      $chuoijson = array();

      if(isset($_POST["masp"]) || isset($_POST["limit"])){
        $masp = $_POST["masp"];
        $limit = $_POST["limit"];

      }

      $truyvan = "SELECT * FROM danhgia WHERE MASP = ".$masp." ORDER BY NGAYDANHGIA LIMIT ".$limit." ,10";
      $ketqua = mysqli_query($conn,$truyvan);
      echo "{";
      echo "\"DANHSACHDANHGIA\":";
      if($ketqua){
          while($dong = mysqli_fetch_array($ketqua)){
              $chuoijson[] = $dong;
          }
      }

      echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
      echo "}";
      mysqli_close($conn);
    }

    function ThemDanhGia(){
      global $conn;


      if(isset($_POST["masp"]) || isset($_POST["tennguoidanhgia"]) || isset($_POST["tieude"]) || isset($_POST["noidung"]) || isset($_POST["sosao"])){
          $masp = $_POST["masp"];
          $tennguoidanhgia = $_POST["tennguoidanhgia"];
          $tieude = $_POST["tieude"];
          $noidung = $_POST["noidung"];
          $sosao = $_POST["sosao"];
      }

      $ngaydang = date("d/m/y");

      $truyvan = "INSERT INTO danhgia (MASP,TENNGUOIDANHGIA,TIEUDE,NOIDUNG,SOSAO,NGAYDANHGIA) VALUES ('".$masp."','".$tennguoidanhgia."'
      ,'".$tieude."','".$noidung."','".$sosao."','".$ngaydang."')";

      $ketqua = mysqli_query($conn,$truyvan);

      if($ketqua){
          	echo "{ ketqua : true }";
      }else{
          	echo "{ ketqua : false }".mysqli_error($conn);
      }
      mysqli_close($conn);
    }

    function LaySanPhamVaChiTietTheoMASP(){
        global $conn;
        $chuoijson = array();
        $chuoijsonchitiet = array();
        if(isset($_POST["masp"])){
              $masp = $_POST["masp"];

        }
        $ngayhientai = date("Y/m/d");
        $truyvan = "SELECT * , DATEDIFF(km.NGAYKETTHUC,'".$ngayhientai."') as THOIGIANKM FROM sanpham sp , nhanvien nv , khuyenmai km, chitietkhuyenmai ctkm WHERE sp.MASP=".$masp." AND sp.MANV = nv.MANV AND sp.MASP = ctkm.MASP AND km.MAKM = ctkm.MAKM";
        $ketqua = mysqli_query($conn,$truyvan);
        echo "{";
        echo "\"CHITIETSANPHAM\":";

        $truyvanchitiet = "SELECT * FROM chitietsanpham WHERE MASP=".$masp;
        $ketquachitiet = mysqli_query($conn,$truyvanchitiet);

        if($ketquachitiet){
          while($dongchitiet = mysqli_fetch_array($ketquachitiet)){

              array_push($chuoijsonchitiet,  array($dongchitiet["TENCHITIET"]=>$dongchitiet["GIATRI"]));

          }
        }

        if($ketqua){
          $phantramkm = 0;
            while($dong = mysqli_fetch_array($ketqua)){
              $thoigiankm = $dong["THOIGIANKM"];
              if($thoigiankm > 0){
                $phantramkm = $dong["PHANTRAMKM"];

              }
              array_push($chuoijson,array("MASP"=>$dong["MASP"],'TENSP' => $dong["TENSP"],'GIATIEN' => $dong["GIA"],'SOLUONG' => $dong["SOLUONG"],
              'ANHNHO' => $dong["ANHNHO"],'THONGTIN' => $dong["THONGTIN"],'MALOAISP' => $dong["MALOAISP"],'MATHUONGHIEU' => $dong["MATHUONGHIEU"],
              'MANV' => $dong["MANV"],'TENNV' => $dong["TENNV"],'PHANTRAMKM' => $phantramkm,'LUOTMUA' => $dong["LUOTMUA"],'THONGSOKYTHUAT' =>$chuoijsonchitiet));
            }
        }



        echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
        echo "}";
    }


    function LayDanhSachSanPhamTheoMaThuongHieu(){
      global $conn;
      $chuoijson = array();

      if(isset($_POST["maloaisp"]) || isset($_POST["limit"])){
            $maloai = $_POST["maloaisp"];
            $limit = $_POST["limit"];

      }
      echo "{";
      echo "\"DANHSACHSANPHAM\":";

      $chuoijson = LayDanhSachSanPhamTheoMaLoaiThuongHieu($conn,$maloai,$chuoijson,$limit);

      echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
      echo "}";
    }

    function LayDanhSachSanPhamTheoMaloaiDanhMuc(){
        global $conn;
        $chuoijson = array();

        if(isset($_POST["maloaisp"]) || isset($_POST["limit"])){
              $maloai = $_POST["maloaisp"];
              $limit = $_POST["limit"];

        }
        $chuoijson = LayDanhSachDanhMucSanPhamTheoMaLoai($conn,$maloai,$chuoijson,$limit);
        echo "{";
        echo "\"DANHSACHSANPHAM\":";

        echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
        echo "}";


    }

    function LayDanhSachSanPhamMoi(){
      global $conn;
      // Truy vấn điện thoại
      $truyvan = "SELECT * FROM sanpham ORDER BY MASP DESC LIMIT 20 ";
      $ketqua = mysqli_query($conn, $truyvan);
      $chuoijson = array();
      echo "{";
      echo "\"DANHSACHSANPHAMMOIVE\":";
      if($ketqua){
          while($dong = mysqli_fetch_array($ketqua)){

              array_push($chuoijson, array("MASP"=>$dong["MASP"],'TENSP' => $dong["TENSP"],'GIATIEN' => $dong["GIA"],'HINHSANPHAM' =>$dong["ANHLON"]));

          }

      }

      echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
      echo "}";

    }


    function LayLogoThuongHieuLon(){
      global $conn;
      // Truy vấn điện thoại
      $truyvan = "SELECT * FROM thuonghieu ";
      $ketqua = mysqli_query($conn, $truyvan);
      $chuoijson = array();
      echo "{";
      echo "\"DANHSACHTHUONGHIEU\":";
      if($ketqua){
          while($dong = mysqli_fetch_array($ketqua)){

              array_push($chuoijson, array("MASP"=>$dong["MATHUONGHIEU"],'TENSP' => $dong["TENTHUONGHIEU"],'HINHSANPHAM' =>$dong["HINHTHUONGHIEU"]));

          }

      }

      echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
      echo "}";
    }

    function LayTopTienIch(){
      global $conn;
      // Truy vấn điện thoại
      $ketqua = LayDanhSachLoaiSanPhamTheoMaLoai($conn,82);
      $chuoijson = array();

      echo "{";
      echo "\"TOPTIENICH\":";
      if($ketqua){
            while ($dong = mysqli_fetch_array($ketqua)) {
                $ketquacon = LayDanhSachLoaiSanPhamTheoMaLoai($conn,$dong["MALOAISP"]);
                if($ketquacon){
                    while($dongcon = mysqli_fetch_array($ketquacon)){
                        $chuoijson = LayDanhSachSanPhamTheoMaLoai($conn, $dongcon["MALOAISP"],$chuoijson,10);
                    }
                }
          }
        }
        echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
        echo "}";
    }

    function LayDanhSachTienIch(){
      global $conn;
      // Truy vấn điện thoại
      $ketqua = LayDanhSachLoaiSanPhamTheoMaLoai($conn,82);
      $chuoijson = array();

      echo "{";
      echo "\"DANHSACHTIENICH\":";
      if($ketqua){
            while ($dong = mysqli_fetch_array($ketqua)) {
                $ketquacon = LayDanhSachLoaiSanPhamTheoMaLoai($conn,$dong["MALOAISP"]);
                if($ketquacon){
                    while($dongcon = mysqli_fetch_array($ketquacon)){
                        $chuoijson = LayDanhSachSanPhamTheoMaLoai($conn, $dongcon["MALOAISP"],$chuoijson,1);
                    }
                }
          }

      }

      echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
      echo "}";
    }

    function LayDanhSachLoaiSanPhamTheoMaLoai($conn,$maloaisp){
      $truyvancha = "SELECT * FROM loaisanpham lsp WHERE lsp.MALOAI_CHA = ".$maloaisp;
      $ketqua = mysqli_query($conn, $truyvancha);

      return $ketqua;
    }

    // Lay danh sach san pham theo danh muc
    function LayDanhSachDanhMucSanPhamTheoMaLoai($conn, $maloaisp, $chuoijson, $limit){

        $truyvantienich = "SELECT * FROM loaisanpham lsp, sanpham sp  WHERE lsp.MALOAISP =".$maloaisp."  AND lsp.MALOAISP = sp.MALOAISP ORDER BY sp.LUOTMUA DESC LIMIT ".$limit.",20";

        $ketquacon = mysqli_query($conn, $truyvantienich);

        if($ketquacon){
            while($dongtienich = mysqli_fetch_array($ketquacon)){

              array_push($chuoijson, array("MASP"=>$dongtienich["MASP"],'TENSP' => $dongtienich["TENSP"],'GIATIEN' => $dongtienich['GIA'] ,'HINHSANPHAM' =>$dongtienich["ANHLON"],'HINHSANPHAMNHO' =>$dongtienich["ANHNHO"]));

            }

        }
        return $chuoijson;

    }


    // Lay danh sach san pham theo thuong hieu
    function LayDanhSachSanPhamTheoMaLoaiThuongHieu($conn, $mathuonghieu, $chuoijson, $limit){

        $truyvantienich = "SELECT * FROM thuonghieu th, sanpham sp  WHERE th.MATHUONGHIEU =".$mathuonghieu."  AND th.MATHUONGHIEU = sp.MATHUONGHIEU ORDER BY sp.LUOTMUA DESC LIMIT ".$limit.",20";

        $ketquacon = mysqli_query($conn, $truyvantienich);

        if($ketquacon){
            while($dongtienich = mysqli_fetch_array($ketquacon)){

                    array_push($chuoijson, array("MASP"=>$dongtienich["MASP"],'TENSP' => $dongtienich["TENSP"],'GIATIEN' => $dongtienich['GIA'] ,'HINHSANPHAM' =>$dongtienich["ANHLON"],'HINHSANPHAMNHO' =>$dongtienich["ANHNHO"]));

            }

        }
        return $chuoijson;

    }

    function LayDanhSachSanPhamTheoMaLoai($conn, $maloaisp, $chuoijson, $limit){
        $ngayhientai = date("Y/m/d");
        $truyvantienich = "SELECT *, DATEDIFF(km.NGAYKETTHUC,'".$ngayhientai."') as THOIGIANKM FROM loaisanpham lsp, sanpham sp, khuyenmai km, chitietkhuyenmai ctkm  WHERE lsp.MALOAISP =".$maloaisp."  AND lsp.MALOAISP = sp.MALOAISP AND sp.MASP = ctkm.MASP AND km.MAKM = ctkm.MAKM ORDER BY sp.LUOTMUA DESC LIMIT ".$limit;

        $ketquacon = mysqli_query($conn, $truyvantienich);

        if($ketquacon){
            $phantramkm = 0;
            while($dongtienich = mysqli_fetch_array($ketquacon)){
                    $thoigiankm = $dongtienich["THOIGIANKM"];
                    if($thoigiankm > 0){
                      $phantramkm = $dongtienich["PHANTRAMKM"];
                    }
                    array_push($chuoijson, array("MASP"=>$dongtienich["MASP"],'TENSP' => $dongtienich["TENLOAISP"],"PHANTRAMKM" => $phantramkm, 'GIATIEN' => $dongtienich['GIA'] ,'HINHSANPHAM' =>$dongtienich["ANHLON"]));

            }

        }
        return $chuoijson;

    }
    function LayDanhSachPhuKien(){
      global $conn;
      // Lấy danh sách phụ kiện cha
      $truyvancha = "SELECT * FROM loaisanpham lsp WHERE lsp.TENLOAISP lIKE 'phụ kiện điện thoại%'";
      $ketqua = mysqli_query($conn, $truyvancha);
      $chuoijson = array();

      echo "{";
      echo "\"DANHSACHPHUKIEN\":";
      if($ketqua){
            while ($dong=mysqli_fetch_array($ketqua)) {

              // Lấy danh sách phụ kiện con
              $truyvanphukien = "SELECT * FROM loaisanpham lsp, sanpham sp  WHERE lsp.MALOAI_CHA =".$dong["MALOAISP"]."  AND lsp.MALOAISP = sp.MALOAISP ORDER BY sp.LUOTMUA DESC LIMIT 10";

              $ketquacon = mysqli_query($conn, $truyvanphukien);

              if($ketquacon){
                while($dongphukiencon = mysqli_fetch_array($ketquacon)){

                       array_push($chuoijson, array("MASP"=>$dongphukiencon["MALOAISP"],'TENSP' => $dongphukiencon["TENLOAISP"],'GIATIEN' => $dongphukiencon['GIA'] ,'HINHSANPHAM' =>$dongphukiencon["ANHLON"]));

                }

              }

          }

      }

          echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);

      echo "}";
    }

    function LayDanhSachTopPhuKien(){
      global $conn;
      // Truy vấn điện thoại
      $truyvancha = "SELECT * FROM loaisanpham lsp  WHERE lsp.TENLOAISP lIKE 'phụ kiện điện thoại%'";
      $ketqua = mysqli_query($conn, $truyvancha);
      $chuoijson = array();

      echo "{";
      echo "\"TOPPHUKIEN\":";
      if($ketqua){
          $ngayhientai = date("Y/m/d");
            while ($dong=mysqli_fetch_array($ketqua)) {

              $truyvan = "SELECT *, DATEDIFF(km.NGAYKETTHUC,'".$ngayhientai."') as THOIGIANKM FROM loaisanpham lsp, sanpham sp, khuyenmai km, chitietkhuyenmai ctkm  WHERE lsp.MALOAI_CHA =".$dong["MALOAISP"]."  AND lsp.MALOAISP = sp.MALOAISP AND sp.MASP = ctkm.MASP AND km.MAKM = ctkm.MAKM ORDER BY sp.LUOTMUA DESC LIMIT 10";

              $ketquacon = mysqli_query($conn, $truyvan);

              if($ketquacon){
                $phantramkm = 0;
                while($dongphukiencon = mysqli_fetch_array($ketquacon)){
                      $thoigiankm = $dongphukiencon["THOIGIANKM"];
                      if($thoigiankm > 0){
                          $phantramkm = $dongphukiencon["PHANTRAMKM"];
                      }

                       array_push($chuoijson, array("MASP"=>$dongphukiencon["MASP"],'TENSP' => $dongphukiencon["TENSP"], "PHANTRAMKM"=>$phantramkm, 'GIATIEN' => $dongphukiencon['GIA'] ,'HINHSANPHAM' =>$dongphukiencon["ANHLON"]));

                }

              }

          }

      }

          echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);

      echo "}";
    }


      function LayDanhSachTopDienThoaiVaMayTinhBang(){
        global $conn;

        // Truy vấn điện thoại
        $ngayhientai = date("Y/m/d");
        $truyvan = "SELECT *, DATEDIFF(km.NGAYKETTHUC,'".$ngayhientai."') as THOIGIANKM FROM loaisanpham lsp, sanpham sp, khuyenmai km, chitietkhuyenmai ctkm  WHERE lsp.TENLOAISP like 'điện thoại%'  AND sp.MASP = ctkm.MASP AND km.MAKM = ctkm.MAKM AND lsp.MALOAISP = sp.MALOAISP ORDER BY sp.LUOTMUA DESC LIMIT 10";
        $ketqua = mysqli_query($conn, $truyvan);
        $chuoijson = array();

        echo "{";
        echo "\"TOPDIENTHOAIVAMAYTINHBANG\":";
        if($ketqua){
          $phantramkm = 0;
              while ($dong=mysqli_fetch_array($ketqua)) {
                // cách 1
                // $chuoijson[] = $dong;
                // end cách 1
                // laydanhsachloaisp($dong["MALOAISP"]);
                $thoigiankm = $dong["THOIGIANKM"];

      					if($thoigiankm > 0){
      						$phantramkm = $dong["PHANTRAMKM"];
					      }

                //cách 2
                array_push($chuoijson, array("MASP"=>$dong["MASP"],'TENSP' => $dong["TENSP"],'GIATIEN' => $dong['GIA'] ,'PHANTRAMKM' => $phantramkm ,'HINHSANPHAM' =>$dong["ANHLON"]));
                //end cách 2
              }

              //echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
            }

        $truyvancha = "SELECT * FROM loaisanpham lsp, sanpham sp  WHERE lsp.TENLOAISP like 'máy tính bảng%'  AND lsp.MALOAISP = sp.MALOAISP ORDER BY sp.LUOTMUA DESC LIMIT 10";
        $ketquamtb = mysqli_query($conn, $truyvancha);

        if($ketquamtb){
              while ($dongmtb=mysqli_fetch_array($ketquamtb)) {

                //cách 2
                array_push($chuoijson, array("MASP"=>$dongmtb["MASP"],'TENSP' => $dongmtb["TENSP"],'GIATIEN' => $dongmtb['GIA'] ,'HINHSANPHAM' =>$dongmtb["ANHLON"]));
                //end cách 2
              }

            }
     echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);

        echo "}";
      }


      function LayDanhSachCacThuongHieuLon(){
        global $conn;

        $truyvan = "SELECT * FROM thuonghieu th, chitietthuonghieu ctth WHERE th.MATHUONGHIEU  = ctth.MATHUONGHIEU ";
        $ketqua = mysqli_query($conn, $truyvan);
        $chuoijson = array();
        echo "{";
        echo "\"DANHSACHTHUONGHIEU\":";
        if($ketqua){
              while ($dong=mysqli_fetch_array($ketqua)) {
              
                array_push($chuoijson, array("MASP"=>$dong["MATHUONGHIEU"],'TENSP' => $dong["TENTHUONGHIEU"], 'HINHSANPHAM' =>$dong["HINHLOAISPTH"]));
                //end cách 2
              }

              echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
            }
            echo "}";
      }
      function KiemTraDangNhap(){
          global $conn;
          if(isset($_POST["tendangnhap"]) || isset($_POST["matkhau"])){
            $tendangnhap = $_POST["tendangnhap"];
            $matkhau = $_POST["matkhau"];
          }

          $truyvan = "SELECT * FROM nhanvien WHERE TENDANGNHAP='".$tendangnhap."' AND MATKHAU='".$matkhau."'";
          $ketqua = mysqli_query($conn,$truyvan);
          $demdong = mysqli_num_rows($ketqua);
          if($demdong >=1){
            $tennv = "";
            while ($dong = mysqli_fetch_array($ketqua)) {
              $tennv = $dong["TENNV"];
            }
            echo "{ ketqua : true, tennv : \"".$tennv."\" }";
          }else{
            echo "{ ketqua : false }";
          }

        }
  		function DangKyThanhVien(){
  			global $conn;
  			if(isset($_POST["tennv"]) || isset($_POST["tendangnhap"]) || isset($_POST["matkhau"]) || isset($_POST["maloainv"]) || isset($_POST["emaildocquyen"])){
  				$tennv = $_POST["tennv"];
  				$tendangnhap = $_POST["tendangnhap"];
  				$matkhau = $_POST["matkhau"];
  				$maloainv = $_POST["maloainv"];
  				$emaildocquyen = $_POST["emaildocquyen"];
  			}


  			$truyvan = "INSERT INTO nhanvien (TENNV,TENDANGNHAP,MATKHAU,MALOAINV,EMAILDOCQUYEN) VALUES ('".$tennv."','".$tendangnhap."','".$matkhau."','".$maloainv."','".$emaildocquyen."') ";

  			if(mysqli_query($conn,$truyvan)){
  				echo "{ ketqua : true }";
  			}else{
  				echo "{ ketqua : false }".mysqli_error($conn);
  			}

  			mysqli_close($conn);


  		}

  function LayDanhSachMenu(){
    global $conn;
    if(isset($_POST["maloaicha"])){
      $maloaicha = $_POST["maloaicha"];
    }
    $truyvan = "SELECT * FROM loaisanpham WHERE MALOAI_CHA = ".$maloaicha;
    $ketqua = mysqli_query($conn, $truyvan);
    $chuoijson = array();
    echo "{";
    echo "\"LOAISANPHAM\":";
    if($ketqua){
          while ($dong=mysqli_fetch_array($ketqua)) {
            // cách 1
            $chuoijson[] = $dong;
            // end cách 1
            // laydanhsachloaisp($dong["MALOAISP"]);

            //cách 2
            // array_push($chuoijson, array("TENLOAISP"=>$dong["TENLOAISP"],'MALOAISP' => $dong["MALOAISP"]));
            //end cách 2
          }

          echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
        }
        echo "}";
        mysql_close($conn);
  }




?>
