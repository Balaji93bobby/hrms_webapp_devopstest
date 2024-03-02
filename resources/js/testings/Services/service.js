import axios from "axios";

export async function fetchUser(){
    const user=await axios.get('/fetch_pending_reimbursements')
    return user.data
}

