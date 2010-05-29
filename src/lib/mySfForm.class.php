<?php

class mySfForm extends sfForm
{

 /**
   * Treats any error as a global error, so we can show these errors in the global area.
   * @see sfForm::hasGlobalErrors()
   *
   * @return Boolean
   */
  public function hasGlobalErrors()
  {
    $hasGlobalErrors = parent::hasGlobalErrors();

    return TwicalHelper::hasGlobalErrors($hasGlobalErrors, $this);
  }

  /**
   * Format the display of global errors to include errors on fields required.
   * @see sfForm::renderGlobalErrors()
   *
   * @return string
   */
  public function renderGlobalErrors()
  {
    return TwicalHelper::renderGlobalErrors($this);
  }

}