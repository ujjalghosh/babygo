<!DOCTYPE html>
<html>
<head>
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
</head>
<body>
    <form id="formoid"  title="" method="post">
        <div>
            <label class="title">First Name</label>
            <input type="text" id="name" name="name" >
        </div>
        <div>
            <label class="title">Name</label>
            <input type="text" id="name2" name="name2" >
        </div>
        <div>
            <input type="submit" id="submitButton"  name="submitButton" value="Submit">
        </div>
 </form>
<script type='text/javascript'>
    /* attach a submit handler to the form */
    $("#formoid").submit(function(event) {

      /* stop form from submitting normally */
      event.preventDefault();

      $.ajax({
           type: "POST",
           url: 'ajax/product_details_convert_json.php',
           //data: $("#login-form").serialize(), // serializes the form's elements.
           dataType: 'json',
           success: function(result)
           { 
        alert(JSON.stringify(result));
      $.ajax({
           type: "POST",
           url: 'API/add_to_cart.php',
           dataType: 'json',
           data: { add_to_cart: JSON.stringify(result) }, // serializes the form's elements.          
           success: function(data)
           {
        alert(JSON.stringify(data));
           },
        error: function (e) {
            swal(  'Sorry',  e,  'error'); 
        },

         });

           },

        error: function (e) {
             swal(  'Sorry',  e,  'error'); 
        },

         });




      /* get the action attribute from the <form action=""> element */
      var $form = $( this ),
          url = $form.attr( 'action' );

      /* Send the data using post with element id name and name2*/
      var posting = $.post( url, { name: $('#name').val(), name2: $('#name2').val() } );

      /* Alerts the results */
      posting.done(function( data ) {
        alert('success');
      });
    });
</script>

</body>
</html> 