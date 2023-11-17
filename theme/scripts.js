/**
 * @file
 * Custom scripts for PHP MVC.
 *
 * @see https://github.com/fiduswriter/Simple-DataTables
 * @see https://github.com/chinchang/hint.css
 */

import { DataTable } from "simple-datatables";
import "hint.css";

// Responsive menu.
const navbarToggler = document.querySelector('.navbar-toggler');
if (navbarToggler) {
  navbarToggler.addEventListener('click', e => {
    document.querySelector('.nav-main').classList.toggle('open')
  })
}

// Datatable in dashboard.
const dataTable = new DataTable("#users-list");
