// resources/js/department.js

import { imprimerPDF } from './main.js'; // Adjust the path as per your actual setup

$(document).ready(function () {
    // Form validation and submission handling
    $('#formNoteFrais').on('submit', function (event) {
        if (!this.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        $(this).addClass('was-validated');
    });

    // Ensure departmentFilter element exists before adding event listener
    var departmentFilter = document.getElementById('departmentFilter');
    if (departmentFilter) {
        // Add event listener for input change
        departmentFilter.addEventListener('input', filterDepartments);
        }
    // } else {
    //     console.error('Element with id "departmentFilter" not found.');
    // }

    // Event listener for "Imprimer" button clicks
    $('.imprimer-btn').on('click', function () {
        var date = $(this).data('date');
        var trajet = $(this).data('trajet');
        var motif = $(this).data('motif');
        var hebergement = $(this).data('hebergement');
        var repas = $(this).data('repas');
        var justificatif = $(this).data('justificatif');
        var pieceJointe = $(this).data('piece');

        // Call imprimerPDF function with data
        imprimerPDF(date, trajet, motif, hebergement, repas, justificatif, pieceJointe);
    });

    // Function to filter departments
    function filterDepartments() {
        // Example filtering logic (replace with your actual logic)
        var filterValue = departmentFilter.value.trim().toLowerCase();
        var departmentItems = document.querySelectorAll('.department-item');
        
        departmentItems.forEach(function (item) {
            var departmentName = item.querySelector('.card-title').textContent.trim().toLowerCase();
            var isVisible = departmentName.includes(filterValue);
            item.style.display = isVisible ? '' : 'none';
        });
    }

    // Other scripts or functions as needed
});
