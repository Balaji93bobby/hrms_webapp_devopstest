<?php

namespace App\Imports;

use App\Group;
use App\Models\VmtInvFormSection;
use App\Models\VmtInvSectionGroup;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use App\Models\User;
use App\Models\VmtInvForm;
use App\Models\VmtInvSection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;


class VmtInvSectionImport implements OnEachRow,WithHeadingRow,WithCalculatedFormulas
{

    use Importable;

    private $form_id;

    public function __construct(int $form_id)
    {
        $this->form_id = $form_id;
    }

    public function onRow(Row $row)
    {
       // dd($row);
        $rowIndex = $row->getIndex();
        $row    = $row->toArray();

        //Create section groups
        //Check if section group already
        $query_sectiongroup = VmtInvSectionGroup::where('section_group',$row['section_group']);

        if($query_sectiongroup->exists())
        {
            $query_sectiongroup = $query_sectiongroup->first();

        }
        else
        {
            $query_vmtinvsectiongroup  = new VmtInvSectionGroup;
            $query_vmtinvsectiongroup->section_group = $row['section_group'] ?? "none";
            $query_vmtinvsectiongroup->save();

            //get the id
            $query_sectiongroup = $query_vmtinvsectiongroup;
        }

        //Create sections
          $query_vmtinvsectiongroup  = new vmtInvsectionGroup;
          $query_vmtinvsectiongroup->section_group = $row['section_group'];
          $query_vmtinvsectiongroup->save();


        $query_vmtInvSection = new VmtInvSection;
        $query_vmtInvSection->sectiongroup_id = $query_sectiongroup->id;
        $query_vmtInvSection->section = $row['section'];
      //  $query_vmtInvSection->section_group_id =  $query_vmtinvsectiongroup->id ;
        $query_vmtInvSection->particular = $row['particular'];
        $query_vmtInvSection->reference = $row['references'];
        $query_vmtInvSection->max_amount = $row['max_amount'];
        $query_vmtInvSection->section_option_1  = $row['section_option_1'];
        $query_vmtInvSection->section_option_2  = $row['section_option_2'];
        $query_vmtInvSection->save();

        //Link table
        $query_vmtInvfromse = new VmtInvFormSection;
        $query_vmtInvfromse->form_id = $this->form_id;
        $query_vmtInvfromse->section_id = $query_vmtInvSection->id;
        $query_vmtInvfromse->save();


    }
}
