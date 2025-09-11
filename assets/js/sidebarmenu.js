document.addEventListener('DOMContentLoaded', () => {
  const STORAGE_KEY = "activeMenu";
  const SCROLL_PADDING = 80;
  const container = document.querySelector('.scroll-sidebar');
  const links = Array.from(document.querySelectorAll('#sidebarnav a.sidebar-link'));

  if (!links.length) return;

  // Helper to remove active classes
  const clearActive = () => {
    links.forEach(a => a.classList.remove('active'));
    document.querySelectorAll('#sidebarnav li').forEach(li => li.classList.remove('selected'));
    document.querySelectorAll('#sidebarnav ul').forEach(ul => ul.classList.remove('in'));
  };

  // Helper to activate a link
  const activateLink = (link) => {
    clearActive();
    link.classList.add('active');
    let li = link.closest('li');
    if (li) li.classList.add('selected');
    let ul = link.closest('ul');
    if (ul) ul.classList.add('in');

    if (container) {
      const offset = link.offsetTop - container.offsetTop - SCROLL_PADDING;
      container.scrollTop = offset;
    }

    // Save in localStorage
    const href = link.getAttribute('href');
    if (href && !href.startsWith('#') && !href.startsWith('javascript:')) {
      localStorage.setItem(STORAGE_KEY, href);
    }
  };

  // Try to restore from localStorage first
  let savedHref = localStorage.getItem(STORAGE_KEY);
  let bestLink = savedHref ? links.find(a => a.getAttribute('href') === savedHref) : null;

  // If no saved link, fallback to URL detection
  if (!bestLink) {
    const normalize = s => (s || '').toLowerCase().replace(/^\/+|\/+$/g, '');
    const curPath = normalize(window.location.pathname);
    const curFile = curPath.split('/').filter(Boolean).pop() || '';

    let bestScore = -1;
    links.forEach(link => {
      let href = link.getAttribute('href');
      if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;

      let url;
      try { url = new URL(href, window.location.origin + '/'); }
      catch (e) { return; }

      const hrefPath = normalize(url.pathname);
      const hrefFile = hrefPath.split('/').filter(Boolean).pop() || '';
      let score = 0;

      if (hrefPath === curPath) score = 100;
      else if (hrefFile === curFile) score = 90;
      else if (curPath.includes(hrefFile)) score = 50;

      if (score > bestScore) {
        bestScore = score;
        bestLink = link;
      }
    });

    // fallback to add_user.php if nothing matched
    if (!bestLink && curFile === '') {
      bestLink = document.querySelector('#sidebarnav a[href*="add_user.php"]');
    }
  }

  if (bestLink) activateLink(bestLink);

  // Save click events
  links.forEach(link => {
    link.addEventListener('click', (e) => activateLink(link));
  });
});
