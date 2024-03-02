<?php
class JSON_AssignedPMSFormDetails
{

    private $employee_name;
    private $form_data;

    public function __construct($employee_name, $form_data)
    {
        $this->employee_name = $employee_name;
        $this->form_data = $form_data;
    }
}
?>
