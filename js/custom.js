$(function() {
$("#register-form").validate({
errorElement: 'span',
errorClass: 'errMsg',
// Specify the validation rules
rules: {
customer_name: "required",
customer_email: {
required: true,
},
customer_password: {
required: true,
minlength: 5
},
customer_pin: {
number: true,
minlength: 6,
maxlength: 6
},   
shipping_pin: {
number: true,
minlength: 6,
maxlength: 6
},
password_confirm : {
required: true,
minlength : 5,
equalTo : "#customer_password"
}
},

// Specify the validation error messages
messages: {
customer_name: "Please enter your  name",
customer_password: {
required: "Please provide a password",
minlength: "Your password must be at least 5 characters long"
},
customer_email: "Please enter a valid email address",

},

submitHandler: function(form) {
// form.submit();
swal('Please wait')
swal.showLoading()
//alert( $("#register-form").serialize());

$.ajax({
type: "POST",
url: 'API/register.php',
data: $("#register-form").serialize(), // serializes the form's elements.
dataType: 'json',
success: function(data)
{
if (data.status==true) {
swal(  'Congratulation',  data.msg,  'success');
$("#register-form").trigger("reset");
}
if (data.status==false) {
swal(  'Sorry',  data.msg,  'error');
}
},
error: function (e) {
swal(  'Sorry',  e,  'error');
},
});
}
});
//************** Login***************
$("#login-form").validate({
errorElement: 'span',
errorClass: 'errMsg',
// Specify the validation rules
rules: {
customer_email: {
required: true,
},
customer_password: {
required: true,
minlength: 5
},
},

// Specify the validation error messages
messages: {
customer_password: {
required: "Please provide a password",
minlength: "Your password must be at least 5 characters long"
},
customer_email: "Please enter a valid email address",

},

submitHandler: function(form) {
// form.submit();
swal('Please wait')
swal.showLoading()

$.ajax({
type: "POST",
url: 'API/login.php',
data: $("#login-form").serialize(), // serializes the form's elements.
dataType: 'json',
success: function(data)
{
if (data.status==false) {
swal('Congratulation',  data.msg,  'success');
$("#login-form").trigger("reset");
history.go(-1);
}
if (data.status==true) {
swal(  'Sorry',  data.msg,  'error');
}
},
error: function (e) {
swal(  'Sorry',  e,  'error');
},
});
}
});
});
$(document).ready(function(){
/* Place Order */

$('#order_submit').on("click", function(event) {
event.preventDefault();
//alert($("#place_order").serialize());
swal('Please wait')
swal.showLoading()
$.ajax({
type: "POST",
url: 'ajax/product_order_convert_json.php',
data: $("#place_order").serialize(), // serializes the form's elements.
dataType: 'json',
success: function(result)
{
 
// alert(result);
//alert(JSON.stringify(result));
if (result.status==true) {
$.ajax({
type: "POST",
url: 'API/place_order_new.php',
dataType: 'json',
data: { place_order: JSON.stringify(result) }, // serializes the form's elements.
success: function(data)
{
// alert(JSON.stringify(data));
if (data.status==true) {
window.location.href = "thank-you.php";
}
else{
if (data.stock!='') {
swal(  'Sorry',  data.msg,  'error');
}
else{ swal(  'Sorry',  data.msg,  'error');
}
}
},
error: function (e) {
swal(  'Sorry',  e,  'error');
},
});
}
else{
swal(  'Sorry', result.msg,  'error');
}
},
error: function (e) {
swal(  'Sorry',  e,  'error');
},
});
});
/* add to bag  */
//$("#add_to_bag").click(function() {
$('#add_to_bag').on("click", function(event) {
event.preventDefault();
// alert($("#order_details").serialize());
$.ajax({
type: "POST",
url: 'ajax/product_details_convert_json.php',
data: $("#order_details").serialize(), // serializes the form's elements.
dataType: 'json',
success: function(result)
{
// alert(JSON.stringify(result));
if (result.status==true) {
$.ajax({
type: "POST",
url: 'API/add_to_cart.php',
dataType: 'json',
data: { add_to_cart: JSON.stringify(result.product) }, // serializes the form's elements.
success: function(data)
{
// alert(JSON.stringify(data));
if (data.status==true) {
window.location.href = "shopping-bag.php";
}
else{
swal(  'Sorry',  data.msg,  'error');
}
},
error: function (e) {
swal(  'Sorry',  e,  'error');
},
});
}
else{
swal(  'Sorry', result.msg,  'error');
}
},
error: function (e) {
swal(  'Sorry',  e,  'error');
},
});
});
/* Add wish list */
$('#add_to_wish_list').on("click", function(event) {
event.preventDefault();
$.ajax({
type: "POST",
url: 'ajax/product_details_convert_json.php',
data: $("#order_details").serialize(), // serializes the form's elements.
dataType: 'json',
success: function(result)
{
//alert(JSON.stringify(result));
if (result.status==true) {
$.ajax({
type: "POST",
url: 'API/add_to_wish_list.php',
dataType: 'json',
data: { add_to_wishlist: JSON.stringify(result.product) }, // serializes the form's elements.
success: function(data)
{
if (data.status==true) {
window.location.href = "wishlist.php";
}
else{
swal(  'Sorry',  data.msg,  'error');
}
},
error: function (e) {
swal(  'Sorry',  e,  'error');
},
});
}
else{
swal(  'Sorry', result.msg,  'error');
}
},
error: function (e) {
swal(  'Sorry',  e,  'error');
},
});
});
$('.remove-wishlist').on("click", function(event) {
event.preventDefault();
var product_id= $(this).attr("data-id");
var customer_id =$('#customer_id').val();
$.ajax({
type: "POST",
url: 'API/delete_wishlist.php',
data: {"product_id": product_id,"customer_id": customer_id}, // serializes the form's elements.
dataType: 'json',
success: function(data)
{
if (data.status==true) {
window.location.href = "wishlist.php";
swal(  'Congratulation',  data.msg,  'success');
}
if (data.status==false) {
if (data.msg=='No product found.') {
window.location.href = "wishlist.php";
}else{
swal(  'Sorry',  data.msg,  'error');

}
}
},
error: function (e) {
swal(  'Sorry',  e,  'error');
},
});
});
$('.move-bag').on("click", function(event) {
event.preventDefault();
var product_id= $(this).attr("data-id");
var customer_id =$('#customer_id').val();
$.ajax({
type: "POST",
url: 'API/move_to_bag.php',
data: {"product_id": product_id,"customer_id": customer_id}, // serializes the form's elements.
dataType: 'json',
success: function(data)
{
if (data.status==true) {
swal(  'Congratulation',  data.msg,  'success');
window.location.href = "shopping-bag.php";
}
if (data.status==false) {
swal(  'Sorry',  data.msg,  'error');
}
},
error: function (e) {
swal(  'Sorry',  e,  'error');
},
});
});
$('.remove-bag').on("click", function(event) {
event.preventDefault();
var product_id= $(this).attr("data-id");
var customer_id =$('#customer_id').val();
$.ajax({
type: "POST",
url: 'API/delete_cart.php',
data: {"product_id": product_id,"customer_id": customer_id}, // serializes the form's elements.
dataType: 'json',
success: function(data)
{
if (data.status==true) {
window.location.href = "shopping-bag.php";
swal(  'Congratulation',  data.msg,  'success');
}
if (data.status==false) {

if (data.msg=='No product found.') {
window.location.href = "shopping-bag.php";
}else{
swal(  'Sorry',  data.msg,  'error');

}
}
},
error: function (e) {
swal(  'Sorry',  e,  'error');
},
});
});
$('.move-Wishlist').on("click", function(event) {
event.preventDefault();
var product_id= $(this).attr("data-id");
var customer_id =$('#customer_id').val();
$.ajax({
type: "POST",
url: 'API/move_to_wishlist.php',
data: {"product_id": product_id,"customer_id": customer_id}, // serializes the form's elements.
dataType: 'json',
success: function(data)
{
if (data.status==true) {

window.location.href = "wishlist.php";
swal(  'Congratulation',  data.msg,  'success');
}
if (data.status==false) {
swal(  'Sorry',  data.msg,  'error');
}
},
error: function (e) {
swal(  'Sorry',  e,  'error');
},
});
});
});
if($('.p-derails-wrap').length>0){
$(document).on('keyup change','.set_qty',function(){
var row= $(this).attr("data-id");
var set_qty =Number($("#set_"+row+"").val());
var Pcs= $("#style_set_qty_"+row+"").val();
var style_mrp= $("#style_mrp_for_size"+row+"").val();
var stock_in_hand=Number($("#stock_in_hand"+row+"").val());
var discount= $("#discount_percent").val();
var dis=0;

if(set_qty<=stock_in_hand){
var total= style_mrp*set_qty*Pcs;
//var total= style_mrp*set_qty;
if (discount>0) {
  dis=total*discount/100;
}
total=total-dis;
total =Number(total.toFixed(2));
//alert(total);
$("#amt_"+row+"").autoNumeric('init');
$("#amt_"+row+"").autoNumeric('set', total);
//$("#amt_"+row+"").html(total);
$("#amount_"+row+"").val(total);
var piece =Pcs*set_qty;
$("#piece"+row+"").val(piece);
$("#set_piece_"+row+"").html(piece);

}
else{
$("#set_"+row+"").val(stock_in_hand);
swal(  'Sorry',  'The style is out of stock, Available stock is :'+stock_in_hand+'',  'error');
}
//console.log(calculate(row));
//console.log(totalcal());

});
}
if($('.wishlist-row').length>0){
$(document).on('keyup change','.set_qty',function(){
var row= $(this).attr("data-id");
var set_qty =Number($(this).val());
var Pcs= $("#style_set_qty_"+row+"").val();
var style_mrp= $("#style_mrp_for_size"+row+"").val();
var stock_in_hand=Number($("#stock_in_hand"+row+"").val());
var discount= $("#discount_percent").val();


if(set_qty<=stock_in_hand){
var total= style_mrp*set_qty*Pcs;
if (discount>0) {
total=total*discount/100;
}
total =Number(total.toFixed(2));
//alert(total);
$("#amt_"+row+"").autoNumeric('init');
$("#amt_"+row+"").autoNumeric('set', total);
//$("#amt_"+row+"").html(total);
$("#amount_"+row+"").val(total);
var piece =Pcs*set_qty;
$("#piece"+row+"").val(piece);
$("#set_piece_"+row+"").html(piece);

}
else{
$("#set_"+row+"").val(stock_in_hand);
swal(  'Sorry',  'The style is out of stock, Available stock is :'+stock_in_hand+'',  'error');
}
//console.log(calculate(row));
//console.log(totalcal());

});
}