<?php
session_start();
if (!isset($_SESSION['investorId'])) {
    header('Location: investorlogin.php'); // Redirect if investorId is not set
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investor Dashboard</title>
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

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #333;
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
    background-color: #333;
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
.search-container {
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
}

#search-category {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 70%; /* Adjust width as needed */
    margin-right: 10px;
}

#search-btn {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

#search-btn:hover {
    background-color: #0056b3;
}
.invest-btn {
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    margin-top: 10px;
}

.invest-btn:hover {
    background-color: #0056b3;
}
.notifications-container {
    display: flex;
    flex-wrap: wrap; /* Allows the cards to wrap on smaller screens */
    gap: 20px; /* Space between cards */
    padding: 10px; /* Padding around the container */
}

.notification-card {
    background-color: #ead0d0; /* Card background color */
    border-radius: 8px; /* Rounded corners */
    padding: 15px; /* Padding inside the card */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Shadow for a lifted effect */
    flex: 1 1 300px; /* Allows cards to grow and shrink */
    min-width: 700px; /* Minimum width for each card */
    transition: transform 0.3s; /* Smooth hover effect */
}

.notification-card:hover {
    transform: scale(1.05); /* Scale effect on hover */
}

.notification-card h3 {
    margin: 0; /* Remove margin */
    font-size: 1.2em; /* Title font size */
}

.notification-card p {
    margin: 5px 0 0; /* Add margin above */
    font-size: 1em; /* Body font size */
}

    </style>
</head>
<body>
    <input type="checkbox" id="nav-toggle">

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h2><span class="lab la-laptop"></span><span>Investor</span></h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="#" id="transactions"><span class="las la-exchange-alt"></span>
                    <span>Transactions</span></a>
                </li>
                <li>
                    <a href="#" id="invested-history"><span class="las la-history"></span>
                    <span>Invested History</span></a>
                </li>
                <li>
                    <a href="#" id="project-history"><span class="las la-project-diagram"></span>
                    <span>Project History</span></a>
                </li>
                <li>
                    <a href="#" id="contact"><span class="las la-phone-volume"></span>
                    <span>Help Center Information</span></a>
                </li>
                <li>
                    <a href="#" id="notif"><span class="las la-exclamation"></span>
                    <span>Notifications</span></a>
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
                    <h1>Welcome, Investor!</h1>
                    <img src="10808.jpg" alt="Welcome Image">
                </div>

                <!-- Existing form containers -->
                <div class="form-container" id="project-history-form">
    <h2>Projects</h2>
    <div class="search-container">
        <input type="text" id="search-category" placeholder="Search by category..." />
        <button id="search-btn">Search</button>
    </div>
    <div class="project-cards-container" id="project-cards">
        <?php include 'fetchProjectInvestor.php'; ?>
    </div>
</div>

                <div class="form-container" id="transactions-form">
                    <h2>Transactions</h2>
                    

<div class="table-container">
        <h2>Transaction History</h2>
        <table>
            <thead>
                <tr>
                    <th>History ID</th>
                    <th>Project Name</th>
                    <th>Amount</th>
                    <th>Platform</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'fetchTransactionHistory.php'; ?>
            </tbody>
        </table>
    </div>
</div>
 </div>
                <div class="form-container" id="invested-history-form">
                <h2>Invested History</h2>
<!-- Table Section -->
    <div class="table-container">
        <h2>Investment History</h2>
        <table>
            <thead>
                <tr>
                    <th>History ID</th>
                    <th>Project Name</th>
                    <th>Date</th>
                    <th>Money Invested</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'fetchInvestedHistory.php'; ?>
            </tbody>
        </table>
    </div>
</div>
    <!-- Contact Information Section -->
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
                                <?php include 'fetchContactHistory.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-container" id="notif-form">
                    <h2>Updates</h2>
                    <div class="notifications-container" id="notifications-container">
        <?php include 'fetchProjectStatus.php'; ?>
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
        document.getElementById('transactions').addEventListener('click', function() {
            showContent('transactions-form');
        });

        document.getElementById('invested-history').addEventListener('click', function() {
            showContent('invested-history-form');
        });

        document.getElementById('project-history').addEventListener('click', function() {
            showContent('project-history-form');
        });
        document.getElementById('contact').addEventListener('click', function() {
            showContent('contact-history-form');
        });
        document.getElementById('notif').addEventListener('click', function() {
            showContent('notif-form');
        });

        document.getElementById('logout-btn').addEventListener('click', function() {
    window.location.href = 'Front.html';  // Redirect to the logout script
});
        document.getElementById('search-btn').addEventListener('click', function() {
        var category = document.getElementById('search-category').value;
        var projectCards = document.getElementById('project-cards');

        // Fetch filtered projects
        fetch('fetchProjectInvestor.php?category=' + encodeURIComponent(category))
            .then(response => response.text())
            .then(data => {
                projectCards.innerHTML = data; // Update the project cards container
            })
            .catch(error => console.error('Error fetching projects:', error));
    });
    </script>
</body>
</html>
