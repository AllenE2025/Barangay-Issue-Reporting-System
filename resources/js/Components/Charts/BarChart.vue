<script setup lang="ts">
import { Bar } from 'vue-chartjs';
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend
} from 'chart.js';

ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend
);

interface Props {
    data: {
        labels: string[];
        datasets: {
            label: string;
            data: number[];
            backgroundColor: string[];
        }[];
    };
}

defineProps<Props>();
</script>

<template>
    <Bar :data="data" :options="{
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }" />
</template>