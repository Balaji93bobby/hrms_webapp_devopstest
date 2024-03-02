import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";


/*
    This Pinia code will store the ajax values of the
    profile page.
    This code is called from Parents onMounted method asynchronously

*/

export const investmentFormulaStore = defineStore("investmentFormulaStore", () => {

    // Tax Calculation

    const tax_amt = ref()

    const taxCalculation = (total_income, regime, age) => {
        /*  Old Regime Calcualtion Using Total Income Of Employeer and Employeer Age

        total income = Employeer Total Income
        regime = is Old or New
        age = Employeer Age

        Net Taxable Income              New Tax Regime 	     Old Tax Regime
        Up to Rs 2.5 lakh	                 Exempt	          Exempt
        Rs 2,50,001 to Rs 5 lakh	           5%	            5%
        Rs 5,00,001 to Rs 7.5 lakh	           10%	            20%
        Rs 7,50,001 to Rs 10 lakh	           15%
        Rs 10,00,001 to Rs 12.5 lakh	       20%	            30%
        Rs 12,50,001 to Rs 15 lakh	           25%
        Over Rs. 15 lakh	                   30%

        */

        console.log("total income :" + total_income)
        console.log("employee age:" + age);

        // Old Regime Tax Calculation

        if (regime == 'old') {
            // If the Employeer Age is Less than 60 Years
            if (age < 60) {
                if (total_income <= 250000) {
                    console.log("taxable income is zero");
                    let taxable_amount = 0;
                    console.log("taxable_amount :" + Math.floor(taxable_amount));
                    return taxable_amount;
                } else
                    if (total_income > 250000 && total_income <= 500000) {
                        let deduction = total_income - 250000
                        let taxable_amount = deduction * 5 / 100;
                        console.log("Tax On Income" + taxable_amount)
                        let total_amount = Math.round(taxable_amount + 12500)
                        let heath_and_education = total_amount * 4 / 100;
                        console.log("child Eduction :" + heath_and_education);
                        console.log("taxable_amount :" + total_amount + heath_and_education);
                        let final_value = total_amount + heath_and_education;
                        return final_value;
                    } else
                        if (total_income > 500000 && total_income <= 1000000) {
                            let deduction = total_income - 500000
                            let taxable_amount = deduction * 20 / 100;
                            console.log("Tax On Income" + taxable_amount);
                            let total_amount = Math.round(taxable_amount + 12500)
                            let heath_and_education = taxable_amount * 4 / 100;
                            console.log("child Eduction :" + heath_and_education);
                            console.log("taxable_amount :" + Math.round(total_amount + heath_and_education));
                            let final_value = total_amount + heath_and_education;
                            return final_value;
                        } else
                            if (total_income > 1000000) {
                                let subcharge = '';
                                let heath_and_education = 0;
                                let deduction = total_income - 1000000
                                let taxable_amount = deduction * 30 / 100;
                                console.log('---------------------------------------------');
                                console.log("Tax On Income" + taxable_amount);
                                let total_amount = Math.round(taxable_amount + 112500)
                                subcharge = subChargeCalculation(total_income)
                                if (subcharge) {
                                    heath_and_education = (taxable_amount + subcharge) * 4 / 100;
                                    console.log("child Eduction :" + Math.round(heath_and_education));
                                    console.log("surchage"+ Math.round(subcharge));
                                    let final_value = parseInt(total_amount) + parseInt(subcharge) + parseInt(heath_and_education)
                                    console.log("taxable_amount :" + Math.round(final_value));
                                    return  Math.round(final_value);
                                } else {
                                    heath_and_education = total_amount * 4 / 100;
                                    console.log("child Eduction :" + Math.round(heath_and_education));
                                    let final_value = total_amount + heath_and_education;
                                    return Math.round(final_value);
                                }


                            } else {
                                console.log("Salary Is Less Than 250000");
                                return total_income;
                            }

            } else
                // If the Employeer Age is Greater  than 60 Years and Less Than 80 Years
                if (age >= 60 && age <= 80) {
                    if (total_income > 300000 && total_income <= 500000) {
                        let deduction = total_income - 300000
                        let taxable_amount = deduction * 5 / 100;
                        console.log("Tax On Income" + taxable_amount);
                        let heath_and_education = taxable_amount * 4 / 100;
                        console.log("child Eduction :" + heath_and_education);
                        let final_value = Math.round(taxable_amount + heath_and_education)
                        console.log("taxable_amount :" + final_value);
                        return final_value;
                    } else
                        if (total_income > 500000 && total_income < 1000000) {
                            // 5% (tax rebate u/s 87A is available)
                            let deduction = total_income - 500000
                            let taxable_amount = deduction * 20 / 100;
                            console.log("Tax On Income" + taxable_amount);
                            let heath_and_education = taxable_amount * 4 / 100;
                            console.log("child Eduction :" + heath_and_education);
                            let final_value = Math.round(taxable_amount + 10000 + heath_and_education)
                            console.log("taxable_amount :" + final_value);
                            return final_value;
                        } else
                            if (total_income > 1000000) {
                                console.log("working");
                                let deduction = total_income - 1000000
                                let taxable_amount = deduction * 30 / 100;
                                console.log("Tax On Income" + taxable_amount);
                                let total_amount = Math.floor(taxable_amount + 110000)
                                let subcharge = subChargeCalculation(total_income)
                                let heath_and_education = (taxable_amount + subcharge) * 4 / 100;
                                console.log("child Eduction :" + heath_and_education);
                                let final_value = total_amount + subcharge + heath_and_education
                                console.log("taxable_amount :" + final_value);
                                return final_value;
                            }
                            else {
                                console.log("Salary Is Less Than 300000");
                                return total_income;
                            }
                } else
                    // If the Employeer Age is Greater than 80 Years
                    if (age > 80) {
                        if (total_income > 500000 && total_income <= 1000000) {
                            let deduction = total_income - 500000
                            let taxable_amount = deduction * 20 / 100;
                            console.log("taxable_amount :" + Math.round(taxable_amount));
                        } else
                            if (total_income > 1000000) {
                                let deduction = total_income - 1000000
                                let taxable_amount = deduction * 30 / 100;
                                console.log("Tax On Income" + taxable_amount);
                                let total_amount = Math.floor(taxable_amount + 112500)
                                let subcharge = subChargeCalculation(total_income)
                                let heath_and_education = (taxable_amount + subcharge) * 4 / 100;
                                console.log("child Eduction :" + heath_and_education);
                                let final_value = total_amount + subcharge + heath_and_education
                                console.log("taxable_amount :" + final_value);
                                return final_value;;
                            }
                            else {
                                console.log("Salary Is Less Than 500000");
                                return total_income;
                            }
                    }
        }
        else
            if (regime == 'new') {
                // Employeer Income Is Greater than 300000 and Less Than  600000
                if (total_income > 300000 && total_income <= 600000) {
                    let taxable_amount = total_income * 5 / 100;
                    console.log("taxable_amount :" + Math.floor(taxable_amount));
                    console.log("new regime total income greater than 300001");
                    return Math.floor(taxable_amount)

                } else
                    // Employeer Income Is Greater than 600000 and Less Than  900000
                    if (total_income > 600000 && total_income <= 900000) {
                        let taxable_amount = total_income * 10 / 100;
                        console.log("taxable_amount :" + Math.floor(15000 + taxable_amount));
                        console.log("new regime total income greater than 600001");
                        tax_amt.value = Math.floor(taxable_amount)
                        return Math.floor(15000 + taxable_amount)
                    } else
                        // Employeer Income Is Greater than 900000 and Less Than  1200000
                        if (total_income > 900000 && total_income <= 1200000) {
                            let taxable_amount = total_income * 15 / 100;
                            console.log("taxable_amount :" + Math.floor(45000 + taxable_amount));
                            console.log("new regime total income greater than 900001 ");
                            return Math.floor(45000 + taxable_amount)


                        } else
                            // Employeer Income Is Greater than 1200000 and Less Than  1500000
                            if (total_income > 1200000 && total_income < 1500000) {
                                let taxable_amount = total_income * 20 / 100;
                                console.log("taxable_amount :" + Math.floor(90000 + taxable_amount));
                                console.log("new regime total income greater than 1200001");
                                tax_amt.value = Math.floor(taxable_amount)
                                return Math.floor(90000 + taxable_amount)

                            } else
                                // Employeer Income Is Greater than 1500000
                                if (total_income > 1500000) {
                                    let taxable_amount = total_income * 30 / 100;
                                    let total_amount = Math.floor(taxable_amount + 150000)
                                    let subcharge = subChargeCalculation(total_income)
                                    let heath_and_education = (total_amount + subcharge) * 4 / 100;
                                    let final_value = total_amount + subcharge + heath_and_education
                                    console.log("taxable_amount :" + final_value);
                                    return final_value;
                                } else {
                                    let taxable_amount = 0;
                                    console.log("less than 300000 ");
                                    return taxable_amount;
                                }
            }
            else {
                console.log("No More Regime");
            }

    }

    // Calculate Child Education

    const calChildEducation = (value) => {
        const CEF = value * 4 / 100;
        console.log("Child Education:" + CEF);
        return CEF
    }

    //Calculate Tax Subcharge

    const subChargeCalculation = (total_income) => {

        if (total_income >= 5000000 && total_income < 10000000) {
            let subcharge = total_income * 10 / 100
            console.log("Subcharge:" + subcharge);
            return subcharge
        } else
            if (total_income >= 10000000 && total_income < 20000000) {
                let subcharge = total_income * 15 / 100
                console.log("Subcharge:" + subcharge);
                return subcharge
            } else
                if (total_income >= 20000000 && total_income < 50000000) {
                    let subcharge = total_income * 25 / 100
                    console.log("Subcharge:" + subcharge);
                    return subcharge
                } else
                    if (total_income > 50000000) {
                        let subcharge = total_income * 37 / 100
                        console.log("Subcharge:" + subcharge);
                        return subcharge
                    } else {
                        console.log("Total Income is Less than 5000000");
                    }

    }

    // House property

    // Let Out Property and Deemed let out Property

    const maintenance_cal = (lender_type, rent_rec, munic_tax) => {
        // if (lender_type == 'Financial Institution' || lender_type == 'Others') {
        let main = (rent_rec - munic_tax) * 30 / 100
        return main
        // } else {
        //     console.log("Lender type is not exists");
        // }
    }

    const net_value_cal = (rent_rec, munic_tax, main) => {
        let net_value = rent_rec - munic_tax - main
        return net_value;
    }

    const income_loss_cal = (interest, net) => {
        let income_loss = net - interest
        return income_loss;
    }



    return {

        // varaible Declarations
        taxCalculation, maintenance_cal, net_value_cal, income_loss_cal, tax_amt, subChargeCalculation, calChildEducation

    };
});



