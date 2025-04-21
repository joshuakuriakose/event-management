<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Lato", sans-serif;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    overflow: hidden;
}

.outer-box {
    width: 100vw;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

.inner-box {
    width: 420px;
    padding: 30px 40px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(8px);
    position: relative;
    transform: translateY(0);
    transition: all 0.3s ease;
}

.inner-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
}

.signup-header h1 {
    font-size: 2.2rem;
    color: #2c3e50;
    text-align: center;
    margin-bottom: 8px;
    font-weight: 700;
}

.signup-header p {
    font-size: 1rem;
    color: #7f8c8d;
    text-align: center;
}

.signup-body {
    margin: 25px 0;
}

.signup-body p {
    margin: 15px 0;
}

.signup-body p label {
    display: block;
    font-weight: 600;
    color: #34495e;
    margin-bottom: 6px;
}

.signup-body p input {
    width: 100%;
    padding: 12px 18px;
    border: none;
    border-radius: 50px;
    font-size: 1rem;
    background: #ecf0f1;
    transition: all 0.3s ease;
}

.signup-body p input:focus {
    outline: none;
    background: #fff;
    box-shadow: 0 0 10px rgba(52, 152, 219, 0.3);
}

.signup-body p input[type="submit"] {
    background: linear-gradient(90deg, #3498db, #2980b9);
    color: white;
    font-weight: 600;
    cursor: pointer;
    margin-top: 20px;
    padding: 14px;
}

.signup-body p input[type="submit"]:hover {
    background: linear-gradient(90deg, #2980b9, #2471a3);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
}

.circle {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0));
    position: absolute;
    animation: float 5s ease-in-out infinite;
    pointer-events: none;
}

.c1 {
    top: 10%;
    left: 15%;
    animation-delay: 0s;
}

.c2 {
    bottom: 15%;
    right: 10%;
    animation-delay: 2.5s;
}

@keyframes float {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-30px) scale(1.05); }
}

.login-link {
    text-align: center;
    margin-top: 20px;
    font-size: 0.9rem;
    color: #34495e;
}

.login-link a {
    color: #3498db;
    text-decoration: none;
    font-weight: 600;
}

.login-link a:hover {
    color: #2980b9;
    text-decoration: underline;
}

@media (max-width: 480px) {
    .inner-box {
        width: 90%;
        padding: 20px;
    }
}
    </style>
</head>
<body>
    <div class="outer-box">
        <div class="inner-box">
            <header class="signup-header">
                <h1>Sign Up</h1>
            </header>
            <main class="signup-body">
                <form action="signup_process.php" method="POST">
                    <p>
                        <label for="fullname">Full Name</label>
                        <input type="text" id="fullname" name="username" placeholder="Enter your name" required>
                    </p>
                    <p>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </p>
                    <p>
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone_number" placeholder="Enter your phone number" required pattern="[0-9]{10}" title="Phone number must be exactly 10 digits">
                    </p>
                    <p>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter password" required>
                    </p>
                    <p>
                        <input type="submit" id="submit" value="Create Account">
                    </p>
                </form>
            </main>
            <div class="login-link">
                Already have an account? <a href="login.php">Login</a>
            </div>
        </div>
        <div class="circle c1"></div>
        <div class="circle c2"></div>
    </div>
</body>
</html>