<template>
    <div>
        <table  class="table">
            <thead>
                <tr>
                    <th v-for="(monthData, monthIndex) in tableData" :key="monthIndex">
                        <div class="month-header">{{ monthData.month }}</div>
                        <div class="subheaders ">
                            <span class="mx-8" v-for="(weekHeader, weekIndex) in monthData.weeks" :key="weekIndex">{{ weekHeader
                            }}</span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td v-for="(monthData, monthIndex) in tableData" :key="monthIndex">
                        <div class="values">
                          <span
                            v-for="(weekValue, weekIndex) in monthData.values"
                            :key="weekIndex"
                            class="value mx-8"
                          >{{ weekValue }}</span>
                        </div>
                      </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tableData: [
                {
                    month: 'January',
                    weeks: ['Week 1', 'Week 2', 'Week 3'],
                    values: [10, 15, 20],
                },
                {
                    month: 'February',
                    weeks: ['Week 1', 'Week 2', 'Week 3'],
                    values: [12, 18, 25],
                },
                {
                    month: 'March',
                    weeks: ['Week 1', 'Week 2', 'Week 3'],
                    values: [14, 22, 30],
                },
            ],
        };
    },
};
</script>

<style scoped>
.table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
}

.gray-header {
  background-color: #ccc;
  text-align: center;
  border: 1px solid #000;
}

.subheader {
  background-color: #ddd;
  text-align: left;
  border: 1px solid #000;
}

td {
  text-align: left;
  border: 1px solid #000;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}
</style>




