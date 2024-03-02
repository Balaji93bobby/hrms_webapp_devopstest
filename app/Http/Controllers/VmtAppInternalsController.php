<?php

namespace App\Http\Controllers;

use App\Models\VmtClientMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;

class VmtAppInternalsController extends Controller
{


    public function showLoginPage(Request $request){
        return view("internal.app_internals.index");
    }

    public function login(Request $request){

        $validator = Validator::make(
            $data = [
                'user_code' => $request->user_code,
                'password' => $request->password,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
                'password' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors(['message' =>$validator->errors()->all()]);
        }

        if (Auth::attempt(['user_code'=> $request->user_code,'password'=> $request->password])) {


            $array_status = [
                'current_os' => $current_os_type = strtoupper(substr(PHP_OS, 0, 3)),
                'git_branch' => $this->executeCommand_GitBranch(),
                'git_last_update' => $this->executeCommand_GitLog(),
                'db_client_list' => VmtClientMaster::all(['client_name','client_code']),
            ];


            return view("internal.app_internals.appinternals_status", compact('array_status'));
        }
        else
        {

            $error_message = "Invalid credentials!";
            return back()->withErrors(['message' => $error_message]);
        }


    }

    public function showAppInternalsMainPage(Request $request){
        return view("internal.app_internals.appinternals_status");
    }

    private function executeCommand_GitBranch(){

        $command = ['git', 'branch', '--show-current'];
        $process = new Process($command);
        $process->run();

        return [
            'output' => '<b>'.$process->getOutput().'</b>',
            'error_output' => $process->getErrorOutput(),
            'exit_code' => $process->getExitCode(),
        ];
    }

    private function executeCommand_GitLog(){

        $command = [
            'git',
            'log',
            '--pretty=format:[ %aD %an %h ] : >> %s %b %n',
            '-n',
            '5',
        ];

        $process = new Process($command);
        $process->run();

        return [
            'output' => '<b>'.nl2br($process->getOutput()).'</b>',
            'error_output' => $process->getErrorOutput(),
            'exit_code' => $process->getExitCode(),
        ];
    }

    public function executeCommand_GitPull(Request $request){

        //Check whether the current domain is demo and localhost only

        $allowed_hosts = ['demo.abshrms.com','localhost'];
        $current_domain = $request->getHost();

        if(! in_array($current_domain, $allowed_hosts))
        {
            return [
                "NOTE" => "Due to linux restrictions, this command wont work for now. Ignore below messages.",
                "message" => "ERROR : GIT PULL is allowed only on DEMO and Localhost sites",
                "current_domain" => $current_domain
            ];
        }

        $command1 = ['ssh-agent', 'bash'];
        $command2 = ['ssh-add', 'newssh'];
        $command3 = ['git', 'pull'];

        $process1 = new Process($command1);
        $process1->run();

        // Check if the first process was successful before proceeding to the second one
        if ($process1->isSuccessful()) {
            $process2 = new Process($command2);
            $process2->run();

            if ($process2->isSuccessful()) {
                $process3 = new Process($command3);
                $process3->run();

                if ($process3->isSuccessful()) {
                    return [
                        'message' => 'Site Update successfull',
                        'output' => $process3->getOutput(),
                        'error_output' => $process3->getErrorOutput(),
                        'exit_code' => $process3->getExitCode(),
                    ];
                }
                else
                {
                    return [
                        'message' => 'Failed while running GIT PULL',
                        'output' => '<b>'.nl2br($process3->getOutput()).'</b>',
                        'error_output' => $process3->getErrorOutput(),
                        'exit_code' => $process3->getExitCode(),
                    ];
                }
            }
            else
            {
                return [
                    'message' => 'Failed while running SSH-ADD',
                    'output' => $process2->getOutput(),
                    'error_output' => $process2->getErrorOutput(),
                    'exit_code' => $process2->getExitCode(),
                ];
            }
        } else {

            return [
                'message' => 'Failed while running SSH-AGENT',
                'output' => $process1->getOutput(),
                'error_output' => $process1->getErrorOutput(),
                'exit_code' => $process1->getExitCode(),
            ];
        }


    }
}
