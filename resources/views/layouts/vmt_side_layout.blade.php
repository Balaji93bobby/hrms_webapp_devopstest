<div class="settings-layout p-0 d-flex justify-content-start container-fluid ">
    <div class="left-content  d-flex">
        <div class="card " style="width: 18rem;">
            <div class="card-body p-0">
                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a href="#" class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"  role="tab" aria-controls="v-pills-home" aria-selected="true">
                        <label>Org Infoz</label>
                        <span> General info settings </span>
                    </a>
                    <a href="#" class="list-group-item"><label>
                            Payroll </label><span> Setup, Leave encashment, Payment and Payslip settings
                        </span></a>


                    <a href="#" class="list-group-item"><label>
                            Account & Billing </label>
                        <span> Information about account and billing </span>
                    </a>
                    <a href="#" class="list-group-item"><label>
                            Welcome Screen </label>
                        <span> Welcome screen settings </span>
                    </a>
                    <a href="#" class="list-group-item"><label>
                            Roles & Permissions </label><span> Manage roles and permissions
                        </span></a>
                    <a href="#" class="list-group-item"><label>
                            Integrations and Automation </label><span> Login, Event triggers, Email digest and API
                            access
                        </span></a>
                        <a href="#" class="list-group-item"><label>
                        Data Imports </label><span> Data import tracker 
                        </span></a>
                </div>
            </div>
        </div>
    </div>




    <div class="right-content p-0 mx-3 container-fluid">


        <div class="header-content d-flex align-items-center bg-white px-3">
            <label class="heading">General Info</label>
        </div>


        <div class="container p-0  bg-white my-3 tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="card ">
                <div class="card-body">
                    <div>
                        <h2>General Info</h2>
                        <p></p>
                    </div>

                    <div class="mb-3">
                        <label for="short-name" class="form-label">Short Name</label>
                        <input type="text" class="form-control w-25" id="short-name">

                    </div>

                    <div class="mb-3 d-flex flex-column">
                        <label for="logo" class="form-label">Logo</label>


                        <span class="text-secondary">Logo dimensions cannot exceed 100 px width
                            60
                            px height. <span class="text-danger">*</span> </span>

                    </div>

                    <div class="mb-3">
                        <div class="logo-image d-flex align-items-center">
                            <img src="http://127.0.0.1:8000/assets/images/vasa.jpg" alt="brand-logo"
                                accept=".png,.jpg,.jpeg,.bmp">
                            <label for="img-pin">
                                <i class="ri-attachment-line px-1"></i>
                                <span>
                                    Upload</span>
                            </label>
                        </div>

                    </div>


                    <div class="mb-3 ">
                        <div class="background-image-content d-flex flex-column">
                            <label for="logo" class="form-label">Background Image</label>

                            <span class="text-secondary">
                                This Background Image will be displayed in the Login Page.
                            </span>
                        </div>
                    </div>


                    <div class="mb-3">
                        <div class="background-container d-flex align-items-center">

                            <div class="background-img">
                                <img src="http://127.0.0.1:8000/assets/images/vasa.jpg" alt="brand-logo"
                                    accept=".png,.jpg,.jpeg,.bmp">
                            </div>
                            <div class="background-image-pin">
                                <label for="img-pin">
                                    <i class="ri-attachment-line px-1"></i>
                                    <span>
                                        Pick different background</span>
                                </label>

                            </div>
                        </div>

                    </div>

                    <div class="mb-3">
                        <div class="intructions-container d-flex flex-column">
                            <label for="logo" class="form-label">Instruction
                                Information</label>
                            <span class="text-secondary">This text will be displayed in the
                                Login Page.</span>


                        </div>

                    </div>

                    <div class="mb-3">
                        <div class="intructions-container d-flex align-items-center">
                            <textarea
                                placeholder="You can provide instructions or similar information not exceeding 250 characters"
                                rows="4" maxlength="250" formcontrolname="loginInstructions"
                                class="form-control "></textarea>
                        </div>

                    </div>


                    <div class="mb-3">
                        <div class="buttons-container d-flex align-items-center">
                            <button class="btn btn-default mx-2">Preview</button><button
                                class="btn btn-primary">Save</button>
                        </div>


                    </div>
                </div>
            </div>
        </div>


    </div>








    <!-- role -->



  

</div>