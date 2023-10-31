/**
 * @file
 * Custom scripts for PHP MVC.
 *
 */

// Import images as Vite does not procesours PHP-computed images with dynamic variables.
// see ./partials/message.php.
import './images/message-error.svg';
import './images/message-success.svg';
import './images/message-warning.svg';

// Responsive menu.
const navbarToggler = document.querySelector('.navbar-toggler');
navbarToggler.addEventListener('click', e => {
  document.querySelector('.nav-main').classList.toggle('open')
})
