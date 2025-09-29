const sidebar = document.getElementById('sidebar');
const toggleSidebarMobileEl = document.getElementById('toggleSidebarMobile');
const sidebarBackdrop = document.getElementById('sidebarBackdrop');
const toggleSidebarMobileHamburger = document.getElementById('toggleSidebarMobileHamburger');
const toggleSidebarMobileClose = document.getElementById('toggleSidebarMobileClose');
const toggleSidebarMobileSearch = document.getElementById('toggleSidebarMobileSearch');

const toggleSidebarMobile = (sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose) => {
    sidebar.classList.toggle('hidden');
    sidebarBackdrop.classList.toggle('hidden');
    toggleSidebarMobileHamburger.classList.toggle('hidden');
    toggleSidebarMobileClose.classList.toggle('hidden');
};

if (
    sidebar &&
    sidebarBackdrop &&
    toggleSidebarMobileHamburger &&
    toggleSidebarMobileClose
) {
    if (toggleSidebarMobileSearch) {
        toggleSidebarMobileSearch.addEventListener('click', () => {
            toggleSidebarMobile(sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose);
        });
    }

    if (toggleSidebarMobileEl) {
        toggleSidebarMobileEl.addEventListener('click', () => {
            toggleSidebarMobile(sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose);
        });
    }

    sidebarBackdrop.addEventListener('click', () => {
        toggleSidebarMobile(sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose);
    });
}
