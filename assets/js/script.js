// mobile side navigation
function toggleSideNav() {
    document.getElementById('side-nav').classList.toggle('active');
}

document.getElementById('nav-toggler').onclick = toggleSideNav;
document.getElementById('side-nav-overlay').onclick = toggleSideNav;

// page-wrapper control
const point = document.getElementById('point');
let currentPoint = 0;
let pointChanging = false;

function changeActivePoint(index) {
    if (pointChanging || index < 0 || index > 4) return;

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
    switch (event.which) {
        case 38: // up
            changeActivePoint(currentPoint - 1);
            break;
        case 40: // down
            changeActivePoint(currentPoint + 1);
            break;
        default: return;
    }
}

// handling page transition
const logo = document.getElementById('logo');
const square = document.getElementById('square');
const main = document.getElementById('main-page');

function changePage(index) {
    if (currentPoint === 0) {
        logo.classList.remove('hide-bg')
        square.classList.add('hidden');
    } else if (index === 0) {
        logo.classList.add('hide-bg')
        square.classList.remove('hidden');
    }

    main.children[currentPoint].classList.remove('active');
    if (currentPoint < index) {
        main.children[currentPoint].classList.add('fade-up');
    } else {
        main.children[currentPoint].classList.add('fade-down');
    }

    setTimeout(() => {
        main.children[currentPoint].classList.add('hidden');
        main.children[index].classList.remove('hidden');
        main.children[index].classList.add('active');
        main.children[index].classList.remove('fade-up');
        main.children[index].classList.remove('fade-down');
    }, 500);
}
