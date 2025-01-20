<table class="table" id="lookup-list">
	<thead>
		<tr>
			<th scope="col">No</th>
			<th scope="col">ID</th>
			<th scope="col">Description</th>
		</tr>
	</thead>
	<tbody>
		<?php

		include("connection_config.php");

		$table = $_POST['table'];
		$id = $_POST['id'];
		$name = $_POST['name'];
		$display_id = $_POST['display_id'];
		$display_name = $_POST['display_name'];
		$req_input = $_POST['req_input'];

		if (isset($_POST['req_label'])) {
			$req_label = $_POST['req_label'];
		}


		$sql = "Select * From $table order by $id asc";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		$count = 1;

		foreach ($results as $result) {

			$did = $result->$id;
			$dname = $result->$name;

		?>
			<tr>
				<td><?php echo $count ?></td>
				<?php

				if (isset($_POST['req_label'])) { ?>
					<td><a class="l_click" onclick="fill_lookup_data_two_col('<?php echo addslashes(htmlentities($req_input)) ?>','<?php echo addslashes(htmlentities($req_label)) ?>','<?php echo addslashes(htmlentities($did)) ?>','<?php echo addslashes(htmlentities($dname)) ?>')"><?php echo addslashes(htmlentities($did)); ?></a></td>

					<td><a class="l_click" onclick="fill_lookup_data_two_col('<?php echo addslashes(htmlentities($req_input)) ?>','<?php echo addslashes(htmlentities($req_label)) ?>','<?php echo addslashes(htmlentities($did)) ?>','<?php echo addslashes(htmlentities($dname)) ?>')"><?php echo addslashes(htmlentities($dname)); ?></a></td>

				<?php } else { ?>

					<td><a class="l_click" onclick="fill_lookup_data('<?php echo addslashes(htmlentities($req_input)) ?>','<?php echo addslashes(htmlentities($did)) ?>')"><?php echo addslashes(htmlentities($did)); ?></a></td>

					<td><a class="l_click" onclick="fill_lookup_data('<?php echo addslashes(htmlentities($req_input)) ?>','<?php echo addslashes(htmlentities($did)) ?>')"><?php echo addslashes(htmlentities($dname)); ?></a></td>

				<?php } ?>

			</tr>

		<?php

			$count =  $count + 1;
		} ?>

	</tbody>
</table>