/**
 * @file
 * Custom scripts for PHP MVC.
 *
 */
import { DataTable } from "simple-datatables";

// Responsive menu.
const navbarToggler = document.querySelector('.navbar-toggler');
navbarToggler.addEventListener('click', e => {
  document.querySelector('.nav-main').classList.toggle('open')
})

// Datatable in dashboard.
const dataTable = new DataTable("#users-list");
