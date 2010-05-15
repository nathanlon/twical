<?php

/**
 * For any functions to help over all the model classes.
 *
 */
class TwicalHelper {

  //FORM HELPERS

  /**
   * A central place to check for global errors on the whole form, for both BaseFormPropel
   * subclasses, and mySfForm subclasses. Works in conjunction with renderGlobalErrors below.
   * @param boolean $hasGlobalErrors For when errors have been already found.
   * @param sfForm $form The form we are checking the errors on.
   * @return <type>
   */
  static public function hasGlobalErrors($hasGlobalErrors, $form)
  {
    if (!$hasGlobalErrors)
    {
      //treat any error as a global error.
      $nonGlobalErrors = $form->getErrorSchema()->getErrors();
      if (count($nonGlobalErrors) > 0)
      {
        return true;
      }
    }

    return $hasGlobalErrors;
  }


  /**
   * A central place to render global errors for both BaseFormPropel subclasses, and mySfForm subclasses.
   * Works in conjunction with hasGlobalErrors above.
   * @param sfForm $form
   * @return string The errors, formatted appropriately.
   */
  static public function renderGlobalErrors($form)
  {

    //$globalErrorsText = parent::renderGlobalErrors();
    $globalErrorsText = '';
    //treat any error as a global error.
    $nonGlobalErrors = $form->getErrorSchema()->getErrors();

    $nonGlobalErrorCount = count($nonGlobalErrors);
    if ($nonGlobalErrorCount > 0)
    {
      //$globalErrorsText .= '(1) ';//<br />The following fields are required: ';
      $count = 1;

      ////print_r($nonGlobalErrors);

      foreach ($nonGlobalErrors as $key => $nonGlobalError)
      {
        //$globalErrorsText .= '<br />'.$key . ': ' . $nonGlobalError->getMessage() . '<br />';

        $labelName = '';
        if (isset($form[$key]))
        {
          $labelName = $form[$key]->renderLabelName();
        }
        $globalErrorsText .= $labelName . ': ' . $nonGlobalError . ' ';

        //put a comma after each if it isn't the last, otherwise a full stop.
        if ($count < $nonGlobalErrorCount)
        {
          //$globalErrorsText .= sprintf(" (%s) ", $count+1);
        }
        else
        {
          $globalErrorsText .= ".";
        }
        $count++;
      }
    }
    return $globalErrorsText;

  }
