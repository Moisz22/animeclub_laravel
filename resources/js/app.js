require('./bootstrap');

import Alpine from 'alpinejs';

window.jquery = require('jquery');
window.Swal = require('sweetalert2'); 

window.Alpine = Alpine;

Alpine.start();

$(document).ready( function()
{
    $('.datatable').DataTable({ language: { url: '/json/datatables_spanish.json' },responsive:true });
})

