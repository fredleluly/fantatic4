<div class="sidebar">
    <div class="logo">
        <h2>IT Support PLN</h2>
    </div>
    
    <!-- User Profile Section -->
    <div class="user-info">
        <div class="profile-icon">
            <i class="fas fa-user-circle"></i>
        </div>
        <div class="user-details">
        
            <span><?= session()->get('Username') ?? 'Guest' ?></span>
        </div>
    </div>

    <nav>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">
                        <i class="fas fa-tachometer-alt fa-fw"></i> Dashboard
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?= base_url('timsupport') ?>" class="nav-link">
                        <i class="fas fa-headset fa-fw"></i> Team
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?= base_url('logout') ?>" class="nav-link">
                        <i class="fas fa-sign-out-alt fa-fw"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
</div>

<style>
    :root {
            --primary-color: #60a5fa;
            --primary-hover: rgba(96, 165, 250, 0.3);
            --primary-light: rgba(96, 165, 250, 0.2);
            --secondary-color: #34d399;
            --dark-bg: #0f172a;
            --dark-bg-alt: #1e293b;
            --sidebar-bg: #2c3e50;
            --border-light: rgba(255, 255, 255, 0.1);
            --card-bg: rgba(255, 255, 255, 0.03);
            --card-border: rgba(255, 255, 255, 0.05);
            --sidebar-width: 280px;
        }
     

            .sidebar.active {
                transform: translateX(0);
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            }

            .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            padding: 2rem 1.5rem;
            position: fixed;
            height: 100vh;
            z-index: 10;
            overflow-y: auto;
            transition: transform 0.3s ease;
            border-right: 1px solid var(--border-light);
        }


/* .sidebar {
    width: 250px;
    height: 100vh;
    background: #2c3e50;
    color: #fff;
    padding: 20px;
} */

.logo {
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.logo h2 {
    margin: 0;
    font-size: 20px;
    text-align: center;
}

.user-info {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.profile-icon {
    margin-right: 10px;
}

.profile-icon i {
    font-size: 24px;
    color: #fff;
}

.user-details span {
    font-size: 14px;
}

.nav-menu {
    list-style: none;
    padding: 0;
    margin: 20px 0;
}

.nav-item {
    margin: 8px 0;
}

.nav-link {
    display: block;
    padding: 10px;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.nav-link:hover {
    background: rgba(255,255,255,0.1);
}
</style>