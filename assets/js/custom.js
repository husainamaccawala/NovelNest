// const element = document.querySelectorAll('.flatpickr-calendar');

// element.forEach(e => {
//     e.classList.add('custom-flatpickr')
// });


document.addEventListener('DOMContentLoaded', () => {
    const sidebarLinks = document.querySelectorAll('#sidebar-menu .nav-link');
    const currentPath = window.location.pathname;

    sidebarLinks.forEach(link => {
      const linkPath = link.getAttribute('href').replace(/^.*\/\/[^\/]+/, '');

      if (currentPath === linkPath) {
        link.classList.add('active');
        const parentDropdown = link.closest('.nav-item.iq-drop');
        if (parentDropdown) {
          const collapseElement = parentDropdown.querySelector('.collapse');
          collapseElement?.classList.add('show');
          const parentLink = parentDropdown.querySelector('[data-bs-toggle="collapse"]');
          parentLink?.setAttribute('aria-expanded', 'true');
          parentLink?.classList.add('active');
        }
      }

      link.addEventListener('click', event => {
        if (link.closest('.sub-nav')) {
          event.stopPropagation();
        }

        sidebarLinks.forEach(navLink => navLink.classList.remove('active'));
        link.classList.add('active');

        const parentDropdown = link.closest('.nav-item.iq-drop');
        if (parentDropdown) {
          const collapseElement = parentDropdown.querySelector('.collapse');
          collapseElement?.classList.add('show');
          const parentLink = parentDropdown.querySelector('[data-bs-toggle="collapse"]');
          parentLink?.setAttribute('aria-expanded', 'true');
          parentLink?.classList.add('active');
        }
      });
    });
  });