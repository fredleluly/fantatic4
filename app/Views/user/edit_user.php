<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #10b981;
            --secondary-dark: #059669;
            --dark: #1e1b4b;
            --darker: #312e81;
            --light: #f3f4f6;
            --gray: #9ca3af;
            --warning: #f59e0b;
            --danger: #ef4444;
            --card-bg: rgba(30, 27, 75, 0.95);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--dark) 0%, var(--darker) 100%);
            color: var(--light);
            position: relative;
            overflow-x: hidden;
        }

        /* Futuristic Background Elements */
        .background-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(99, 102, 241, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99, 102, 241, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: -1;
            perspective: 1000px;
            transform-style: preserve-3d;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% { background-position: 0 0; }
            100% { background-position: 50px 50px; }
        }

        .floating-particles {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(99, 102, 241, 0.5);
            border-radius: 50%;
            animation: float 8s infinite;
        }

        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateY(-100vh) rotate(360deg); opacity: 0; }
        }

        /* Main Content Styling */
        .page-container {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 20px;
        }

        .form-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 3px;
        }

        .form-header h2 {
            font-size: 2.5em;
            margin-bottom: 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .form-container {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border-radius: 20px;
            z-index: -1;
            opacity: 0.3;
            filter: blur(20px);
        }

        .form-sections {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .form-section {
            background: rgba(255, 255, 255, 0.03);
            padding: 25px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: black;
        }

        .section-title {
            font-size: 1.2em;
            margin-bottom: 20px;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            display: block;
            width: 4px;
            height: 20px;
            background: var(--secondary);
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.9em;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: var(--light);
            font-size: 1em;
            color: black;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
            background: rgba(255, 255, 255, 0.1);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 20px;
            padding-right: 40px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn {
            flex: 1;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
            transition: 0.5s;
        }

        .btn:hover::before {
            transform: translateX(100%);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--light);
            backdrop-filter: blur(5px);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Validation Styles */
        .form-control:invalid {
            border-color: var(--danger);
        }

        .validation-message {
            position: absolute;
            bottom: -20px;
            left: 0;
            font-size: 0.8em;
            color: var(--danger);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-container {
                width: 95%;
                padding: 10px;
            }

            .form-container {
                padding: 20px;
            }

            .form-sections {
                grid-template-columns: 1fr;
            }

            .btn {
                padding: 10px 20px;
            }
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
            color: var(--gray);
            font-size: 1.2em;
            z-index: 10;
        }
    </style>
</head>
<body>

    <!-- Animated Background -->
    <div class="background-grid"></div>
    <div class="floating-particles">
        <?php for($i = 0; $i < 50; $i++): ?>
        <div class="particle" style="
            left: <?php echo htmlspecialchars(rand(0, 100)); ?>%;
            top: <?php echo htmlspecialchars(rand(0, 100)); ?>%;
            animation-delay: <?php echo htmlspecialchars(rand(0, 8000) / 1000); ?>s;
        "></div>
        <?php endfor; ?>
    </div>

    <div class="page-container">
        <div class="form-header">
            <h2>Edit User</h2>
            <p>Update user account with advanced controls</p>
        </div>

        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif ?>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif ?>
        
        <?php if (session()->getFlashdata('debug')) : ?>
            <div class="alert alert-warning"><?= session()->getFlashdata('debug'); ?></div>
        <?php endif ?>

        <div class="form-container">
        <form action="<?php echo base_url('user/update/'.$user['Username']); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="POST">
                <div class="form-sections">
                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <h3 class="section-title">Basic Information</h3>
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="Nama" class="form-control" value="<?= $user['Nama'] ?? '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input type="text" id="username" name="Username" class="form-control" value="<?= $user['Username'] ?? '' ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="Email" class="form-control" value="<?= $user['Email'] ?? '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="tel" name="Phone" class="form-control" value="<?= $user['Phone'] ?? '' ?>" 
                                   pattern="[0-9]{10,}"
                                   title="Please enter a valid phone number">
                        </div>
                    </div>

                    <!-- Access Control Section -->
                    <div class="form-section">
                        <h3 class="section-title">Access Control</h3>
                        <div class="form-group">
                            <label class="form-label">User Level</label>
                            <select name="Level" class="form-control" required>
                                <option value="manager" <?= ($user['Level'] ?? '') == 'manager' ? 'selected' : '' ?>>Manager</option>
                                <option value="sales" <?= ($user['Level'] ?? '') == 'sales' ? 'selected' : '' ?>>Sales</option>
                                <option value="admin" <?= ($user['Level'] ?? '') == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="user" <?= ($user['Level'] ?? '') == 'user' ? 'selected' : '' ?>>User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select name="Status" class="form-control" required>
                                <option value="active" <?= ($user['Status'] ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= ($user['Status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <div class="password-container">
                                <input type="password" id="password" name="Password" class="form-control" placeholder="Leave blank to keep current password">
                                <span class="toggle-password" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- System Configuration -->
                    <div class="form-section">
                        <h3 class="section-title">System Configuration</h3>
                        <div class="form-group">
                            <label class="form-label">Source</label>
                            <select name="Src" class="form-control" required>
                                <option value="AD" <?= ($user['Src'] ?? '') == 'AD' ? 'selected' : '' ?>>AD</option>
                                <option value="lokal" <?= ($user['Src'] ?? '') == 'lokal' ? 'selected' : '' ?>>Local</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Site Location</label>
                            <select name="Site" class="form-control" required>
                                <option value="ICON" <?= ($user['Site'] ?? '') == 'ICON' ? 'selected' : '' ?>>ICON</option>
                                <option value="lokal" <?= ($user['Site'] ?? '') == 'lokal' ? 'selected' : '' ?>>Local</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Direct</label>
                            <select name="Direct" class="form-control" required>
                                <option value="Pusat" <?= ($user['Direct'] ?? '') == 'Pusat' ? 'selected' : '' ?>>Pusat</option>
                                <option value="User" <?= ($user['Direct'] ?? '') == 'User' ? 'selected' : '' ?>>User</option>
                                <option value="pusat/dashboard/man" <?= ($user['Direct'] ?? '') == 'pusat/dashboard/man' ? 'selected' : '' ?>>Pusat/Dashboard/Management</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update User</button>
                    <a href="<?= base_url('user') ?>" class="btn btn-primary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Password toggle functionality
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle the eye icon
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        document.addEventListener("DOMContentLoaded", function() {
        const namaInput = document.querySelector("input[name='Nama']");
        const usernameInput = document.querySelector("input[name='Username']");

        namaInput.addEventListener("input", function() {
            let nama = namaInput.value.trim().toLowerCase();
            let kata = nama.split(/\s+/); // Pisahkan berdasarkan spasi

            if (kata.length >= 2) {
                let username = kata[0] + "." + kata[kata.length - 1];
                usernameInput.value = username; 
            } else {
                usernameInput.value = nama; // Jika hanya satu kata, tetap gunakan sebagai username
            }
        });
    });


        // Add floating particles dynamically
        const addParticles = () => {
            const particles = document.querySelector('.floating-particles');
            for(let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 8 + 's';
                particles.appendChild(particle);
            }
        };
        
        document.addEventListener('DOMContentLoaded', addParticles);
    </script>
</body>
</html>