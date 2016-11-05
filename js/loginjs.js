$(document).ready(function(){
  $("#btn-dangnhap").click(function(){
    alert("Hello");
    var tendangnhap = $("#txt-email").val();
    var matkhau = $("#txt-password").val();

    $.ajax({
      url : "function.php", //đường dẫn của trang xử lý code gữi qua
      type : "POST",
      // datatype: ""
      data : {
        action : "KiemTraDangNhap",
        tendangnhap : tendangnhap,
        matkhau : matkhau
      },
      success:function(data){
        if(data == "false"){

        }else {
          window.localStorage.setItem("username",data);
			   	location = "index.php";
        }
      }
    });
  });


});
