$(document).ready(function(){
 
  //デフォルトで表示する要素を指定

  $('.hero-btn').hide(); 
  $('.loginpanel').show();
  $('.kaiintouroku').hide();
  $('.kaiintouroku2').hide();

  //Enterがクリックされたら
  $('.hero-btn').click(function () {
     
  $('.loginpanel').show();
  $('.hero-btn').hide();
  
  });

  //Registerがクリックされたら
    $('.entypo-user-add').click(function () {
    
    $('.loginpanel').hide();   
    $('.kaiintouroku').show();
    });

  //Create Accountがクリックされたら
  $('.hero-btn2').click(function () {
     
  $('.loginpanel').hide();
  $('.hero-btn').hide();
  $('.kaiintouroku').hide();
  $('.kaiintouroku2').show();
//  $('.social-links').hide();
//  $('.webscope').hide();

//登録内容確認
    var user = $("#user").val();
    $("#nick_name").val(user);

    var email = $("#user1").val();
    $("#email").val(email);

    var pwd = $("#pwd1").val();
    $("#password").val(email);

  });

});