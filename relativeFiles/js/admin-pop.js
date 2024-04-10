// <!-- side bar script -->

    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e)=>{
    let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
    arrowParent.classList.toggle("showMenu");
    });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("close");
    });


// <!-- add products script -->

    // var overlay = document.getElementById('overlay');
    // var popup = document.getElementById('popup');
    // var addProductBtn = document.querySelector('.add-product');

    // addProductBtn.addEventListener('click', function() {
    //     overlay.style.display = 'block';
    //     popup.style.display = 'block';
    // });

    // function closePopup() {
    //     overlay.style.display = 'none';
    //     popup.style.display = 'none';
    // }
