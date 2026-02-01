<script setup lang="ts">
import { Doughnut } from 'vue-chartjs';
import {
    Chart as ChartJS,
    ArcElement,
    Tooltip,
    Legend
} from 'chart.js';

ChartJS.register(ArcElement, Tooltip, Legend);

interface Props {
    data: {
        labels: string[];
        datasets: {
            data: number[];
            backgroundColor: string[];
        }[];
    };
}

defineProps<Props>();
</script>

<template>
    <Doughnut :data="data" :options="{
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }" />
</template>