require('./bootstrap');

import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';
import colorLib from '@kurkle/color';

window.Alpine = Alpine;
window.Chart = Chart;
window.colorLib = colorLib;

Alpine.start();
