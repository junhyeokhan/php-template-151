<?php

namespace junhyeokhan\Service\Budget;

interface BudgetServiceInterface
{
	public function getBudget($email, $year, $month);
	public function getAllCategories();
	public function saveEntry($data, $email);
	public function getEntry($entry_Id);
	public function deleteEntry($entryId);
}

?>