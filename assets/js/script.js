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
document.ontouchstart = function (event) {
    ts = event.touches[0].clientY;
}
document.ontouchend = function (event) {
    let te = event.changedTouches[0].clientY;
    if (ts > te + 100) { // down
        changeActivePoint(currentPoint + 1);
    } else if (ts < te - 100) { // up
        changeActivePoint(currentPoint - 1);
    }
}

document.onkeydown = function (event) {
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
    if (page.indexOf('/') !== -1) {
        const pages = page.split('/');
        loadPage(pages[0], pages[1]);
    } else {
        loadPage(page);
    }
});

window.onhashchange = function () {
    var page = window.location.hash.substr(1);
    if (page.indexOf('/') !== -1) {
        const pages = page.split('/');
        loadPage(pages[0], pages[1]);
    } else {
        loadPage(page);
    }
}

function loadPage(page, args) {
    if (pageChanging) return;
    closeSideNav();
    pageChanging = true;

    const pageContainer = document.getElementById('more-page');
    pageContainer.classList.remove('show');

    if (page != 'member' && page != 'about' && page != 'product') {
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

    window.onkeydown = function (event) {
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
                if (page === 'member') {
                    generateMemberPage();
                }
                if (page === 'product') {
                    generateProductPage(args);
                }
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

function generateMemberPage() {
    fetch('./db.json').then(r => r.json()).then(DATA => {
        const members = DATA.member;
        let img = document.createElement('div');
        img.classList.add('member-img', 'bg-cover', 'mb-3');
        let name = document.createElement('h2');
        name.classList.add('h4');
        let title = document.createElement('p')
        title.classList.add('w-100');

        members.core.forEach(member => {
            const id = member.title.split(' ')[0].toLowerCase();
            const elem = document.getElementById(id);
            if (member.img)
                img.setAttribute('style', `background-image: url("./assets/img/member/foto raion/${member.img}")`);
            else img.removeAttribute('style');
            name.innerText = member.name;
            title.innerText = member.title;
            elem.appendChild(img.cloneNode(true));
            elem.appendChild(name.cloneNode(true));
            elem.appendChild(title.cloneNode(true));
        });

        let internalFragment = document.createDocumentFragment();
        members.internal.forEach(divisi => {
            let divisiName = document.createElement('h1');
            divisiName.classList.add('sub-title', 'thin', 'text-md-center', 'ml-4', 'ml-md-0', 'mb-3', 'mb-md-4', 'mt-4');
            divisiName.innerText = `Divisi ${divisi.name}`;

            let container = document.createElement('div');
            container.classList.add('width-controller', 'p-0', 'px-md-5', 'mx-lg-5');
            let margin = document.createElement('div');
            margin.classList.add('mx-md-5', 'pt-3');
            let glide = document.createElement('div');
            glide.classList.add('glide', 'glide-member', 'glide-normal', 'w-100');
            let glideTrack = document.createElement('div');
            glideTrack.classList.add('glide__track');
            glideTrack.setAttribute('data-glide-el', 'track');
            let glideSlides = document.createElement('ul');
            glideSlides.classList.add('glide__slides', 'mb-0');

            let ketua = document.createElement('li');
            ketua.classList.add('glide__slide');
            let slide = document.createElement('div');
            slide.classList.add('text-center', 'd-flex', 'justify-content-start', 'align-items-center', 'flex-column', 'mb-3');
            if (divisi.ketua.img)
                img.setAttribute('style', `background-image: url("./assets/img/member/foto raion/${divisi.ketua.img}")`);
            else img.removeAttribute('style');
            name.innerText = divisi.ketua.name;
            title.innerText = 'Ketua Divisi';
            slide.appendChild(img.cloneNode(true));
            slide.appendChild(name.cloneNode(true));
            slide.appendChild(title.cloneNode(true));
            ketua.appendChild(slide);

            let memberFragment = document.createDocumentFragment();
            divisi.anggota.forEach(member => {
                let slideMember = document.createElement('li');
                slideMember.classList.add('glide__slide');
                let elem = document.createElement('div');
                elem.classList.add('text-center', 'd-flex', 'justify-content-start', 'align-items-center', 'flex-column', 'mb-3');
                if (member.img)
                    img.setAttribute('style', `background-image: url("./assets/img/member/foto raion/${member.img}")`);
                else img.removeAttribute('style');
                name.innerText = member.name;
                title.innerText = 'Anggota';
                elem.appendChild(img.cloneNode(true));
                elem.appendChild(name.cloneNode(true));
                elem.appendChild(title.cloneNode(true));
                slideMember.appendChild(elem);
                memberFragment.appendChild(slideMember);
            });

            glideSlides.appendChild(ketua);
            glideSlides.append(memberFragment);
            glideTrack.appendChild(glideSlides);
            glide.appendChild(glideTrack);
            glide.innerHTML = glide.innerHTML + `
            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left btn btn-secondary" data-glide-dir="<"><</button>
                <button class="glide__arrow glide__arrow--right btn btn-secondary" data-glide-dir=">">></button>
            </div>
            `;
            margin.appendChild(glide);
            container.append(margin);
            internalFragment.appendChild(divisiName);
            internalFragment.appendChild(container);
        });

        const internal = document.getElementById('internal');
        internal.appendChild(internalFragment);

        let fungsionalFragment = document.createDocumentFragment();
        members.fungsional.forEach(divisi => {
            let divisiName = document.createElement('h1');
            divisiName.classList.add('sub-title', 'thin', 'text-md-center', 'ml-4', 'ml-md-0', 'mb-3', 'mb-md-4', 'mt-4');
            divisiName.innerText = `Divisi ${divisi.name}`;

            let container = document.createElement('div');
            container.classList.add('width-controller', 'p-0', 'px-md-5', 'mx-lg-5');
            let list = document.createElement('div');
            list.classList.add('mx-md-5', 'px-4', 'px-md-0', 'row', 'pt-3', 'flex-md-wrap', 'flex-nowrap', 'overflow-auto', 'justify-content-md-center');

            let ketua = document.createElement('div');
            ketua.classList.add('col-7', 'col-md-4', 'col-lg-3', 'text-center', 'd-flex', 'justify-content-start', 'align-items-center', 'flex-column', 'mb-3');
            if (divisi.ketua.img)
                img.setAttribute('style', `background-image: url("./assets/img/member/foto raion/${divisi.ketua.img}")`);
            else img.removeAttribute('style');
            name.innerText = divisi.ketua.name;
            title.innerText = 'Ketua Divisi';
            ketua.appendChild(img.cloneNode(true));
            ketua.appendChild(name.cloneNode(true));
            ketua.appendChild(title.cloneNode(true));

            let memberFragment = document.createDocumentFragment();
            divisi.anggota.forEach(member => {
                let elem = document.createElement('div');
                elem.classList.add('col-7', 'col-md-4', 'col-lg-3', 'text-center', 'd-flex', 'justify-content-start', 'align-items-center', 'flex-column', 'mb-3');
                if (member.img)
                    img.setAttribute('style', `background-image: url("./assets/img/member/foto raion/${member.img}")`);
                else img.removeAttribute('style');
                name.innerText = member.name;
                title.innerText = 'Anggota';
                elem.appendChild(img.cloneNode(true));
                elem.appendChild(name.cloneNode(true));
                elem.appendChild(title.cloneNode(true));
                memberFragment.appendChild(elem);
            });

            list.appendChild(ketua);
            list.appendChild(memberFragment);
            container.appendChild(list);
            fungsionalFragment.appendChild(divisiName);
            fungsionalFragment.appendChild(container);
        });

        const fungsional = document.getElementById('fungsional');
        fungsional.appendChild(fungsionalFragment);
    }).then(_ => {
        const sliders = document.querySelectorAll('.glide-member');
        const conf = {
            perView: window.innerWidth < 768 ? 1.75 : window.innerWidth < 992 ? 3 : 4,
            bound: true,
            gap: 30,
        };
        sliders.forEach(item => {
            new Glide(item, conf).mount();
        });
        window.onresize = function (event) {
            const width = event.target.innerWidth;
            const sliders = document.querySelectorAll('.glide-member');
            const conf = {
                perView: width < 768 ? 1.75 : width < 992 ? 3 : 4,
                bound: true,
                gap: 30,
            };
            sliders.forEach(item => {
                new Glide(item, conf).mount();
            });
            new Glide('.glide-product', {
                perView: width < 768 ? 1 : width < 992 ? 2 : 3,
                bound: true,
                gap: 20,
            }).mount();
        };
    });
}

function generateProductPage(args) {
    fetch('./db.json').then(r => r.json()).then(DATA => {
        const products = DATA.product;
        let product = findById(products, args);

        if (!product) {
            window.location.href = '#home';
        }

        const banner = document.getElementById('img-banner');
        banner.style.backgroundImage = product.img ? `url(./assets/img/product/${product.img})` : 'url(./assets/img/default.jpg)';
        if (!product.img) banner.classList.add('none');

        const name = document.getElementById('product-name');
        name.innerHTML = product.name;
        const desc = document.getElementById('product-desc');
        desc.innerHTML = product.desc;
        const team = document.getElementById('product-team');
        team.innerHTML = `Oleh: ${product.team}`;
        const link = document.getElementById('product-link');
        link.href = product.link ? product.link : '';

        const designer = document.getElementById('designer');
        product.designer.forEach(d => {
            let list = document.createElement('li');
            list.innerText = d;
            designer.appendChild(list);
        });
        const artist = document.getElementById('artist');
        product.artist.forEach(a => {
            let list = document.createElement('li');
            list.innerText = a;
            artist.appendChild(list);
        });
        const programmer = document.getElementById('programmer');
        product.programmer.forEach(p => {
            let list = document.createElement('li');
            list.innerText = p;
            programmer.appendChild(list);
        });

        const sliderList = document.getElementById('glide-product-list');
        product.screenshots.forEach(ss => {
            let img = document.createElement('img');
            img.classList.add('product-ss');
            img.classList.add('glide__slide');
            img.src = `./assets/img/product/${ss}`;
            sliderList.appendChild(img);
        });

        new Glide('.glide-ss', {
            perView: window.innerWidth < 768 ? 1 : window.innerWidth < 992 ? 2 : 3,
            bound: true,
            gap: 20,
        }).mount();
        window.onresize = function (event) {
            const width = event.target.innerWidth;
            new Glide('.glide-ss', {
                perView: width < 768 ? 1 : width < 992 ? 2 : 3,
                bound: true,
                gap: 20,
            }).mount();
            new Glide('.glide-product', {
                perView: width < 768 ? 1 : width < 992 ? 2 : 3,
                bound: true,
                gap: 20,
            }).mount();
        };
    });
}

// get product & member data
fetch('./db.json').then(r => r.json()).then(DATA => {
    generateMember(DATA);
    generateProduct(DATA);
});

function generateMember(DATA) {
    const members = DATA.member.core;
    let img = document.createElement('div');
    img.classList.add('member-img', 'bg-cover', 'mb-3');
    let name = document.createElement('h2');
    name.classList.add('h4');
    let title = document.createElement('p')
    title.classList.add('w-100');

    members.forEach(member => {
        const id = member.title.split(' ')[0].toLowerCase() + '-main';
        const elem = document.getElementById(id);
        if (member.img)
            img.setAttribute('style', `background-image: url("./assets/img/member/foto raion/${member.img}")`);
        else img.removeAttribute('style');
        name.innerText = member.name;
        title.innerText = member.title;
        elem.appendChild(img.cloneNode(true));
        elem.appendChild(name.cloneNode(true));
        elem.appendChild(title.cloneNode(true));
    });
}

function generateProduct(DATA) {
    const products = DATA.product;
    const productWrapper = document.getElementById('product-wrapper');

    let productList = '';
    products.forEach(product => {
        const img = product.img ? `./assets/img/product/${product.img}` : './assets/img/default.jpg';
        productList += `
        <li class="glide__slide product-card card">
            <div class="card-header p-0">
                <div class="product-img bg-cover w-100" style="background-image: url(${img});"></div>
            </div>
            <div class="card-body pt-3">
                <h2 class="h5 text-truncate">${product.name}</h2>
                <p class="text-truncate">${product.desc}</p>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <span class="date text-${product.category === 'App' ? 'success' : 'danger'}">${product.category}</span>
                <a href="#product/${product.id}">More</a>
            </div>
        </li>
        `;
    });

    productWrapper.innerHTML = productList;
    new Glide('.glide-product', {
        perView: window.innerWidth < 768 ? 1 : window.innerWidth < 992 ? 2 : 3,
        bound: true,
        gap: 20,
    }).mount();
    window.onresize = function (event) {
        const width = event.target.innerWidth;
        new Glide('.glide-product', {
            perView: width < 768 ? 1 : width < 992 ? 2 : 3,
            bound: true,
            gap: 20,
        }).mount();
    };
}

// search json id
function findById(data, idToLookFor) {
    for (var i = 0; i < data.length; i++) {
        if (data[i].id == idToLookFor) {
            return (data[i]);
        }
    }
}
