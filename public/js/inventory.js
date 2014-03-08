// Ajax call to add item
$(".addItem").click(function(){
  var id = this.id.split('-')[1];
  url = "/inventory/increment/" + id;
  $.ajax({
      url: url,
      type: "get",
      success: function(data){
          var data = JSON.parse(data);
          containerId = "#value-" + id;
          //update counter
          var qty = $(containerId).text();
          $(containerId).text(parseInt(qty) + 1);
      },
      error:function(){
          alert("failure");
          $("#result").html('There was an error during submission');
      }
    });
});

// Ajax call to remove item
$(".removeItem").click(function(){
  var id = this.id.split('-')[1];
  url = "/inventory/decrement/" + id;
  $.ajax({
      url: url,
      type: "get",
      success: function(data){
          // update counter
          containerId = "#value-" + id;
          var qty = $(containerId).text();
          if (qty > 0) {
            $(containerId).text(parseInt(qty) - 1);  
          } else {
            $(containerId).text(0);  
          }
          
      },
      error: function(){
          alert("failure");

          $("#result").html('There was an error during submission');
      }
  });
})





