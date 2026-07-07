(function () {
  'use strict';

  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var isElementorEdit = !!(
    (window.elementorFrontend && window.elementorFrontend.isEditMode && window.elementorFrontend.isEditMode()) ||
    document.body.classList.contains('elementor-editor-active') ||
    window.location.href.indexOf('elementor-preview=') !== -1
  );
  var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };

  function mobileMenus(scope) {
    $$('.menu-toggle', scope || document).forEach(function (toggle) {
      // The active theme (Purfolio) already binds mobile menu behavior via
      // scripts.js using `data-mobile-menu-bound`. Binding a second handler
      // here would double-toggle the menu (open then immediately close).
      if (toggle.dataset.pfwMobileBound || toggle.dataset.mobileMenuBound) return;
      toggle.dataset.pfwMobileBound = '1';
      toggle.dataset.mobileMenuBound = '1';
      var targetId = toggle.getAttribute('aria-controls') || 'navMobile';
      var nav = document.getElementById(targetId)
        || (toggle.closest('.site-header') && toggle.closest('.site-header').querySelector('.nav-mobile'))
        || document.querySelector('.nav-mobile');
      if (!nav) return;
      toggle.setAttribute('aria-expanded', nav.classList.contains('open') ? 'true' : 'false');
      toggle.addEventListener('click', function (e) {
        e.stopPropagation();
        var open = !nav.classList.contains('open');
        $$('.menu-toggle.open').forEach(function (btn) { btn.classList.remove('open'); btn.setAttribute('aria-expanded', 'false'); });
        $$('.nav-mobile.open').forEach(function (menu) { menu.classList.remove('open'); });
        toggle.classList.toggle('open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        nav.classList.toggle('open', open);
      });
    });
  }

  function reveal(scope) {
    var nodes = $$('[data-anim], .pfw-animate, .pfw-fade-up', scope || document).filter(function (el) {
      return !el.classList.contains('in');
    });
    if (!nodes.length) return;
    if (reduceMotion || isElementorEdit || !('IntersectionObserver' in window)) {
      nodes.forEach(function (el) { el.classList.add('in'); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('in');
        io.unobserve(entry.target);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
    nodes.forEach(function (el) { io.observe(el); });
  }

  function counters(scope) {
    $$('[data-count]:not([data-count-done])', scope || document).forEach(function (el) {
      el.setAttribute('data-count-done', '1');
      var target = parseFloat(el.getAttribute('data-count')) || 0;
      var suffix = el.getAttribute('data-suffix') || '';
      if (reduceMotion || isElementorEdit) { el.textContent = target + suffix; return; }
      var start = performance.now();
      function tick(now) {
        var p = Math.min((now - start) / 1200, 1);
        var eased = 1 - Math.pow(1 - p, 4);
        el.textContent = Math.round(eased * target) + suffix;
        if (p < 1) requestAnimationFrame(tick);
      }
      requestAnimationFrame(tick);
    });
  }

  function typing(scope) {
    $$('.typing, [data-typing]', scope || document).forEach(function (el) {
      if (el.dataset.pfwTypingBound || el.dataset.typingBound) return;
      el.dataset.pfwTypingBound = '1';
      var raw = el.getAttribute('data-phrases') || el.textContent || '';
      var phrases = raw.split('|').map(function (s) { return s.trim(); }).filter(Boolean);
      if (!phrases.length) return;
      if (reduceMotion || isElementorEdit) { el.textContent = phrases[0]; return; }
      var i = 0, c = 0, deleting = false;
      el.textContent = '';
      function tick() {
        var cur = phrases[i];
        if (!deleting) {
          c += 1;
          el.textContent = cur.slice(0, c);
          if (c === cur.length) { deleting = phrases.length > 1; setTimeout(tick, 1600); return; }
          setTimeout(tick, 70);
        } else {
          c -= 1;
          el.textContent = cur.slice(0, c);
          if (c === 0) { deleting = false; i = (i + 1) % phrases.length; setTimeout(tick, 280); return; }
          setTimeout(tick, 38);
        }
      }
      setTimeout(tick, 350);
    });
  }

  function boot(scope) {
    mobileMenus(scope);
    reveal(scope);
    counters(scope);
    typing(scope);
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function () { boot(document); });
  else boot(document);

  if (window.elementorFrontend && window.elementorFrontend.hooks) {
    window.elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope) {
      boot($scope && $scope[0] ? $scope[0] : document);
    });
  }
})();