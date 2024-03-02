import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import axios from "axios";

export const useTestQueueStore = defineStore("useTestQueueStore", () => {

    const canShowLoading = ref(true);

    async function checkMailSpeed(user_code, mail_content, can_queue) {
        //Leave history vars


     await axios
            .post("/testing/test_queues/checkMailSpeed", {
                user_code: user_code,
                mail_content : mail_content,
                can_queue : can_queue
            })
            .then((res) => {
                console.log(res.data.messege);
                if (res.data.status == "success") {
                    Swal.fire("Success", res.data.message, "success");
                }
                if (res.data.status == "failure") {
                    Swal.fire("Failure", res.data.message, "error");
                }

                console.log("checkMailSpeed()" + res.data.status);
            })
            .catch((err) => {
                console.log(err);
            })
            .finally(() => {

            });

        // }
    }

    return {

        checkMailSpeed

    };
});
