let menu = document.querySelector('#menu-icon');
let navbar = document.querySelector('.navbar');

menu.onclick = () => {
    menu.classList.toggle('fa-bars');
    menu.classList.toggle('fa-times');
	navbar.classList.toggle('open');
}
