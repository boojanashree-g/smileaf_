// window.addEventListener('load', function () {
//     const logoImg = document.getElementById('site-logo-img');
//     const logoWrapper = document.querySelector('.site-logo');
//     const headerSticky = document.querySelector('.ltn__header-sticky');
//     const menuColumn = document.querySelector('.header-menu-column.menu-color-white');
//     const headerIcons = document.querySelector('.ltn__header-options.ltn__header-options-2');

//     if (!logoImg || !logoWrapper || !menuColumn || !headerIcons) return;

//     const path = window.location.pathname;
//     const pathSegments = path.split('/').filter(Boolean);
//     const basePath = pathSegments.length > 0 ? '/' + pathSegments[0] + '/' : '/';
//     const isHome = (path === basePath || path === basePath + 'index.php');

//     const logoDefault = logoWrapper.getAttribute('data-logo-default');
//     const logoWhite = logoWrapper.getAttribute('data-logo-white');

//     function updateLogo() {
//         if (!isHome) {
//             logoImg.src = logoWhite;
//             menuColumn.querySelectorAll('ul li a').forEach(link => {
//                 link.style.color = '#fff';
//             });
//             headerIcons.querySelectorAll('.header-search-1 i, i.icon-user, i.icon-shopping-cart').forEach(icon => {
//                 icon.style.color = '#fff';
//             });


//             if (headerSticky && headerSticky.classList.contains('sticky-active')) {
//                 logoImg.src = logoDefault;
//                 menuColumn.querySelectorAll('ul li a').forEach(link => {
//                     link.style.color = '#000';
//                 });
//                 headerIcons.querySelectorAll('.header-search-1 i,i.icon-user, i.icon-shopping-cart').forEach(icon => {
//                     icon.style.color = '#000';
//                 });
//             }
//         } else {
//             logoImg.src = logoDefault;
//             menuColumn.querySelectorAll('ul li a').forEach(link => {
//                 link.style.color = '';
//             });
//             headerIcons.querySelectorAll('.header-search-1 i').forEach(icon => {
//                 icon.style.color = '';
//             });
//         }
//     }

//     updateLogo();
//     window.addEventListener('scroll', updateLogo);
// });
