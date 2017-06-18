<h1>Budget</h1>
<h2>
	Plan your monthly budget.
</h2>
<p>
	Your budget plan of <?php echo date('F, Y', mktime(0, 0, 0, $month, 1, $year)); ?>
</p>

<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Date</th>
			<th>Description</th>
			<th>Amount of money</th>
			<th>Category</th>
		</tr>
	</thead>
	<?php
		if (count($budget) > 0)
		{
			foreach ($budget as $entry) {
				echo "<tr>";
					echo "<td>";
					echo $entry['entry_Id'];
					echo "</td>";
					
					echo "<td>";
					echo $entry['date'];
					echo "</td>";

					echo "<td>";
					echo $entry['description'];
					echo "</td>";
					
					echo "<td>";
					echo $entry['amountOfMoney'];
					echo "</td>";
					
					echo "<td>";
					echo $entry['name'];
					echo "</td>";
				echo "</tr>";
			}
		}
		else
		{
			echo "No entry is entered this month";
		}
	?>
</table>

<form method="post">
	<fieldset>
		<legend>New entry</legend>
		<label>Date</label>
		<input type="date" name='date' size='9' value="<?php echo date("Y-m-d"); ?>" />
		<label>Amount of money</label>
		<input type="number" name='amountOfMoney' />
		<label>Description</label>
		<input type="text" name="description">
		<label>Category</label>
		<select name="category">
			<?php 
				foreach ($categories as $category)
				{
					echo "<option value=\"";
					echo $category['category_Id'];
					echo "\">";
					echo $category['name'];
					echo "</option>";
				}
			?>
		</select>
		<button type="submit" name="submit" value="newEntry">Save</button>
	</fieldset>
</form>