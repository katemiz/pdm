document.addEventListener('DOMContentLoaded', function () {
  const hamburger = document.getElementById('navbar-toggle');
  const menu = document.getElementById('menu');

  const dropdownButton = document.getElementById('dropdownNavbarLink');
  const dropdownMenu = document.getElementById('dropdownNavbar');




  dropdownButton.addEventListener('click', () => {
    dropdownMenu.classList.toggle('hidden');
  });

  hamburger.addEventListener('click', function () {
    menu.classList.toggle('hidden');
  });





  // USER DROPDOWN
  const userMenuButton = document.getElementById('userMenuButton');
  const userMenu = document.getElementById('userMenu');

  userMenuButton.addEventListener('mouseover', () => {
    userMenu.classList.toggle('hidden');
  });

  userMenu.addEventListener('mouseout', () => {
    userMenu.classList.toggle('hidden');
  });






  // Child Dropdown
  // const childDropdownButton = document.getElementById('dropdownNavbarLink');
  // const doubleDropdown = document.getElementById('dropdownNavbar');

  // doubleDropdown.addEventListener('click', () => {
  //   dropdownMenu.classList.toggle('hidden');
  // });





});
