<template>
    <div class="bar-container">
        <vue-apex-charts ref="chart" :options="chartOptions" :series="series"></vue-apex-charts>
    </div>
</template>

<script setup>

import VueApexCharts from "vue3-apexcharts";
import { reactive, computed, watch, inject } from "vue";

let props = defineProps({
    data: Object,
    labels: Object,
    backgrounds: Object,
    name: String,
})

let chartOptions = reactive({
    colors : props.backgrounds,
    chart: {
        type: 'bar',
    },
    plotOptions: {
        bar: {
            horizontal: false,
            borderRadius: 4,
           // columnWidth: '65%',
            endingShape: 'rounded',
        },
    },
    xaxis: {
        labels: {
            show: false
        }
    },
    yaxis: {
        labels: {
            show: true,
            formatter: function (val) {
                return val.toFixed(1)// + "ms"
            }
        }
    },
    dataLabels: {
        enabled: false,
    }
});

let series = [{
    name: props.name,
    data: props.data
}];



</script>
