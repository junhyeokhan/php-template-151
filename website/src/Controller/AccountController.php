<?php

namespace junhyeokhan\Controller;

use junhyeokhan\SimpleTemplateEngine;
use junhyeokhan\Service\Account\AccountServiceInterface;

class AccountController
{
  private $template;
  private $accountService;
  
  public function __construct(SimpleTemplateEngine $template, AccountServiceInterface $accountService)
  {
     $this->template = $template;
     $this->accountService = $accountService;
  }
  
  public function showDeleteAccount()
  {
  	echo $this->template->render("deleteaccount.html.php");
  }
  
  public function deleteAccount($email, $password)
  {
  	return $this->accountService->deleteAccount($email, $password);
  }
}
