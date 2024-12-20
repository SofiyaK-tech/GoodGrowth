<?php
session_start();

// Check if the user is logged in by checking if the 'Email' session is set
if (!isset($_SESSION['Email'])) {
    header("Location: projectbuilderlogin.php"); // Redirect to login page if not logged in
    exit();
}

// Retrieve the logged-in user's email
$email = $_SESSION['Email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Builder Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <style>
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

        /* Sidebar styles */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #333;
            position: fixed;
            left: -250px; /* Hidden by default */
            top: 0;
            padding: 20px;
            color: #fff;
            transition: left 0.3s ease;
        }

        .sidebar.show {
            left: 0; /* Sidebar will be visible when this class is applied */
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

        /* Main content styles */
        .main-content {
            margin-left: 0;
            width: 100%;
            padding: 20px;
            background: #f4f4f4;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content.shift {
            margin-left: 250px; /* Shifts content when the sidebar is visible */
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

        /* Form styles */
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
            max-width: 500px;
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

        /* Sidebar toggle button */
        .toggle-btn {
            cursor: pointer;
            font-size: 24px;
            color: #333;
            transition: color 0.3s ease;
        }

        .toggle-btn:hover {
            color: #007bff;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
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
            background-color: #333;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
        }

        table tr:nth-child(even) {
            background-color: #f4f4f4;
        }

        table tr:hover {
            background-color: #f1f1f1;
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
    </style>
</head>
<body>
    <input type="checkbox" id="nav-toggle">

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h2><span class="lab la-laptop"></span><span>Project Builder</span></h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="#" id="upload-project"><span class="las la-upload"></span>
                    <span>Upload Project</span></a>
                </li>
                <li>
                    <a href="#" id="project-history"><span class="las la-history"></span>
                    <span>Project History</span></a>
                </li>
                <li>
                    <a href="#" id="investor-details"><span class="las la-users"></span>
                    <span>Investor Details</span></a>
                </li>
                <li>
                    <a href="#" id="contact"><span class="las la-phone-volume"></span>
                    <span>Help Center Information</span></a>
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
                    <h1>Welcome, Builder!</h1>
                    <img src="4207.jpg" alt="Welcome Image">
                </div>

                <!-- Existing form containers -->
                <div class="form-container" id="upload-project-form">
                    <h2>Upload Project</h2>
                    
                    <form action="uploadprojectconnection.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="FullName">Full Name:</label>
                            <input type="text" id="FullName" name="FullName" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="Email">Email:</label>
                            <input type="Email" id="Email" name="Email" required>
                        </div>
                
                        <div class="form-group">
                            <label for="project-name">Project Name:</label>
                            <input type="text" id="project-name" name="project_name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea id="description" name="description" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="category">Category:</label>
                            <select id="category" name="category" required>
                                <option value="" disabled selected>Select a category</option>
                                <option value="Technology">Technology</option>
                                <option value="Health">Health</option>
                                <option value="Education">Education</option>
                                <option value="Art">Art</option>
                                <option value="Environment">Environment</option>
                                <option value="Social cause">Social Cause</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select id="status" name="status" required>
                                <option value="" disabled selected>Select status</option>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Completed">Completed</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                
                        <div class="form-group">
                            <label for="date">Date:</label>
                            <input type="date" id="date" name="date" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="funds">Funds Money (in INR):</label>
                            <input type="number" id="funds" name="funds_money" required>
                        </div>
                        <div class="form-group">
            <label for="project-image">Project Image:</label>
            <input type="file" id="project-image" name="PhotoImg" accept="image/*" required>
        </div>
                        <div class="form-group">
                            <button type="submit">Submit Project</button>
                        </div>
                    
                    </form>
                </div>
                
                <div class="form-container" id="project-history-form">
                    <h2>Project History</h2>
                    <div class="table-container">
                        <?php include 'fetch_project_history.php'; ?>
                    </div>
                </div>
                
                <div class="form-container" id="investor-details-form">
                    <h2>Investor Details</h2>
                    <div class="table-container">
                        <?php include 'fetch_investor_history.php'; ?>
                    </div>
                </div>
                <div class="form-container" id="contact-history-form">
                    <h2>Help Center Information</h2>
                    <div class="table-container">
                        <h2>Help Center History</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Help Center ID</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include 'fetchContactHistoryBuilder.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // JavaScript for handling sidebar toggle
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            mainContent.classList.toggle('shift');
        });

        // Handle form and content toggling
        document.getElementById('upload-project').addEventListener('click', function () {
            document.getElementById('welcome-container').style.display = 'none';
            document.getElementById('upload-project-form').style.display = 'block';
            document.getElementById('project-history-form').style.display = 'none';
            document.getElementById('investor-details-form').style.display = 'none';
            document.getElementById('contact-history-form').style.display = 'none';
        });

        document.getElementById('project-history').addEventListener('click', function () {
            document.getElementById('welcome-container').style.display = 'none';
            document.getElementById('upload-project-form').style.display = 'none';
            document.getElementById('project-history-form').style.display = 'block';
            document.getElementById('investor-details-form').style.display = 'none';
            document.getElementById('contact-history-form').style.display = 'none';
        });

        document.getElementById('investor-details').addEventListener('click', function () {
            document.getElementById('welcome-container').style.display = 'none';
            document.getElementById('upload-project-form').style.display = 'none';
            document.getElementById('project-history-form').style.display = 'none';
            document.getElementById('investor-details-form').style.display = 'block';
            document.getElementById('contact-history-form').style.display = 'none';
        });
        document.getElementById('contact').addEventListener('click', function () {
            document.getElementById('welcome-container').style.display = 'none';
            document.getElementById('upload-project-form').style.display = 'none';
            document.getElementById('project-history-form').style.display = 'none';
            document.getElementById('investor-details-form').style.display = 'none';
            document.getElementById('contact-history-form').style.display = 'block';
        });

        // Show welcome container by default
        document.getElementById('welcome-container').style.display = 'block';

        // Logout functionality
        document.getElementById('logout-btn').addEventListener('click', function () {
            window.location.href = 'Front.html';
        });
    </script>
</body>
</html>
