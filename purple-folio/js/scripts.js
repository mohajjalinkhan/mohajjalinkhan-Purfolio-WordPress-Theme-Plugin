/* =========================================================
   Purfolio Theme 2026 — frontend scripts
   ========================================================= */
(function () {
  'use strict';

  var isElementorEdit = !!(
    (window.elementorFrontend && window.elementorFrontend.isEditMode && window.elementorFrontend.isEditMode()) ||
    document.body.classList.contains('elementor-editor-active') ||
    window.location.href.indexOf('elementor-preview=') !== -1
  );

  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var $ = function (s, r) { return (r || document).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };

  // ---------- Year ----------
  var yearEl = $('#year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  // ---------- Navigation ----------
  var pages = ['home', 'work', 'about', 'blog', 'contact'];
  var hasBuiltInPages = pages.some(function (p) { return !!document.getElementById('page-' + p); });

  function showPage(name) {
    if (!hasBuiltInPages) return;
    if (pages.indexOf(name) === -1) name = 'home';
    pages.forEach(function (p) {
      var el = document.getElementById('page-' + p);
      if (el) el.classList.toggle('active', p === name);
    });
    $$('[data-nav]').forEach(function (a) {
      var isActive = a.getAttribute('data-nav') === name;
      a.classList.toggle('active', isActive);
      // Also sync WordPress's server-rendered <li> current classes so the
      // pill doesn't stay stuck on the initially-current item (e.g. Home).
      var li = a.closest('li');
      if (li) {
        li.classList.toggle('current-menu-item', isActive);
        if (!isActive) {
          li.classList.remove('current-menu-ancestor', 'current_page_item', 'current-menu-parent');
        }
      }
    });

    window.scrollTo({ top: 0, behavior: 'auto' });
    setTimeout(function () { scanAnims(); initCounters(); }, 30);
  }

  function currentPageFromHash() {
    return (location.hash || '#home').replace('#', '').trim() || 'home';
  }

  function currentPageFromPath() {
    var path = window.location.pathname.replace(/^\/+|\/+$/g, '');
    if (!path) return 'home';
    var slug = path.split('/').pop();
    return pages.indexOf(slug) !== -1 ? slug : '';
  }

  function syncNavActive(name) {
    if (!name) return;
    $$('[data-nav]').forEach(function (a) {
      var isActive = a.getAttribute('data-nav') === name;
      a.classList.toggle('active', isActive);
      var li = a.closest('li');
      if (li) {
        li.classList.toggle('current-menu-item', isActive);
        li.classList.toggle('current_page_item', isActive);
        if (!isActive) li.classList.remove('current-menu-ancestor', 'current-menu-parent');
      }
    });
  }

  if (!isElementorEdit) {
    $$('[data-nav]').forEach(function (a) {
      a.addEventListener('click', function (e) {
        var target = a.getAttribute('data-nav');
        var href = a.getAttribute('href') || '';
        var hashOnly = href.charAt(0) === '#';
        if (target && hashOnly && hasBuiltInPages) {
          e.preventDefault();
          location.hash = '#' + target;
        }
      });
    });

    window.addEventListener('hashchange', function () {
      if (hasBuiltInPages) showPage(currentPageFromHash());
      closeMobileNav();
    });
  }

  // ---------- Mobile menu ----------
  function closeMobileNav(root) {
    var scope = root || document;
    $$('.menu-toggle.open', scope).forEach(function (btn) {
      btn.classList.remove('open');
      btn.setAttribute('aria-expanded', 'false');
    });
    $$('.nav-mobile.open', scope).forEach(function (nav) { nav.classList.remove('open'); });
  }

  function initMobileMenus(root) {
    $$('.menu-toggle', root || document).forEach(function (toggle) {
      if (toggle.dataset.mobileMenuBound || toggle.dataset.pfwMobileBound) return;
      toggle.dataset.mobileMenuBound = '1';
      toggle.dataset.pfwMobileBound = '1';

      var targetId = toggle.getAttribute('aria-controls') || 'navMobile';
      var navMobile = document.getElementById(targetId) || $('.nav-mobile', toggle.closest('.site-header') || document);
      if (!navMobile) return;

      toggle.setAttribute('aria-expanded', navMobile.classList.contains('open') ? 'true' : 'false');
      toggle.addEventListener('click', function (e) {
        e.stopPropagation();
        var willOpen = !navMobile.classList.contains('open');
        closeMobileNav(document);
        toggle.classList.toggle('open', willOpen);
        toggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
        navMobile.classList.toggle('open', willOpen);
      });

      navMobile.addEventListener('click', function (e) {
        if (e.target && e.target.closest('a')) closeMobileNav(document);
      });
    });
  }

  document.addEventListener('click', function (e) {
    if (e.target.closest('.nav-mobile') || e.target.closest('.menu-toggle')) return;
    closeMobileNav(document);
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeMobileNav(document);
  });

  // ---------- Typing effect ----------
  function bindTyping(el) {
    if (el.dataset.typingBound) return;
    el.dataset.typingBound = '1';
    var raw = el.getAttribute('data-phrases') || el.textContent || '';
    var phrases = raw.split('|').map(function (s) { return s.trim(); }).filter(Boolean);
    if (!phrases.length) phrases = ['Yousuf Zai', 'WordPress Developer'];
    if (reduceMotion || isElementorEdit) { el.textContent = phrases[0]; return; }
    var i = 0, c = 0, deleting = false;
    el.textContent = '';
    function tick() {
      var cur = phrases[i];
      if (!deleting) {
        c++; el.textContent = cur.slice(0, c);
        if (c === cur.length) { deleting = phrases.length > 1; return setTimeout(tick, 1600); }
        setTimeout(tick, 70);
      } else {
        c--; el.textContent = cur.slice(0, c);
        if (c === 0) { deleting = false; i = (i + 1) % phrases.length; return setTimeout(tick, 280); }
        setTimeout(tick, 38);
      }
    }
    setTimeout(tick, 350);
  }
  function initTyping() {
    var nodes = $$('#typing, .typing, [data-typing]');
    nodes.forEach(bindTyping);
  }

  // ---------- Scroll reveal ----------
  var animIO;
  function scanAnims() {
    var scope = hasBuiltInPages && $('.page.active') ? '.page.active ' : '';
    var nodes = $$(scope + '[data-anim]:not(.in), .pfw-animate:not(.in), .pfw-tl-row:not(.in), .pfw-fade-up:not(.in)');
    if (reduceMotion || !('IntersectionObserver' in window)) {
      nodes.forEach(function (n) { n.classList.add('in'); });
      return;
    }
    if (!animIO) {
      animIO = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            var el = entry.target;
            var delay = parseInt(el.getAttribute('data-anim-delay') || '0', 10);
            setTimeout(function () { el.classList.add('in'); }, delay);
            animIO.unobserve(el);
          }
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
    }
    nodes.forEach(function (n) { animIO.observe(n); });
  }

  // ---------- Counter animation ----------
  var countIO;
  function initCounters() {
    var nodes = $$('[data-count]:not([data-count-done])');
    if (!nodes.length) return;
    if (!('IntersectionObserver' in window)) {
      nodes.forEach(function (el) {
        el.textContent = el.getAttribute('data-count') + (el.getAttribute('data-suffix') || '');
        el.setAttribute('data-count-done', '1');
      });
      return;
    }
    if (!countIO) {
      countIO = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          var el = entry.target;
          if (el.getAttribute('data-count-done')) return;
          el.setAttribute('data-count-done', '1');
          var target = parseFloat(el.getAttribute('data-count')) || 0;
          var suffix = el.getAttribute('data-suffix') || '';
          var start = performance.now();
          function tick(now) {
            var p = Math.min(Math.max((now - start) / 1600, 0), 1);
            var eased = 1 - Math.pow(1 - p, 4);
            el.textContent = Math.round(eased * target) + suffix;
            if (p < 1) requestAnimationFrame(tick);
          }
          requestAnimationFrame(tick);
          countIO.unobserve(el);
        });
      }, { threshold: 0.3 });
    }
    nodes.forEach(function (n) { countIO.observe(n); });
  }

  // ---------- Magnetic tilt on cards ----------
  function initTilt() {
    if (reduceMotion) return;
    // Only on devices with fine pointer (desktop) to keep touch smooth
    if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
    if (document.body.dataset.tiltBound) return;
    document.body.dataset.tiltBound = '1';

    function bind(el, max) {
      el.addEventListener('pointermove', function (e) {
        var r = el.getBoundingClientRect();
        var x = (e.clientX - r.left) / r.width - 0.5;
        var y = (e.clientY - r.top) / r.height - 0.5;
        el.style.setProperty('--ry', (x * max) + 'deg');
        el.style.setProperty('--rx', (-y * max) + 'deg');
      });
      el.addEventListener('pointerleave', function () {
        el.style.setProperty('--ry', '0deg');
        el.style.setProperty('--rx', '0deg');
      });
    }
    $$('.card, .work-card, .project, .pfw-post-card').forEach(function (el) { bind(el, 6); });
  }

  // ---------- Hero art parallax ----------
  function initParallax() {
    if (reduceMotion) return;
    if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
    var art = $('.hero-art img');
    if (!art) return;
    var raf = 0, tx = 0, ty = 0;
    window.addEventListener('pointermove', function (e) {
      var w = window.innerWidth, h = window.innerHeight;
      tx = ((e.clientX / w) - 0.5) * 18;
      ty = ((e.clientY / h) - 0.5) * 18;
      if (!raf) raf = requestAnimationFrame(function () {
        art.style.setProperty('--px', tx.toFixed(2) + 'px');
        art.style.setProperty('--py', ty.toFixed(2) + 'px');
        raf = 0;
      });
    });
  }

  // ---------- Contact form ----------
  var form = $('#contactForm');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var btn = $('#submitBtn');
      if (btn) {
        var original = btn.textContent;
        btn.textContent = '✓ Sent — talk soon!';
        btn.disabled = true;
        setTimeout(function () { btn.textContent = original; btn.disabled = false; }, 4000);
      }
      form.reset();
    });
  }

  // ---------- Boot ----------
  function boot() {
    initTyping();
    initMobileMenus(document);
    if (isElementorEdit) {
      $$('[data-anim], .pfw-animate, .pfw-fade-up').forEach(function (el) { el.classList.add('in'); });
      initCounters();
      return;
    }
    if (hasBuiltInPages) showPage(currentPageFromHash());
    else syncNavActive(currentPageFromPath());
    scanAnims();
    initCounters();
    initTilt();
    initParallax();
    initHeaderScroll();
  }

  function bootElementorWidget(scope) {
    initTyping();
    initMobileMenus(scope && scope[0] ? scope[0] : document);
    if (isElementorEdit) {
      $$('[data-anim], .pfw-animate, .pfw-fade-up').forEach(function (el) { el.classList.add('in'); });
    } else {
      scanAnims();
    }
    initCounters();
  }


  // ---------- Header shrink on scroll ----------
  function initHeaderScroll() {
    var header = document.querySelector('.site-header');
    if (!header) return;
    var ticking = false;
    function onScroll() {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function () {
        header.classList.toggle('scrolled', window.scrollY > 12);
        ticking = false;
      });
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }



  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
  else boot();

  if (window.elementorFrontend && window.elementorFrontend.hooks) {
    window.elementorFrontend.hooks.addAction('frontend/element_ready/global', bootElementorWidget);
  }
})();
