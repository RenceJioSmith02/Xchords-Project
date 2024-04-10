<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css -->
    <link rel="stylesheet" href="login/login.css">
    <link rel="stylesheet" href="login/pop.css">
</head>
<body>
    
    <div class="pop-up login">

        <div class="overlay" data-overlay></div>

        <div class="container-login" id="container-login">
            
            <div class="close-btn"><span>&times</span></div>

            <div class="form-container-login sign-up">
                <div class="logo-title">

                </div>
                <form action="<?php $_SERVER['PHP_SELF'] ?>">
                    <h1>Create account</h1>
                    <div class="social-icons">
                        <a href="">
                            <i class="fa-brands fa-google"></i>
                        </a>
                        <a href="">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                        <a href="">
                            <i class="fa-brands fa-github-alt"></i>
                        </a>
                    </div>
                    <span>
                        or use your email for registration
                    </span> 
                    <input type="text" name="name" placeholder="Name" required />
                    <input type="email" name="email" placeholder="Email" required />
                    <input type="password" name="password" placeholder="Password" required/>
                    <button type="submit" name="signup">Sign Up</button>
                </form>
            </div>
    
            <div class="form-container-login sign-in">
                <div class="logo-title">

                </div>
                <form action="">
                    <h1>Sign In</h1>
                    <div class="social-icons">
                        <a href="">
                            <i class="fa-brands fa-google"></i>
                        </a>
                        <a href="">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                        <a href="">
                            <i class="fa-brands fa-github-alt"></i>
                        </a>
                    </div>
                    <span>
                        or use your email paswword
                    </span> 
                    <input type="email" placeholder="Email" required />
                    <input type="password" placeholder="Password" required/>
                    <a href="">
                        forgot your password?
                    </a>
                    <button>Sign In</button>
                </form>
            </div>
    
            <div class="toggle-container-login">
                <div class="toggle">
    
                    <div class="toggle-panel toggle-left">
                        <h1>Welcome Back!</h1>
                        <p>
                            Already have an account?
                        </p>
                        <button class="hidden" id="login">Sign In</button>
                    </div>
    
                    <div class="toggle-panel toggle-right">
                        <h1>New Here?</h1>
                        <p>
                            Sign up and discover a great amount of opportunities.
                        </p>
                        <button class="hidden" id="register">Sign Up</button>
                    </div>
    
                </div>
            </div>
        </div>
        
    </div>

</body>
</html>