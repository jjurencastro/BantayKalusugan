import './bootstrap';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll('[data-date-picker]').forEach((input) => {
		flatpickr(input, {
			dateFormat: 'Y-m-d',
			altInput: true,
			altFormat: 'F j, Y',
			disableMobile: true,
		});
	});
});
