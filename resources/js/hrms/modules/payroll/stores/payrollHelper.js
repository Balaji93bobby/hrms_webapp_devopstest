import { defineStore } from 'pinia';
import { ref, reactive } from 'vue';


export const usePayrollHelper = defineStore('usePayrollHelper', () => {

    /*
    1)Helper class contains Dropdown source
    2)Basic Dependent Function
    3)Filter functions
    4)Simple Calculation

    *Only Access for Payroll Module
    */

    const payFrequencyDropdown = ref([
        { id: '1', name: 'Monthly' },
        { id: '2', name: 'Weekly' },
        { id: '3', name: 'Daily' },
    ])

    const getLastDayOfMonth = (month, year) => {
        console.log(year, month + 1);
        // Create a Date object for the next month's first day
        const nextMonth = new Date(year, month + 1, 1);

        // Subtract one day from the next month's first day to get the last day of the desired month
        const lastDay = new Date(nextMonth.getTime() - 24 * 60 * 60 * 1000);
        console.log(lastDay.getDate());

        return lastDay.getDate();
    }

    // Example usage
    //   const year = 2023;
    //   const month = 7; // August (0-based index, so January is 0, February is 1, and so on)

    //   const lastDay = getLastDayOfMonth(year, month);
    //   console.log(`The last day of ${month + 1}/${year} is ${lastDay}.`);


    const componentTypes = ref([
        { id: 1, name: "Fixed", value: 1 },
        { id: 2, name: "Variable", value: 2 },
    ])
    const componentCategories = ref([
        { id: '1', name: 'earnings' },
        { id: '2', name: 'deduction' },
        { id: '3', name: 'adhoc' },
        { id: '4', name: 'reimbursement' },
    ])
    const calculationTypes = ref([
        { id: 1, name: "Flat Amount", value: 1 },
        { id: 2, name: "Percentage of CTC", value: 2 },
    ])

    const findCompType = (value) => {
        let type = componentTypes.value.find(ele => {
            return ele.value == value
        })
        return type.name
    }

    const findCalType = (value) => {
        let type = calculationTypes.value.find(ele => {
            return ele.value == value
        })
        return type.name
    }

    const findIsSelected = (value) => {
        if (value == 1) {
            return "Yes"
        } else {
            return "No"
        }
    }

    const filterSource = (data, key) => {
        let filteredSource = data.filter(ele => {
            return ele.category_id == key
        })
        return filteredSource
    }

    const dropdownFilter = ref()
    const selectedFilterOptions = reactive({
        department_id: '',
        designation: '',
        work_location: '',
        state: '',
        client_name: '',
    })

    // Eligible Employees

    const eligbleEmployeeSource = ref()

    // Get filter

    const getDropdownFilterDetails = async () => {
        // canShowLoading.value = true
        let url = '/getAllDropdownFilter'
        await axios.get(url).then(res => {
            dropdownFilter.value = res.data
        }).finally(() => {
            // canShowLoading.value = false
        })
    }

    const getSelectoption = (key, filter) => {
        console.log(filter);

        if (key == "department") {
            console.log(filter);
            selectedFilterOptions.department_id = filter
            console.log(selectedFilterOptions);
        } else
            if (key == "designation") {
                selectedFilterOptions.designation = filter
                console.log(selectedFilterOptions);
            } else
                if (key == "state") {
                    selectedFilterOptions.state = filter
                    console.log(selectedFilterOptions);
                } else
                    if (key == "work_location") {
                        selectedFilterOptions.work_location = filter
                        console.log(selectedFilterOptions);
                    } else
                        if (key == "client_name") {
                            selectedFilterOptions.client_name = filter
                            console.log(selectedFilterOptions);
                        }
                        else {
                            console.log("nope");
                        }
        let url = '/showAssignEmp'
        axios.post(url, selectedFilterOptions).then(res => {
            eligbleEmployeeSource.value = res.data
            console.log(res.data);
        })
    }

    return {
        payFrequencyDropdown,
        getLastDayOfMonth,
        componentTypes,
        calculationTypes,
        componentCategories,
        findCompType,
        findCalType,
        findIsSelected,
        filterSource,
        dropdownFilter,
        getDropdownFilterDetails,
        getSelectoption

    }
})

