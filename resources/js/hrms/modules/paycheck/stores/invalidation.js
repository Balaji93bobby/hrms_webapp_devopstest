import { required, email, maxLength } from "@vuelidate/validators";
export default function validationz(rules) {
    return (rules = {
        email: {
            required,
        },

    })

}