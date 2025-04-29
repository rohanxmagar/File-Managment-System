<?php
include "../backend/config.php"; // Database connection file

try {
    $stmt = $conn->prepare("SELECT id, examination_name FROM examination_data");
    $stmt->execute();
    $examinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<div class="container">
    <!-- Breadcrumbs Section -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" id="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link" data-page="academics.php">Academics</a></li>
            <li class="breadcrumb-item">Examination</li>
        </ol>
    </nav>
<div class="container mt-4">
    <h4>Examination</h4>
    <p>Select academic year, semester, and assessment to view results.</p>

    <div class="row g-3">
        <!-- Academic Year -->
        <div class="col-md-4">
            <label>Academic Year</label>
            <select id="academic-year" class="form-select">
                <option value="">Select Academic Year</option>
                <?php
                $stmt = $conn->query("SELECT year FROM academic_years ORDER BY year DESC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['year']}'>{$row['year']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Semester -->
        <div class="col-md-4">
            <label>Semester Type</label>
            <select id="semester" class="form-select">
                <option value="">Select Semester</option>
                <option value="odd">Odd Semester</option>
                <option value="even">Even Semester</option>
            </select>
        </div>

        <!-- Assessment Type -->
        <div class="col-md-4">
            <label>Assessment Type</label>
            <select id="assessment" class="form-select">
                <option value="">Select Assessment</option>
                <option value="internal">Internal Assessment</option>
                <option value="endsem">End Semester</option>
                <option value="enrollment">Enrollment</option>
                <option value="results">Results</option>
            </select>
        </div>

        <!-- End Sem Type -->
        <div class="col-md-4" id="endsem-type-container" style="display: none;">
            <label>End Sem Type</label>
            <select id="endsem-type" class="form-select">
                <option value="">Select Type</option>
                <option value="theory">Theory</option>
                <option value="examform">Exam Form Fill-up</option>
                <option value="practical">Practical</option>
            </select>
        </div>

        <!-- Enrollment Type -->
        <div class="col-md-4" id="enrollment-type-container" style="display: none;">
            <label>Enrollment Type</label>
            <select id="enrollment-type" class="form-select">
                <option value="">Select Enrollment</option>
                <option value="regular">Regular</option>
                <option value="backlog">Backlog</option>
            </select>
        </div>

        <!-- Component -->
        <div class="col-md-4" id="component-container" style="display: none;">
            <label>Component</label>
            <select id="component" class="form-select">
                <option value="">Select Component</option>
            </select>
        </div>

        <!-- Submit -->
        <div class="col-md-12 mt-3">
            <button class="btn btn-primary" id="load-result" disabled>View Results</button>
        </div>
    </div>

    <!-- Results -->
    <div id="result-box" class="mt-4"></div>
</div>

<script>
$(document).ready(function () {
    $('#assessment').change(function () {
        let assessment = $(this).val();
        let $comp = $('#component');
        $comp.empty();
        $('#component-container').hide();
        $('#endsem-type-container').hide();
        $('#enrollment-type-container').hide();
        $('#load-result').prop('disabled', true);

        if (assessment === 'internal') {
            ['CA1','CA2','CA3','CA4','PCA1','PCA2'].forEach(comp => {
                $comp.append(`<option value="${comp}">${comp}</option>`);
            });
            $('#component-container').show();
            $('#load-result').prop('disabled', false);
        } else if (assessment === 'endsem') {
            $('#endsem-type-container').show();
        } else if (assessment === 'enrollment') {
            $('#enrollment-type-container').show();
            $('#load-result').prop('disabled', false);
        } else if (assessment === 'results') {
            $comp.append(`<option value="Other Assessment">Other Assessment</option>`);
            $('#component-container').show();
            $('#load-result').prop('disabled', false);
        }
    });

    $('#endsem-type').change(function () {
        const type = $(this).val();
        const $comp = $('#component');
        $comp.empty();

        if (type === 'theory') {
            ['Routine', 'Seating Arrangement', 'Attendance'].forEach(c => {
                $comp.append(`<option value="${c}">${c}</option>`);
            });
        } else if (type === 'practical') {
            ['Routine', 'Attendance'].forEach(c => {
                $comp.append(`<option value="${c}">${c}</option>`);
            });
        } else if (type === 'examform') {
            $comp.append(`<option value="Exam Form">Exam Form</option>`);
        }

        $('#component-container').show();
        $('#load-result').prop('disabled', false);
    });

    $('#load-result').click(function () {
        let data = {
            year: $('#academic-year').val(),
            semester: $('#semester').val(),
            assessment: $('#assessment').val(),
            endsem_type: $('#endsem-type').val(),
            enrollment_type: $('#enrollment-type').val(),
            component: $('#component').val()
        };

        if (!data.year || !data.semester || !data.assessment || 
            (data.assessment === 'endsem' && !data.endsem_type) ||
            (data.assessment === 'enrollment' && !data.enrollment_type)) {
            alert("Please fill in all fields.");
            return;
        }

        $.post('backend/fetch_examination_results.php', data, function (html) {
            $('#result-box').html(html);
        });
    });
});
</script>
