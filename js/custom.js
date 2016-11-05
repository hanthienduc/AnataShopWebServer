
$(document).ready(function(){

	$("body").delegate(".btnthemchitietsanpham","click",function(){
		var khungchitietsanpham = $(".anchitietsanpham").clone().removeClass("anchitietsanpham");
		$("#khungchitietsanpham").append(khungchitietsanpham);

		$(this).parent().find(".btnxoachitietsanpham").removeClass("anbutton");
		$(this).closest("tr").find("input").attr("disabled",true);
		$(this).remove();
	});
	//Xử lý sự kiện click button thêm sản phẩm
	$("#btn-themsanpham").click(function(){
		var mota = tinymce.get("ip_thongtin").getContent();
		var mangtenchitiet = [];
		$("input[name='mangtenchitietsanpham[]']").each(function(){
			var value = $.trim($(this).val());
			if(value.length > 0){
				mangtenchitiet.push(value);
				alert(value);
			}

		});

		var manggiatrichitiet = [];
		$("input[name='manggiatrichitietsanpham[]']").each(function(){
			var value = $.trim($(this).val());
			if(value.length > 0){
				manggiatrichitiet.push(value);
				alert(value);
			}

		});
	});

	//tinymce của mô tả sản phẩm
	tinymce.init({
		selector: "textarea#ip_thongtin",
		height: 250,
		plugins: [
				    'advlist autolink lists link image charmap print preview anchor',
				    'searchreplace visualblocks code fullscreen',
				    'insertdatetime media table contextmenu paste code'
				  ],
		 toolbar: 'insertfile undo redo  | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	});

	//file cho phép upload hình sản phẩm

	$("#ip_anhlon").fileinput({
        'allowedFileExtensions' : ['jpg', 'png','gif'],
      	"showPreview": false,
    });

    $("#ip_anhnho").fileinput({
        'allowedFileExtensions' : ['jpg', 'png','gif'],
    });

	//thực hiện chức năng tìm kiếm loại sản phẩm
	$("#btn-timkiemloaisp").click(function(){
		var noidungtimkiem = $("#txt-timtenloaisp").val();
		$.ajax({
			url : "function.php", //đường dẫn của trang xử lý code gữi qua
			type : "POST",
			// datatype: ""
			data : {
				action : "TimKiemLoaiSanPhamTheoTen_Ajax",
				noidungtimkiem : noidungtimkiem,

			},
			success:function(data){
				$("table.table").find("tbody").empty();
				$("table.table").find("tbody").append(data);
				$("ul.pagination").remove();
			}
		});
	});


	// Thực hiện hiện chức năng thêm loại sản phẩm
	$("#btn-themloaisp").click(function(){
		var tenloaisanpham = $("#ip_tenloaisp").val();
		var maloaisp = $("#sl_cha").val();

		$.ajax({
			url : "function.php", //đường dẫn của trang xử lý code gữi qua
			type : "POST",
			// datatype: ""
			data : {
				action : "ThemLoaiSanPham",
				tenloaisanpham : tenloaisanpham,
				maloaisp : maloaisp
			},
			success:function(data){
				$(".thongbaoloi").empty();
				$(".thongbaoloi").append(data);
			}
		});
	});

	// Thực hiện chức năng phân trang
	$("nav").delegate("ul.pagination>li","click",function(){
		var sotrang = $(this).text();
		$("ul.pagination>li").removeClass("active");
		$(this).addClass("active");
		$.ajax({
			url : "function.php", //đường dẫn của trang xử lý code gữi qua
			type : "POST",
			// datatype: ""
			data : {
				action : "LayDanhSachLoaiSanPhamLimit_Ajax",
				sotrang : sotrang,

			},
			success:function(data){
				$("table.table").find("tbody").empty();
				$("table.table").find("tbody").append(data);
			}
		});
	});


	// Xử lý check tất cả checkbox
	$("#cb-chontatca").change(function(){
		var allcheckbox = $(this).closest("table").find("tbody input:checkbox");
		if($(this).is(":checked")){
			allcheckbox.prop("checked",true);
		}else{
			allcheckbox.prop("checked",false);
		}
	});

	//Xử lý xóa loại sản phẩm
	$("#btn-xoaloaisanpham").click(function(){
		var mangcheckbox = [];
		$("input[name='cb-mang[]']:checked").each(function(){
			var maloai = $(this).attr("data-id");
			mangcheckbox.push(maloai);
		});

		$.ajax({
			url : "function.php", //đường dẫn của trang xử lý code gữi qua
			type : "POST",
			// datatype: ""
			data : {
				action : "XoaLoaiSanPhamTheoMa_Ajax",
				mangmaloaisp : mangcheckbox,

			},
			success:function(data){

				//load lại nội dung của loại sản phẩm khi xóa
				$.ajax({
						url : "function.php", //đường dẫn của trang xử lý code gữi qua
						type : "POST",
						// datatype: ""
						data : {
							action : "LayDanhSachLoaiSanPhamLimit_Ajax",
							sotrang : 1,

						},
						success:function(dulieu){
							$("table.table").find("tbody").empty();
							$("table.table").find("tbody").append(dulieu);
						}
					});

				$.ajax({
						url : "../html/page_product/function.php", //đường dẫn của trang xử lý code gữi qua
						type : "POST",
						// datatype: ""
						data : {
							action : "HienThiPhanTrang_Ajax",

						},
						success:function(dulieuphantrang){
							$("ul.pagination").empty();
							$("ul.pagination").append(dulieuphantrang);
						}
					});
			}
		});
	});



});
function fValid(){
		var username = window.localStorage.getItem("username");
		if(username=="" || username==undefined || username==null){
			location="login.php";
		}
	}
