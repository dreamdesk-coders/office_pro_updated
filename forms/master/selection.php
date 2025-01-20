<?php 

$sql_foundation = "Select * From foundation order by client_id desc";
$query_foundation = $dbh_master -> prepare($sql_foundation);
$query_foundation->execute();
$foundation_results=$query_foundation->fetchAll(PDO::FETCH_OBJ);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 d-flex justify-content-center align-content-center align-items-center" style="height:100vh;">
            <div class="card w-100 p-4" style="height: 500px; overflow: hidden; overflow-y: auto; border: 0.5px solid #eeeeee; border-radius:15px;">
                <h5 class="text-center mb-2 pb-2">
                    <img src="favicon.ico" alt="Office Pro" style="width: 35px; display: inline;"> Company Selection
                </h5>
                
                <!-- Search Input -->
                <div class="mb-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search by record name">
                </div>
                
                <table class="table" id="recordTable">
                    <thead>
                        <tr>
                            <td>Record Name</td>
                            <td>Start Date</td>
                            <td>End Date</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($foundation_results as $foundation_result){ ?>
                        <tr>
                            <td>
                                <a href="?frm=dashboard" onmouseover="select('<?php echo $foundation_result->db_name; ?>', '<?php echo date('Y-m-d') ?>', '<?php echo $foundation_result->yearend_date; ?>');" onclick="select('<?php echo $foundation_result->db_name; ?>', '<?php echo date('Y-m-d') ?>', '<?php echo $foundation_result->yearend_date; ?>');">
                                    <?php echo $foundation_result->client_name; ?>
                                </a>
                            </td>
                            <td><?php echo $foundation_result->sub_start_date; ?></td>
                            <td><?php echo $foundation_result->sub_end_date; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <!-- <a href="?frm=login" class="btn btn-outline-primary w-25">Back to login</a> -->
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<script>
    // JavaScript for filtering the table
    document.getElementById('searchInput').addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#recordTable tbody tr');

        rows.forEach(row => {
            const recordName = row.querySelector('td:first-child').textContent.toLowerCase();
            if (recordName.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    function select(db, date, yd) {
        var database = db;
        set_cookie('app_db', database);

        if (Date.parse(date) > Date.parse(yd)) {
            localStorage.setItem("disable_save", "1");
        } else {
            localStorage.setItem("disable_save", "0");
        }
    }
</script>
