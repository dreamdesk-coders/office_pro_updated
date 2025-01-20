<table class="table table-striped" id="user-list">
	<thead>
		<tr>
			<th scope="col">No</th>
			<th scope="col">Login ID</th>
			<th scope="col">Office ID</th>
			<th scope="col">Login Role</th>
			<th scope="col">Edit</th>
			<th scope="col">Delete</th>
		</tr>
	</thead>
	<tbody>
		<?php

		include("../../common/connection_config.php");
		$sql = "Select * From app_user order by created_date desc";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		$count = 1;

		foreach ($results as $result) {

			$login_id = $result->login_id;
			$office_id = $result->office_id;
			$login_role = $result->login_role;


		?>
			<tr>
				<td><?php echo $count ?></td>
				<td><?php echo htmlentities($login_id); ?></td>
				<td><?php echo htmlentities($office_id); ?></td>
				<td><?php echo htmlentities($login_role); ?></td>
				<td><button class="btn btn-primary" onclick="update_datafill('<?php echo addslashes(htmlentities($login_id)) ?>','<?php echo addslashes(htmlentities($office_id)) ?>','<?php echo addslashes(htmlentities($login_role)) ?>')">Edit</button></td>
				<td><button class="btn btn-danger" onclick="delete_user('<?php echo addslashes(htmlentities($login_id)) ?>')">Delete</button></td>
			</tr>

		<?php

			$count =  $count + 1;
		} ?>


	</tbody>
</table>