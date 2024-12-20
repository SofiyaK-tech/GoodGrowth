<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <style>
        /* Add your existing styles here */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            display: flex;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #336;
            position: fixed;
            left: -250px; /* Hide sidebar by default */
            top: 0;
            padding: 20px;
            color: #fff;
            transition: left 0.3s ease;
            z-index: 2; 
        }

        .sidebar.show {
            left: 0; /* Show sidebar when the class is added */
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .sidebar-brand h2 {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }

        .sidebar-menu ul {
            list-style: none;
        }

        .sidebar-menu ul li {
            margin-bottom: 20px;
        }

        .sidebar-menu ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            display: flex;
            align-items: center;
        }

        .sidebar-menu ul li a:hover {
            background: #575757;
            padding: 10px;
            border-radius: 5px;
        }

        .main-content {
            margin-left: 0;
            width: 100%;
            padding: 20px;
            background: #f4f4f4;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
            
        }

        .main-content.shift {
            margin-left: 250px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-wrapper {
            display: flex;
            align-items: center;
        }

        .user-wrapper img {
            border-radius: 50%;
            margin-right: 10px;
        }

        .dashboard-cards {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }

        .card {
            background: #fff;
            padding: 20px;
            width: 30%;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
            border-radius: 8px;
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .card-link {
            color: #007bff;
            text-decoration: none;
        }

        .card-link:hover {
            text-decoration: underline;
        }

        /* Form Styles */
        .form-container {
            display: none;
        }

        .form-container.active {
            display: block;
        }

        .upload-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 1500px;
            width: 100%;
        }

        .welcome-container {
            text-align: center;
            margin: 50px 0;
        }

        .welcome-container h1 {
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
        }

        .welcome-container img {
            width: 60%;
            height: auto;
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #007bff;
        }

        .form-group textarea {
            height: 100px;
            resize: none;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .toggle-btn {
            cursor: pointer;
            font-size: 24px;
            color: #333;
            transition: color 0.3s ease;
        }

        .toggle-btn:hover {
            color: #007bff;
        }
        .welcome-container {
    text-align: center;
    margin: 50px 0;
    position: relative; /* Ensure it's positioned correctly */
    z-index: 1; /* Make sure it’s above other elements */
}

.welcome-container h1 {
    font-size: 36px;
    color: #333;
    margin-bottom: 20px;
}

.welcome-container img {
    width: 60%;
    height: auto;
    border-radius: 8px;
}
.table-container {
    width: 100%;
    overflow-x: auto; /* Ensure responsiveness */
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

table th,
table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #336;
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
}

table tr {
    transition: background-color 0.3s ease;
}

table tr:nth-child(even) {
    background-color: #f4f4f4;
}

table tr:hover {
    background-color: #f1f1f1;
}

table td {
    font-size: 14px;
    color: #333;
}

.table-container h2 {
    margin-bottom: 15px;
    font-size: 24px;
    color: #333;
    font-weight: bold;
}

@media (max-width: 768px) {
    table th, table td {
        padding: 10px;
        font-size: 12px;
    }
}
.logout-btn {
    background-color: #ff4d4d;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.logout-btn:hover {
    background-color: #ff3333;
}

.logout-btn:focus {
    outline: none;
}
.project-cards-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-around;
    margin-top: 20px;
}
.project-card {
    background: #fff;
    padding: 20px;
    width: 30%;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    text-align: center;
    border-radius: 8px;
    margin: 10px;
    display: inline-block; /* Make them appear side by side */
}

.project-card img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 10px;
}

.project-card h3 {
    margin-bottom: 10px;
    font-size: 20px;
    color: #333;
}

.project-card p {
    font-size: 14px;
    color: #555;
}

.project-card p strong {
    color: #333;
}
@media (max-width: 768px) {
    .project-card {
        width: 100%;
    }
}
.reply-btn {
    color: blue;
    text-decoration: underline;
    cursor: pointer;
}

.reply-btn:hover {
    color: darkblue;
}
    </style>
</head>
<body>
    <input type="checkbox" id="nav-toggle">

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h2><span class="lab la-laptop"></span><span>Admin</span></h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="#" id="investor-details"><span class="las la-users"></span>
                    <span>Investor Details</span></a>
                </li>
                <li>
                    <a href="#" id="project-builder-details"><span class="las la-cogs"></span>
                    <span>ProjectBuilder Details</span></a>
                </li>
                <li>
                    <a href="#" id="project-details"><span class="las la-clipboard-list"></span>
                    <span>Project Details</span></a>
                </li>
                <li>
                    <a href="#" id="transaction-details"><span class="las la-money-check-alt"></span>
                    <span>Transaction Details</span></a>
                </li>
                <li>
                    <a href="#" id="contact-us-details"><span class="las la-envelope"></span>
                    <span>Help Center Details</span></a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <header>
            <h2>
                <span class="toggle-btn" id="toggle-btn">&#9776;</span>
                Dashboard
            </h2>
            <div class="user-wrapper">
                <img src="pngtree-avatar-icon-profile-icon-member-login-vector-isolated-png-image_1978396.jpg" width="40px" height="40px" alt="">
                <div>
                    <button id="logout-btn" class="logout-btn">Logout</button>
                </div>
            </div>
        </header>

        <!-- Dashboard Section -->
        <main>
            <div id="dynamic-content">
                <div class="welcome-container" id="welcome-container">
                    <h1>Welcome, Admin!</h1>
                    <img src="oli-dale-xjSkI_seiZY-unsplash.jpg" alt="Welcome Image">
                </div>

                <!-- Existing form containers -->
                <div class="form-container" id="investor-details-form">
                    <h2>Investor Details</h2>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                <th>Investor ID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>Aadhar Card</th>
                <th>Pan Card</th>
                <th>Domicile</th>
                <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include 'fetchInvestorDetails.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-container" id="project-builder-details-form">
                    <h2>ProjectBuilder Details</h2>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Builder ID</th>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>Aadhar Card</th>
                <th>Pan Card</th>
                <th>Domicile</th>
                <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include 'fetchProjectBuilderDetails.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-container" id="project-details-form">
                    <h2>Project Details</h2>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Project ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Fund</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Builder Name</th>
                                    <th>Email</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php include 'fetchProjectDetails.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-container" id="transaction-details-form">
                    <h2>Transaction Details</h2>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Investor ID</th>
                                    <th>Investor Name</th>
                                    <th>Project Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Amount</th>
                                    <th>Platform</th>
                                    <th>Screenshot</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php include 'fetchTransactionDetails.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-container" id="contact-us-details-form">
                    <h2>Help Center Details</h2>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Help Center ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include 'fetchContactUsDetails.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('toggle-btn').addEventListener('click', function() {
            var sidebar = document.getElementById('sidebar');
            var mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('show');
            mainContent.classList.toggle('shift');
        });

        function showContent(id) {
            var contents = document.querySelectorAll('.form-container');
            var welcomeContainer = document.getElementById('welcome-container');

            // Hide all form containers
            contents.forEach(function(content) {
                content.classList.remove('active');
            });

            // Hide the welcome container once a menu is clicked
            if (welcomeContainer) {
                welcomeContainer.style.display = 'none';
            }

            // Show the clicked form
            document.getElementById(id).classList.add('active');
        }

        // Event listeners for sidebar menu items
        document.getElementById('investor-details').addEventListener('click', function() {
            showContent('investor-details-form');
        });

        document.getElementById('project-builder-details').addEventListener('click', function() {
            showContent('project-builder-details-form');
        });

        document.getElementById('project-details').addEventListener('click', function() {
            showContent('project-details-form');
        });

        document.getElementById('transaction-details').addEventListener('click', function() {
            showContent('transaction-details-form');
        });

        document.getElementById('contact-us-details').addEventListener('click', function() {
            showContent('contact-us-details-form');
        });

        document.getElementById('logout-btn').addEventListener('click', function() {
            // Replace this with your actual logout logic
            window.location.href = 'Front.html';  // Redirect to the login page or perform logout
        });
    </script>
</body>
</html>
