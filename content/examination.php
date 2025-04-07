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
            <li class="breadcrumb-item"><a href="#"class="breadcrumb-link" data-page="academics.php">Academics</a></li>
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
                <option value="others">Others</option>
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

        if (assessment === 'internal') {
            ['CA1','CA2','CA3','CA4','PCA1','PCA2'].forEach(comp => {
                $comp.append(`<option value="${comp}">${comp}</option>`);
            });
        } else if (assessment === 'endsem') {
            $comp.append(`<option value="Semester Result">Semester Result</option>`);
        } else if (assessment === 'others') {
            $comp.append(`<option value="Other Assessment">Other Assessment</option>`);
        }

        $('#component-container').show();
        $('#load-result').prop('disabled', false);
    });

    $('#load-result').click(function () {
        let data = {
            year: $('#academic-year').val(),
            semester: $('#semester').val(),
            assessment: $('#assessment').val(),
            component: $('#component').val()
        };

        if (!data.year || !data.semester || !data.assessment || !data.component) {
            alert("Please fill in all fields.");
            return;
        }

        $.post('backend/fetch_examination_results.php', data, function (html) {
            $('#result-box').html(html);
        });
    });
});
</script>
