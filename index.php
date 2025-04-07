<?php
    // include "./backend/session_verification.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> 
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
</head>
<body> 
        </nav>
    <div class="d-flex">
        <div class="sidebar p-3 text-white" style="background-color: #2E368F; width: 250px; min-height: 100vh;">
           <h3> <a href="index.php" class="text-center">Dashboard </a></h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="#" class="nav-link text-white menu-item" data-page="students">
                        <i class="fas fa-user-graduate"></i>Registration
                    </a>
                </li>
                <li class="nav-item">
                    <a href="academics.php" class="nav-link text-white menu-item" data-page="academics">
                        <i class="fas fa-book-open"></i> Academics
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white menu-item" data-page="institution">
                        <i class="fas fa-university"></i> Records
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./backend/logout.php" class="nav-link text-white">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <div class="content flex-grow-1 p-4">
            
            <div class="container" id="main-content">
                <div class="top-nav p-3 mb-3 text-center text-black" style="background-color: #FDD306; font-weight: bold;">
            <div class="nav-buttons">
                <button class="btn upload-btn"><i class="fas fa-upload"></i> Upload File</button>
                <button class="btn"><i class="fas fa-folder"></i> My Files</button>
                <button class="btn"><i class="fas fa-share"></i> Shared Files</button>
        </nav>
        </div>
        
    </div>
    <main class="main-content">
            <section class="recent-files">
                <h3>Recent Files</h3>
                
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Date</th>
                            <th>Uploaded By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Exam Schedule.pdf</td>
                            <td>1.2MB</td>
                            <td>March 25, 2025</td>
                            <td>Admin</td>
                            <td><button class="btn">Download</button></td>
                        </tr>
                        <tr>
                            <td>Student Attendance.xlsx</td>
                            <td>850KB</td>
                            <td>March 20, 2025</td>
                            <td>Faculty</td>
                            <td><button class="btn">Download</button></td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <script src="./script/main.js"></script>

</body>
</html>
