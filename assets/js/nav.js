'use strict';

// mobile side navigation
function toggleSideNav() {
    document.getElementById('side-nav').classList.toggle('active');
}

function closeSideNav() {
    document.getElementById('side-nav').classList.remove('active');
}

document.getElementById('nav-toggler').onclick = toggleSideNav;
