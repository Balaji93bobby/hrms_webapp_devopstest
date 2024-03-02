<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VmtReviewQuestion;
use App\Models\VmtUserForm;
use App\Models\VmtReviewForm;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\VmtEmployeeHierarchy;


class Review360ModuleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showFormIndex()
    {
        //
        $formList = VmtReviewForm::all();
        return view('vmt_360review_forms_index', compact('formList'));
        return $roles;
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showQuestionsPage()
    {
        $questionList  = VmtReviewQuestion::all();
        return view('vmt_360review_questions', compact('questionList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showFormsPage()
    {   
        $questionList  = VmtReviewQuestion::all();
        return view('vmt_360review_forms', compact('questionList'));
    }

    public function showQuestionForm(){
        return view('vmt_360review_create_edit_question');
    }

    // show edit question form
    public function showFormsEdit($id){
        $question = VmtReviewQuestion::find($id);
        return view('vmt_360review_create_edit_question', compact('question'));
    }

    // edit form
    public function editReviewForm($id){
        $formObj       = VmtReviewForm::find($id);
        $formObj->questions = explode(',', $formObj->questions);
        $questionList  = VmtReviewQuestion::all();
        //dd($formObj);
        return view('vmt_360review_forms', compact('questionList', 'formObj'));
    }

    // Store Review Questions in DB
    public function saveReviewQuestios(Request $request){

        // if id ? update : create
        if($request->has('id')){
            $newQuestion  =  VmtReviewQuestion::find($request->id); 
            $msg = "Question Updated";
        }else{
            $newQuestion  =  new VmtReviewQuestion; 
            $msg = "Question Saved";
        }
        $newQuestion->question  =  $request->question; 
        $newQuestion->option_1  =  $request->option_1; // => "Always"
        $newQuestion->option_2  =  $request->option_2; // => "Once in a While"
        $newQuestion->option_3  =  $request->option_3; // => "About half the time"
        $newQuestion->option_4  =  $request->option_4; // => "Most of the time"
        $newQuestion->option_5  =  $request->option_5; // => "Never"
        $newQuestion->answer    =  $request->answer; // => "Never"
        $newQuestion->author_id  =  auth::user()->id;
        $newQuestion->author_name  =  auth::user()->name;
        $newQuestion->save();

        return $msg; //"Question Saved";
    }


    // Store Forms
    public function storeOrUpdateForms(Request $request){
       
        if($request->has('id')){
            $vmtForm  =  VmtReviewForm::find($request->id); 
        }else{
            $vmtForm = new VmtReviewForm; 
        }
        $vmtForm->name = $request->name;
        $vmtForm->questions =   implode(',', $request->question);
        $vmtForm->author_id =   auth::user()->id;
        $vmtForm->author_name = auth::user()->name;
        $vmtForm->save();
        return "Form Saved";
        dd($request->all());
    }

    // viewForm
    public function viewForm($id, Request $request){
        $formObj = VmtReviewForm::find($id);

        $queArray =  explode(',', $formObj->questions);

        $formQuestions  = VmtReviewQuestion::whereIn('id', $queArray)->select('id', 'question', 'option_1','option_2', 'option_3', 'option_4', 'option_5')->get();
        return view('vmt_360review_forms_view', compact('formObj', 'formQuestions'));
    }

    // view 360 assigned form
    public function viewAssignUserForm(Request $request){
        $userForm = VmtUserForm::where('user_id', auth::user()->id)->first();
        
        if($userForm){
            $formObj  =     VmtReviewForm::find($userForm->form_id);
            $queArray =     explode(',', $formObj->questions);
            $formQuestions  = VmtReviewQuestion::whereIn('id', $queArray)->select('id', 'question', 'option_1','option_2', 'option_3', 'option_4', 'option_5')->get();
            return view('vmt_360review_forms_view', compact('formObj', 'formQuestions')); 
        }else{
            $userid  = auth::user()->id;
            $userHierarchy = VmtEmployeeHierarchy::whereIn('child_nodes', [$userid])->first();
            if($userHierarchy){
                $userForm = VmtUserForm::where('user_id', $userHierarchy->user_id)->first();
                if($userForm){
                    $formObj  =     VmtReviewForm::find($userForm->form_id);
                    $queArray =     explode(',', $formObj->questions);
                    $formQuestions  = VmtReviewQuestion::whereIn('id', $queArray)->select('id', 'question', 'option_1','option_2', 'option_3', 'option_4', 'option_5')->get();
                    return view('vmt_360review_forms_view', compact('formObj', 'formQuestions')); 
                }
                //$formObj  =     VmtReviewForm::find($userForm->form_id);
            }
            $formObj  =     null;//VmtReviewForm::find($userForm->form_id);
            $queArray =    null; //explode(',', $formObj->questions);
            $formQuestions  = null;//VmtReviewQuestion::whereIn('id', $queArray)->select('id', 'question', 'option_1','option_2', 'option_3', 'option_4', 'option_5')->get();
            return view('vmt_360review_forms_view', compact('formObj', 'formQuestions')); 
            return "No forms found";
        }
         
    }

    // assign forms to user form view
    public function assignToUser($id, Request $request){
        $formObj = VmtReviewForm::find($id);
        $users   = User::all(); 
        return view('vmt_360review_assignFormToUser', compact('formObj', 'users'));   
    }

    // unassign user form 
    public function unassignView($id, Request $request){
        $formObj        =   VmtReviewForm::find($id);
        $assignedUsers  =   VmtUserForm::where('form_id', $id)
                                ->select(
                                    'vmt_reviewuserforms.id as review_form_id', 
                                    'vmt_reviewuserforms.form_id', 
                                    'vmt_reviewuserforms.user_id', 
                                    'users.name as username'
                                )
                                ->leftJoin('users', 'users.id', '=', 'vmt_reviewuserforms.user_id')
                                ->get();
        //dd($assignedUsers);
        return view('vmt_360review_unassignUserForm', compact('formObj', 'assignedUsers'));   
    }

    // assign forms To user : store
    public function assignForm($id, Request $request)
    {
        // code...

        $assignedForms = VmtUserForm::where('user_id', $request->user_id)->get(); 

        foreach($assignedForms as $index => $assignForm){
            $assignForm->delete();
        }


        /*$isAssigned = VmtUserForm::where('user_id', $request->user_id)->where('form_id', $id)->first(); 

        if($isAssigned){
            return "Form Assigned"; 
        }else{*/
            $userForm = new VmtUserForm; 
            $userForm->form_id = $id;
            $userForm->user_id = $request->user_id; 
            $userForm->save();
            return "Form Assigned"; 
        //}
    }


    // unassignUserStore
    public function unassignUserStore($id, Request $request)
    {
        // code...
        //dd($request->all());

        $assignedForms = VmtUserForm::where('form_id', $id)->get(); 

        foreach($assignedForms as $index => $assignForm){
            $assignForm->delete();
        }

        if($request->has('assign_users')){
            foreach($request->assign_users as $aUser){
                $userForm = new VmtUserForm; 
                $userForm->form_id = $id;
                $userForm->user_id = $aUser; 
                $userForm->save();
            }
        }

        return 'Form Unassigned';

        
    }    
  
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteQuestion(Request $request)
    {
        VmtReviewQuestion::find($request->id)->delete(); 
        return 'Question Deleted';
    }

    // delete form from DB
    public function deleteReviewForm(Request $request)
    {
        VmtReviewForm::find($request->id)->delete(); 
        return 'Form Deleted';
    }

}
