<?php
    include "./config.php"; // Database connection

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $affiliationId = $_POST['affiliation'];
        $academicyear = $_POST['academic-year'];
        $universityoptions = $_POST['university-options'];

        $fileName = $_POST['file-name'];
        $fileLocation = $_POST['file-location'];

        // 🔹 File Upload Logic
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $file = $_FILES['file-upload'];
        $targetFile = $targetDir . basename($file['name']);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file is a valid type (optional)
        $allowedTypes = ['pdf'];
        if (!in_array($fileType, $allowedTypes)) {
            echo json_encode(["status" => "error", "message" => "File type not allowed"]);
            exit;
        }

        if (!is_uploaded_file($file["tmp_name"])) {
            echo json_encode(["status" => "error", "message" => "Temporary file is missing or not a valid upload"]);
            exit;
        }

        if (!is_writable($targetDir)) {
            echo json_encode(["status" => "error", "message" => "Uploads directory is not writable"]);
            exit;
        }
        
        // Check if file was uploaded successfully
        if (!is_uploaded_file($file["tmp_name"])) {
            echo json_encode(["status" => "error", "message" => "Temporary file is missing or invalid"]);
            exit;
        }
        
        // Debugging Info
        error_log("Temp File: " . $file["tmp_name"]);
        error_log("Target File: " . $targetFile);
        error_log("File Type: " . $fileType);
        error_log("File Size: " . $file["size"]);

        // Move uploaded file to target directory
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {

            // 🔹 Insert into Database
            $stmt = $conn->prepare("
                INSERT INTO documents (affiliation_id, academic_year_id, university_option_id, file_name, office_location, file_path) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$affiliationId, $academicyear, $universityoptions, $fileName, $fileLocation, $targetFile]);
    
            echo json_encode(["status" => "success", "message" => "File uploaded successfully"]);
        } else {
            // echo json_encode(["status" => "error", "message" => "Error uploading file"]);
            $error = error_get_last();
            echo json_encode([
                "status" => "error", 
                "message" => "Error uploading file", 
                "details" => $error
            ]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid request"]);
    }
    

    // Handle File Upload
    // $targetDir = "./uploads/";
    // $targetFile = $targetDir . basename($_FILES["file-upload"]["name"]);
    // move_uploaded_file($_FILES["file-upload"]["tmp_name"], $targetFile);

    // $query = "INSERT INTO documents (affiliation_id, file_name, file_path, office_location, academic_year_id, university_option_id)
    //         VALUES (:affiliation_id, :file_name, :file_path, :office_location, :academicyear, :universityoptions)";

    // $stmt = $conn->prepare($query);
    // $stmt->execute([
    //     ':affiliation_id' => $affiliationId,
    //     ':file_name' => $fileName,
    //     ':file_path' => $targetFile,
    //     ':academicyear' => $academicyear,
    //     ':universityoptions' => $universityoptions,
    //     ':office_location' => $fileLocation
    // ]);

    // echo "File successfully added!";

    // new

    // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //     $affiliation = $_POST['affiliation'];
    //     $academicYear = $_POST['academic-year'];
    //     $universityOptions = $_POST['university-options'];
    //     $fileName = $_POST['file-name'];
    //     $fileLocation = $_POST['file-location'];
    
    //     // 🔹 File Upload Logic
    //     $targetDir = "../uploads/";
    //     $file = $_FILES['file-upload'];
    //     $targetFile = $targetDir . basename($file['name']);
    //     $uploadOk = 1;
    //     $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    //     // Check if file is a valid type (optional)
    //     $allowedTypes = ['pdf', 'doc', 'docx', 'jpg', 'png'];
    //     if (!in_array($fileType, $allowedTypes)) {
    //         echo json_encode(["status" => "error", "message" => "File type not allowed"]);
    //         exit;
    //     }
    
    //     // Move uploaded file to target directory
    //     if (move_uploaded_file($file["tmp_name"], $targetFile)) {
    //         // 🔹 Insert into Database
    //         $stmt = $pdo->prepare("
    //             INSERT INTO documents (affiliation, academic_year, university_option, file_name, file_location, file_path) 
    //             VALUES (?, ?, ?, ?, ?, ?)
    //         ");
    //         $stmt->execute([$affiliation, $academicYear, $universityOptions, $fileName, $fileLocation, $targetFile]);
    
    //         echo json_encode(["status" => "success", "message" => "File uploaded successfully"]);
    //     } else {
    //         echo json_encode(["status" => "error", "message" => "Error uploading file"]);
    //     }
    // } else {
    //     echo json_encode(["status" => "error", "message" => "Invalid request"]);
    // }
    
?>


