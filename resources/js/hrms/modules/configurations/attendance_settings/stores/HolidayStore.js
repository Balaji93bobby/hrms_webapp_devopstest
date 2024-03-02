import { defineStore } from "pinia";
import { ref, reactive, onMounted } from "vue";
import { useToast } from "primevue/usetoast";
import axios from "axios";
import moment from "moment";

export const useHolidayStore = defineStore("useHolidayStore", () => {

    // Notification service
    const toast = useToast();

    // Variable Declarations
    const canShowLoading = ref(false);
    const DialogAddNewHoliday = ref(false);
    const holidayData = ref();
    const arrayholidayMaster =ref();
    const arrayCreateNewList = ref();
    const activeHolidaysPage = ref(1);
    const arrayHolidaysList = ref();
    const CreateNewListDialog = ref(false);
    const editHoliday = ref(false);
    const storeeditID= ref();

    const addNewHoliday = reactive({
        FestivalTitle: "",
        Description: "",
        date: "",
        Holiday_Photo: "",
    });



    const CreateNewList = reactive({
        List_Name: "",
        ChooseTheHolidays:""
    });

    const AssignToLocation = reactive({
        location:"",
        ChooseTheHolidays:""
    });
    const chooseHolidaylist = reactive([]);
    const ChooseTheHolidays = ref()
    const selectedHolidays = reactive([]);


    let forms = new FormData()

    const avatar  = ref()


    const FestivalPhoto = (e) => {
        // Check if file is selected
        if (e.target.files && e.target.files[0]) {
            // Get uploaded file
            addNewHoliday.Holiday_Photo = e.target.files[0];
            // Get file size
            // Print to console9+++
            avatar.value = window.URL.createObjectURL(e.target.files[0]);
            console.log(addNewHoliday.Holiday_Photo);
            forms.append("file",addNewHoliday.Holiday_Photo)
            console.log(forms);
        }
    }

    // events

    const getHolidays = async() =>{
        canShowLoading.value = true;
        await axios.get('/holiday/master-page').then(res=>{
            console.log(res.data);
            holidayData.value = res.data
        }).finally(()=>{
            canShowLoading.value = false;
        })
    }

    // function convert(str) {
    //     var date = new Date(str),
    //       mnth = ("0" + (date.getMonth() + 1)).slice(-2),
    //       day = ("0" + date.getDate()).slice(-2);
    //     return [date.getFullYear(), mnth, day].join("-");
    //   }

    //   console.log(convert(addNewHoliday.date));

    const sumbitAddNewHoliday = () => {
        // console.log("date",addNewHoliday.date);

        DialogAddNewHoliday.value = false;

        let url =`holiday/create_holiday`;


        let form = new FormData();
        form.append('holiday_name', addNewHoliday.FestivalTitle)
        form.append('holiday_description', addNewHoliday.Description);
        form.append('holiday_date', addNewHoliday.date);
        form.append('holiday_image',addNewHoliday.Holiday_Photo);
        axios.post(url,form).then(()=>{

        }).finally(() => {
            getHolidays();
        });
    }

    const getHolidaysMaster = async()=>{
        await axios.get('http://localhost:3000/HolidayMaster').then(res=>{
            console.log(res.data);
            arrayholidayMaster.value = res.data;
        })
    };

    const getHolidaylist = async()=>{
        await axios.get('/holidays/add_holidayslist').then((res)=>{
            arrayHolidaysList.value = res.data;

        })
    }


    const getCreateNewList =async()=>{
        await axios.get('/holidays/show_holidaysListDetails').then(res=>{
            console.log(res.data);
            arrayCreateNewList.value = res.data;

        })
    }

    const SubmitCreateNewList = ()=>{

        for (var key in ChooseTheHolidays.value) {
            let data ={
                "id":ChooseTheHolidays.value[key].id,
                "holiday":ChooseTheHolidays.value[key].holiday_name,
            }
            selectedHolidays.push(data);
        }
        console.log(selectedHolidays);

        axios.post('holiday/create_holidaylist',{
            name:CreateNewList.List_Name,
            holiday_list_id:selectedHolidays
        }).then((res)=>{
            res.data;
        }).finally(()=>{
            getHolidays();
            CreateNewListDialog.value = false;
        })
    }

    const SubmitAddNewLocation = ()=>{
        axios.post('holiday/create_holidaylocation',{
            name:AssignToLocation.location,
            vmt_holidays_list_id:AssignToLocation.ChooseTheHolidays.id
        }).finally(()=>{
        })
    }

    const getHolidayName = () =>{
        console.log(ChooseTheHolidays.value);
    }


    async function RemoveHolidayList (data){

        let holiday ={
            id:data.id,
            image_url:data.holiday_name
        }
        console.log(holiday.id);

        let url = `holidays/delete_holiday`;
        axios.post(url,
            holiday
        ).then(()=>{}).finally(()=>{
            getHolidays();
        });
    }

     function editHolidaylist(data){
        editHoliday.value = true
        console.log(data);

        storeeditID.value = data.id
        addNewHoliday.FestivalTitle = data.holiday_name
        addNewHoliday.Description = data.holiday_description
        addNewHoliday.date= data.holiday_date
        addNewHoliday.Holiday_Photo = data.image

        // console.log(addNewHoliday.FestivalTitle);
        // let url  = `http://localhost:3000/SubmitAddNewLocation`
    }

    function sumbiteditHoliday(){
          let url  = `holidays/update_holiday`;

          let form = new FormData();
        form.append('id',storeeditID.value)
        form.append('holiday_name',addNewHoliday.FestivalTitle)
        form.append('holiday_description',addNewHoliday.Description)
        form.append('holiday_date',addNewHoliday.date)
        form.append('holiday_image',addNewHoliday.Holiday_Photo)
          axios.post(url,form).then(()=>{

          }).finally(()=>{
            getHolidays();
          })


    }

    // function sumbit(){

    // }


//




    return {

        // Variable Declaration
        holidayData,activeHolidaysPage,CreateNewList,
        AssignToLocation,arrayholidayMaster,canShowLoading,
        addNewHoliday,chooseHolidaylist,

        arrayCreateNewList,
        arrayHolidaysList,

        CreateNewListDialog,
        DialogAddNewHoliday,

        // function
        getHolidays,SubmitCreateNewList,SubmitAddNewLocation,

        getHolidaysMaster,getHolidaylist,getHolidayName,
        ChooseTheHolidays,FestivalPhoto,sumbitAddNewHoliday,
        avatar,getCreateNewList,editHolidaylist,editHoliday,
        sumbiteditHoliday,RemoveHolidayList

    };
});
