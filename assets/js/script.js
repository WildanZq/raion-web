'use strict';
// mobile side navigation
function toggleSideNav() {
    document.getElementById('side-nav').classList.toggle('active');
}

function closeSideNav() {
    document.getElementById('side-nav').classList.remove('active');
}

document.getElementById('nav-toggler').onclick = toggleSideNav;
document.getElementById('side-nav-overlay').onclick = toggleSideNav;

// page-wrapper control
const point = document.getElementById('point');
let currentPoint = 0;
let pointChanging = false;
let isHome = false;

function changeActivePoint(index) {
    if (pointChanging || index < 0 || index > 4 || !isHome) return;

    pointChanging = true;
    point.children[currentPoint].classList.remove('active');
    point.children[index].classList.add('active');
    changePage(index);
    
    setTimeout(() => {
        currentPoint = index;
        pointChanging = false;
    }, 1000);
}

for (let index = 0; index < point.children.length; index++) {
    point.children[index].onclick = () => changeActivePoint(index);
}

window.addEventListener('wheel', function (event) {
    if (event.deltaY < 0) { // up
        changeActivePoint(currentPoint - 1);
    } else if (event.deltaY > 0) { // down
        changeActivePoint(currentPoint + 1);
    }
});

let ts;
document.ontouchstart = function(event) {
    ts = event.touches[0].clientY;
}
document.ontouchend = function(event) {
    let te = event.changedTouches[0].clientY;
    if (ts > te + 100) { // down
        changeActivePoint(currentPoint + 1);
    } else if (ts < te - 100) { // up
        changeActivePoint(currentPoint - 1);
    }
}

document.onkeydown = function(event) {
    switch (event.key) {
        case "Down":
        case "ArrowDown":
            changeActivePoint(currentPoint + 1);
            break;
        case "Up":
        case "ArrowUp":
            changeActivePoint(currentPoint - 1);
            break;
        default: return;
    }
}

// handling page transition
const logo = document.getElementById('logo');
const square = document.getElementById('square');
const main = document.getElementById('main-page');
const navHome = document.getElementsByClassName('nav-home');
const footer = document.getElementById('footer');

logo.onclick = () => changeActivePoint(0);
for (let i = 0; i < navHome.length; i++) {
    navHome.item(i).onclick = () => {
        closeSideNav();
        changeActivePoint(0);
    };
}

function changePage(index) {
    if (currentPoint === 0) {
        logo.classList.remove('hide-bg');
        square.classList.add('hidden');
    } else if (currentPoint === 3) {
        logo.classList.remove('hide-bg');
        point.classList.remove('text-white');
        square.classList.remove('full-screen');
    } else if (currentPoint === 4) {
        footer.classList.remove('show');
    }

    if (index === 0) {
        logo.classList.add('hide-bg');
        square.classList.remove('hidden');
    } else if (index === 3) {
        logo.classList.add('hide-bg');
        point.classList.add('text-white');
        square.classList.add('full-screen');
    } else if (index === 4) {
        footer.classList.add('show');
    }

    main.children[currentPoint].classList.remove('active');
    if (currentPoint < index) {
        main.children[currentPoint].classList.add('fade-up');
        main.children[index].classList.add('fade-down');
        main.children[index].classList.remove('fade-up');
    } else {
        main.children[currentPoint].classList.add('fade-down');
        main.children[index].classList.add('fade-up');
        main.children[index].classList.remove('fade-down');
    }

    setTimeout(() => {
        main.children[currentPoint].classList.add('hidden');
        main.children[index].classList.remove('hidden');
        main.children[index].classList.add('active');
        main.children[index].classList.remove('fade-up');
        main.children[index].classList.remove('fade-down');
    }, 500);
}

// handling page change
let pageChanging = false;

document.addEventListener("DOMContentLoaded", function () {
    var page = window.location.hash.substr(1);
    loadPage(page);
});

window.onhashchange = function() {
    var page = window.location.hash.substr(1);
    loadPage(page);
}

function loadPage(page) {
    if (pageChanging) return;
    closeSideNav();
    pageChanging = true;

    const pageContainer = document.getElementById('more-page');
    pageContainer.classList.remove('show');
    
    if (page != 'member' && page != 'about') {
        isHome = true;
        changeActivePoint(currentPoint);
        setTimeout(() => {
            main.classList.remove('hidden');
            pageContainer.classList.add('hidden');
            pageChanging = false;
        }, 500);
        return;
    } else {
        isHome = false;
    }

    window.onkeydown = function(event) {
        switch (event.key) {
            case "Esc":
            case "Escape":
                window.location.href = '#home';
                break;
            default: return;
        }
    }

    logo.classList.remove('hide-bg');

    main.classList.add('hidden');
    pageContainer.classList.remove('hidden');
    pageContainer.classList.add('show');

    pageContainer.innerHTML = `
        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    `;

    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        pageChanging = false;
        if (this.readyState == 4) {
            if (this.status == 200) {
                pageContainer.innerHTML = xhttp.responseText;
            } else if (this.status == 404) {
                pageContainer.innerHTML = `
                    <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                        <p>Halaman tidak ditemukan.</p>
                    </div>
                `;
            } else {
                pageContainer.innerHTML = `
                    <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                        <p>Ups.. halaman tidak dapat diakses.</p>
                    </div>
                `;
            }
        }
    };
    xhttp.open("GET", page + ".html", true);
    xhttp.send();
}
