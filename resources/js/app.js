const closeSidebar = () => {
    document.getElementById('sidebar')?.classList.remove('sidebar-open');
    document.querySelector('.sidebar-scrim')?.remove();
};

window.toggleSidebar = () => {
    const sidebar = document.getElementById('sidebar');
    if (!sidebar || window.innerWidth >= 768) return;

    const isOpen = sidebar.classList.toggle('sidebar-open');
    if (!isOpen) {
        closeSidebar();
        return;
    }

    const scrim = document.createElement('button');
    scrim.type = 'button';
    scrim.className = 'sidebar-scrim';
    scrim.setAttribute('aria-label', 'Cerrar menú');
    scrim.addEventListener('click', closeSidebar);
    document.body.appendChild(scrim);
};

window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) closeSidebar();
});
