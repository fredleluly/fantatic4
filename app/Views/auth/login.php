<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Support PLN Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            background-color: #f5f5f5;
        }

        .split-container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .left-side {
            flex: 1;
            position: relative;
            background: url('<?= base_url('icon.png') ?>') center/cover no-repeat;
            display: flex;
            align-items: flex-start;
            padding: 20px;
        }

        .right-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            background: #ffffff;
        }

        .login-container {
            max-width: 450px;
            width: 100%;
            margin: 0 auto;
        }

        h1 {
            color: #333;
            font-size: 2.2em;
            margin-bottom: 40px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #666;
            margin-bottom: 8px;
            font-size: 0.95em;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #00B4DB;
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            font-size: 1.2em;
            user-select: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
        }

        .btn {
            background-color: #00B4DB;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            width: 100%;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0088a9;
        }

        .error-message {
            color: #ff4444;
            background: #ffe6e6;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 0.9em;
            text-align: center;
        }
        .splash-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .splash-screen.active {
            opacity: 1;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #00B4DB;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        .progress-bar {
            width: 200px;
            height: 4px;
            background: #f0f0f0;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .progress-fill {
            height: 100%;
            background: #00B4DB;
            width: 0%;
            transition: width 2s ease-in-out;
            animation: progress 2s ease-in-out forwards;
        }

        .splash-text {
            color: #333;
            font-size: 1.1em;
            font-weight: 500;
            opacity: 0;
            transform: translateY(10px);
            animation: fadeInUp 0.5s ease forwards 0.3s;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes progress {
            0% { width: 0%; }
            100% { width: 100%; }
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <!-- Add Font Awesome for the eye icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="split-container">
        <div class="left-side"></div>
        <div class="right-side">
            <div class="login-container">
                <h1>Anjungan IT Support - PLN</h1>
                <?php if (session()->getFlashdata('error')): ?>
                    <p class="error-message"> <?= session()->getFlashdata('error') ?> </p>
                <?php endif; ?>
                <form id="loginForm" action="<?= site_url('auth/login') ?>" method="POST">
                    <div class="form-group">
                        <label for="Username">Username</label>
                        <input type="text" id="Username" name="Username" required>
                    </div>
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <div class="password-container">
                            <input type="password" id="Password" name="Password" required>
                            <span class="toggle-password" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn">Sign In</button>
                    
                </form>
            </div>
        </div>
    </div>
    <script>
        // Password toggle functionality
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('Password');
            const toggleIcon = this.querySelector('i');
            
            // Toggle the type attribute
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });

        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Create splash screen element
            const splash = document.createElement('div');
            splash.className = 'splash-screen';
            
            // Create splash screen content
            splash.innerHTML = `
                <div class="spinner"></div>
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <div class="splash-text">Sedang memproses login...</div>
            `;
            
            document.body.appendChild(splash);
            
            // Trigger animations
            requestAnimationFrame(() => {
                splash.classList.add('active');
            });

            // Submit form after animations
            setTimeout(() => {
                splash.style.opacity = '0';
                setTimeout(() => {
                    event.target.submit();
                }, 300);
            }, 2000);
        });
    </script>
</body>
</html>