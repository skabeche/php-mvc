/**
 * @file
 * Custom scripts for PHP MVC.
 *
 */

// Responsive menu.
const navbarToggler = document.querySelector('.navbar-toggler');
navbarToggler.addEventListener('click', e => {
  document.querySelector('.nav-main').classList.toggle('open')
})
