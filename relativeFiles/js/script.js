'use strict';

/**
 * navbar toggle
 */

const overlay = document.querySelector("[data-overlay]");
const navOpenBtn = document.querySelector("[data-nav-open-btn]");
const navbar = document.querySelector("[data-navbar]");
const navCloseBtn = document.querySelector("[data-nav-close-btn]");

const navElemArr = [overlay, navOpenBtn, navCloseBtn];

for (let i = 0; i < navElemArr.length; i++) {
  navElemArr[i].addEventListener("click", function () {
    navbar.classList.toggle("active");
    overlay.classList.toggle("active");
  });
}



/**
 * add active class on header when scrolled 200px from top
 */

const header = document.querySelector("[data-header]");

window.addEventListener("scroll", function () {
  window.scrollY >= 200 ? header.classList.add("active")
                        :  header.classList.remove("active");
})


  // Search script
  $(document).ready(function(){
      var initialData = "";

      // onload to pre
      $.ajax({
          url:"ajax-data/selectAllProd.php",
          method:"GET",
          success:function(data){
              initialData = data;
              $('#results').html(initialData);
          }
      });
  
      // $('#search').keyup(function(){
        document.getElementById("search").addEventListener("input", function() {
          var input = $(this).val();
  
          if (input != "") {
              // If searching, clear the initial data
              $('#results').html("");

              $.ajax({
                  url:"ajax-data/selectAllProd.php",
                  method:"POST",
                  data:{input:input},
                  success:function(data)
                  {
                      $('#results').html(data);
                  }
              });
          } else {
              $('#results').html(initialData);
          }
        });
        
        // search para sa mobile view
        document.getElementById("search-mobile").addEventListener("input", function() {
          var input = $(this).val();
  
          if (input != "") {
              // If searching, clear the initial data
              $('#results').html("");

              $.ajax({
                  url:"ajax-data/selectAllProd.php",
                  method:"POST",
                  data:{input:input},
                  success:function(data)
                  {
                      $('#results').html(data);
                  }
              });
          } else {
              $('#results').html(initialData);
          }
        });
  });

//filter category
document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', getFilteredData);
});

function getFilteredData() {
  
  const filterValue = this.dataset.filter;
  // clear the initial data
    $('#results').html("");

    $.ajax({
      url:"ajax-data/selectAllProd.php",
      method:"POST",
      data:{filterValue:filterValue},
      success:function(data)
      {
        $('#results').html(data);
      }
    });
  }

  

// show cart script
const cartOverlay = document.querySelector("[cart-overlay]");
const OpenCart = document.querySelector("#show-cart");
const cartContainer = document.querySelector(".cart-container");
const cartCloseBtn = document.querySelector(".cart-container .close-btn");

const cartElemArr = [cartOverlay, OpenCart, cartCloseBtn];

for (let i = 0; i < cartElemArr.length; i++) {
  cartElemArr[i].addEventListener("click", function () {
    cartContainer.classList.toggle("active");
    cartOverlay.classList.toggle("active");
  });
}



//  add to cart functionality
$(document).ready(function() {
  var CARTinitialData = "";

  // onload to pre
  $.ajax({
    url: 'cartData.php',
    method: "POST",
    success: function(data) {
      CARTinitialData = data;
      $('#cart-items').html(CARTinitialData);
    }
  });

  $.ajax({
    url: './ajax-data/numItemCart.php',
    method: "POST",
    success: function(data) {
      $('#numCarts').html(data);
    }
  });


  // add to cart
  $(document).on('click', '.add-to-cart', function() {
    const product = $(this).closest('.product-card');
    const productName = product.find('h3.card-title a').text();

    // Send cart data to PHP script
    $.ajax({
      url: 'cartData.php',
      method: 'POST',
      data: { productName: productName },
      success: function(response) {
        // Replace the contents of #cart-items with the response HTML
        $('#cart-items').html(response);
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
      }
    });
    // alert("Item Added to Cart");


    $.ajax({
      url: './ajax-data/numItemCart.php',
      method: "POST",
      success: function(data) {
        $('#numCarts').html(data);
      }
    });
  });


  // delete to cart
  $(document).on('click', '.delete-item', function() {
    const product = $(this).closest('.cart-item');
    const DeleteProductName = product.find('div.img-box p').text();

    // Send cart data to PHP script
    $.ajax({
      url: 'cartData.php',
      method: 'POST',
      data: { DeleteProductName: DeleteProductName },
      success: function(response) {
        // Replace the contents of #cart-items with the response HTML
        $('#cart-items').html(response);
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
      }
    });
    alert("Item Deleted to Cart");
  });

  $.ajax({
    url: './ajax-data/numItemCart.php',
    method: "POST",
    success: function(data) {
      $('#numCarts').html(data);
    }
  });
});


// update quantity
$(document).ready(function() {
  $(document).on('input', '.quantity-box input[type="number"]', function() {
      // Retrieve the value of the input field
      const quantity = parseInt($(this).val());
      
      // Check if the quantity is greater than 1
      if (quantity > 0) {

          // Retrieve other necessary data
          const cartID = $(this).attr('id');
          
          // Send AJAX request
          $.ajax({
              url: 'quantity.php',
              method: 'POST',
              data: {
                  cartID: cartID,
                  quantity: quantity
              },
              success: function(response) {
                  // Handle success response
                  // console.log(response);
                  $('#total-box').html(response);
              },
              error: function(xhr, status, error) {
                  // Handle error
                  console.error('Error:', error);
              }
          });
          // alert(quantity);
      }
  });
});

$(function() {
  if ($('.quantity-box').length > 0) {
      // Elements with class 'quantity-box' exist in the DOM
      // You can proceed with your script here
      $('.quantity-box input[type="number"]').on('input', function() {
          // Your event handling code here
      });
  } else {
      // Elements with class 'quantity-box' do not exist in the DOM
      // You may want to handle this case, e.g., show an error message
      console.error("Error: Elements with class 'quantity-box' not found in the DOM.");
  }
});





