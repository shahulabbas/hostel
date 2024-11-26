<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin Login</title>
    <link rel="icon" type="image/x-icon" href="img/collagelogo.jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>"> <!-- Ensure latest CSS -->
</head>
<body>
<div class="navbar-top">
        <div class="container">
            <div class="nav">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-headset"></i>Call us now: 08570-255444, 8367799101</a>
                    </li>
                </ul>
                <div class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="mailto:rp.kuppam101@gmail.com"><i class="fas fa-envelope"></i>Mail: rp.kuppam101@gmail.com</a>
                    </li>
                    <ul class="social-icons">
                        <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <header>
        <div class="header">
            <div class="logo">
                <img src="img/collagelogo.jpeg" alt="">
                <p>DR. Y C JAMES YEN GOVERNMENT POLYTECHNIC<br> KUPPAM</p>
                <img src="img/sbtetlogo.png" alt="">
            </div>
            <i class="fa fa-bars icon" aria-hidden="true"></i>
            <div class="menu">
                <ul>
                    <li><a href="../index.php"><i class="fa fa-home" style="margin-right: 8px;"></i>Home</a></li>
                    <li><a href="../contact/login.html"><i class="fa fa-id-card" style=" margin-right: 8px;"></i>Contact Us</a></li>
                    <li><a href="../admin/adminlogin.php"style="color: #1A82C4;"><i class="fa fa-lock" style="margin-right: 8px;"></i>Admin</a></li>
                </ul>
            </div>
        </div>
    </header>

    <main>
    <div class = "frm">  
         
         <form name="f1" action = "connection.php" onsubmit = "return validation()" method = "POST" style="backdrop-filter:blur('2px')">  
             
         <legend><h3>Login</h3> </legend>
             <div class="form"> 
                 <input type = "text" id ="user" name  = "user" placeholder="Enter username"/>  
                 </div> 
                 <div class="form">
                 <input type = "password" id ="pass" name  = "pass" placeholder="Password" />  
                 </div> 
                 <div class="form check" style=""> 
                 <div class="box">
                 <input type="checkbox" id="myCheck" onclick="myFunction()" style="width:15px"> 
                 <p style="font-size:13px;font-weight:normal;margin:15px">Show password</p>
                  </div>
                 <button onclick="forgot()">forgot password?</button>
                 </div>
                 <div class="form submit">   
                 <input type =  "submit" id = "btn" value = "Login"/> 
                 </div>
                
         </form>
     </div>
    </main>

    

    <script>  
            let icon = document.querySelector(".icon");
            let menu = document.querySelector(".menu");
    const x = document.getElementById("pass");
    function forgot()
    {
    window.location.href = "forgotpage.html";
    }
   function myFunction(){
  var checkBox = document.getElementById("myCheck");
  var text = document.getElementById("pass");
  if (checkBox.checked == true){
    text.setAttribute("type", "text");
  } else {
    text.setAttribute("type", "password");
  }
}
    
function validation()  
    {  
                var id=document.f1.user.value;  
                var ps=document.f1.pass.value;  
                if(id.length=="" && ps.length=="") {  
                    alert("User Name and Password fields are empty");  
                    return false;  
                }  
                else  
                {  
                    if(id.length=="") {  
                        alert("User Name is empty");  
                        return false;  
                    }   
                    if (ps.length=="") {  
                    alert("Password field is empty");  
                    return false;  
                    }  
                }                             
            }  
            


        icon.onclick = function() {
            menu.classList.toggle("active");
        }

        </script>  
</body>
</html>