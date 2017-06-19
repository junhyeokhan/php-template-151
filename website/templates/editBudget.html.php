<?php
	include 'shared/header.html.php';
?>
<h1>Budget</h1>
<h2>
	Edit an entry.
</h2>
<form method="POST">
	<fieldset>
		<legend>Edit entry</legend>
		<input style="display:none;" name="entry_Id" value="<?php if (isset($entry['entry_Id'])) { echo $entry['entry_Id']; } ?>">
		<div>
		<label>Date</label>
		<input type="date" name='date' size='9' value="<?php if (isset($entry['date'])) { echo $entry['date']; } ?>" />
		</div>
		<div>
		<label>Amount of money</label>
		<input type="text" placeholder="00.00" name='amountOfMoney' value="<?php if (isset($entry['amountOfMoney'])) { echo $entry['amountOfMoney']; } ?>"  />
		</div>
		<div>
		<label>Description</label>
		<input type="text" name="description" value="<?php if (isset($entry['description'])) { echo $entry['description']; } ?>" >
		</div>
		<div>
		<label>Category</label>
		<select name="category">
			<?php 
				foreach ($categories as $category)
				{
					echo "<option value=\"";
					echo $category['category_Id'];
					echo "\"";
					if ($category['category_Id'] == $entry['category_Id'])
					{
						echo " selected=\"selected\"";
					}
					echo ">";
					echo $category['name'];
					echo "</option>";
				}
			?>
		</select>
		</div>
	</fieldset>
	<button class="button-fieldset" type="submit" name="submit" value="save">Save</button>
	<button type="submit" name="submit" value="cancel">Cancel</button>
</form>
<?php
	include 'shared/footer.html.php';
?>