import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import 'leaflet/dist/leaflet.css';
import L from 'leaflet';
window.L = L;

import Chart from 'chart.js/auto';
window.Chart = Chart;