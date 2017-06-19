<?php 
	include 'shared/header.html.php';
?>
	<h1>Budget</h1>
	<h2>
		Plan your monthly budget.
	</h2>
	<p>
		Your budget plan of <?php echo date('F, Y', mktime(0, 0, 0, $month, 1, $year)); ?>
	</p>
	
	<form method="post">
	<table>
		<thead>
			<tr>
				<th style="width: 10%;">Date</th>
				<th style="width: 40%;">Description</th>
				<th style="width: 20%;">Amount of money</th>
				<th style="width: 20%;">Category</th>
				<th style="width: 10%;"></th>
			</tr>
		</thead>
		<?php
			if (count($budget) > 0)
			{
				foreach ($budget as $entry) {
					echo "<tr>";					
						echo "<td>";
						echo $entry['date'];
						echo "</td>";
	
						echo "<td>";
						echo $entry['description'];
						echo "</td>";
						
						echo "<td style=\"text-align:right\">";
						echo $entry['amountOfMoney'];
						echo "</td>";
						
						echo "<td>";
						echo $entry['name'];
						echo "</td>";
						
						echo "<td>";
						echo "<label class=\"submit-label\" for=\"edit-submit-"; echo $entry['entry_Id']; echo "\"><i class=\"fa fa-pencil\"></i></label>";
						echo "<input id=\"edit-submit-"; echo $entry['entry_Id']; echo "\" style=\"display:none;\" type=\"submit\" value=\"edit-"; echo $entry['entry_Id']; echo "\" name=\"submit\" />";
						echo "<label class=\"submit-label\" for=\"delete-submit-"; echo $entry['entry_Id']; echo "\"><i class=\"fa fa-trash\"></i></label>";
						echo "<input id=\"delete-submit-"; echo $entry['entry_Id']; echo "\" style=\"display:none;\" type=\"submit\" value=\"delete-"; echo $entry['entry_Id']; echo "\" name=\"submit\" />";
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
		<fieldset>
			<legend>New entry</legend>
			<div>
			<label>Date</label>
			<input type="date" name='date' size='9' value="<?php echo date("Y-m-d"); ?>" />
			</div>
			<div>
			<label>Amount of money</label>
			<input type="text" placeholder="00.00" name='amountOfMoney' />
			</div>
			<div>
			<label>Description</label>
			<input type="text" name="description">
			</div>
			<div>
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
			</div>
		</fieldset>
		<button class="button-fieldset" type="submit" name="submit" value="new">Save</button>
	</form>
<?php 
	include 'shared/footer.html.php';
?>