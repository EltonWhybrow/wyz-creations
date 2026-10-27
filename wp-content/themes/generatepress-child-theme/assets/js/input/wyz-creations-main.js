jQuery(function ($) {

  // Hero banner video: the hero image renders immediately and doubles as
  // the video's poster/placeholder. The video itself has no src on page
  // load (only data-src), so the browser never fetches it up front — we
  // assign the src once the page is idle/loaded, then fade the video in
  // over the image once it's actually ready to play.
  (function () {
    if (window.innerWidth < 768) return;

    const videos = document.querySelectorAll('.hero-banner-video[data-src]');
    if (!videos.length) return;

    function loadHeroVideo(video) {
      if (video.dataset.loaded) return;
      video.dataset.loaded = '1';
      video.src = video.dataset.src;
      video.load();
      video.addEventListener('canplay', function () {
        video.classList.remove('opacity-0');
      }, { once: true });
    }

    if ('requestIdleCallback' in window) {
      requestIdleCallback(function () {
        videos.forEach(loadHeroVideo);
      });
    } else {
      window.addEventListener('load', function () {
        videos.forEach(loadHeroVideo);
      });
    }
  })();

  // Header search: clicking the browser's native "x" clear button on
  // input[type=search] only empties the field, it doesn't re-run the
  // search — so the old (empty) results stay on screen. Send the user
  // back to the shop when that happens.
  $('input[type="search"][name="s"]').on('search', function () {
    if (!this.value && window.wyzcreations_ajax && wyzcreations_ajax.shop_url) {
      window.location.href = wyzcreations_ajax.shop_url;
    }
  });

  // menu js
  const overlay = document.getElementById('menu-overlay');
  const nav = document.querySelector('.main-menu'); // adjust if needed

  if (overlay && nav) {
    let timeout;

    nav.addEventListener('mouseover', (e) => {

      clearTimeout(timeout);
      overlay.classList.add('active');

    });

    nav.addEventListener('mouseout', (e) => {
      if (!nav.contains(e.relatedTarget)) {
        timeout = setTimeout(() => {
          overlay.classList.remove('active');
        }, 100);
      }
    });


  }

  // Mobile drill-down menu: tapping a parent item slides the panel right
  // to reveal its children; back arrow slides back. Up to 3 levels deep.
  (function () {
    var source = document.getElementById('mobile-menu-source');
    var track  = document.getElementById('mobile-menu-track');
    if (!source || !track) return;

    var screens   = Array.from(document.querySelectorAll('.mobile-menu-screen'));
    var backWrap  = document.getElementById('mobile-header-back');
    var backBtn   = document.getElementById('mobile-menu-back');
    var backTitle = document.getElementById('mobile-menu-back-title');

    var level   = 0;
    var history = [];

    var chevron = '<svg xmlns="http://www.w3.org/2000/svg" class="mobile-nav-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>';

    function buildScreen(screen, ul) {
      screen.innerHTML = '';
      ul.querySelectorAll(':scope > li').forEach(function (li) {
        var a     = li.querySelector(':scope > a');
        if (!a) return;
        var subUl = li.querySelector(':scope > ul');
        var label = a.textContent.trim();

        if (subUl) {
          var btn = document.createElement('button');
          btn.type = 'button';
          btn.className = 'mobile-nav-item';
          btn.innerHTML = '<span>' + label + '</span>' + chevron;
          btn.addEventListener('click', function () {
            history.push({ title: label, ul: subUl });
            advance();
          });
          screen.appendChild(btn);
        } else {
          var link = document.createElement('a');
          link.href = a.href;
          link.className = 'mobile-nav-item';
          link.textContent = label;
          screen.appendChild(link);
        }
      });
    }

    function advance() {
      level = Math.min(level + 1, 2);
      buildScreen(screens[level], history[history.length - 1].ul);
      track.style.transform = 'translateX(-' + ((100 / 3) * level) + '%)';
      updateHeader();
    }

    function goBack() {
      history.pop();
      level = Math.max(level - 1, 0);
      track.style.transform = 'translateX(-' + ((100 / 3) * level) + '%)';
      updateHeader();
    }

    function updateHeader() {
      if (level === 0) {
        backWrap.classList.remove('flex');
        backWrap.classList.add('hidden');
      } else {
        backWrap.classList.remove('hidden');
        backWrap.classList.add('flex');
        backTitle.textContent = history[history.length - 1].title;
      }
    }

    // Exposed so mobileMenu.toggle can reset after the close animation.
    window._mobileMenuReset = function () {
      level = 0;
      history.length = 0;
      track.style.transition = 'none';
      track.style.transform = 'translateX(0)';
      requestAnimationFrame(function () { track.style.transition = ''; });
      updateHeader();
    };

    if (backBtn) backBtn.addEventListener('click', goBack);

    var rootUl = source.querySelector('ul');
    if (rootUl) buildScreen(screens[0], rootUl);
  })();


  // Mobile menu
  const mobileMenu = {
    init: function () {
      this.cacheElements();
      this.bindEvents();
    },

    cacheElements: function () {
      this.$toggle  = $("#mobile-menu-toggle");
      this.$close   = $("#mobile-menu-close");
      this.$overlay = $("#mobile-menu-overlay");
      this.$panel   = $("#mobile-menu-panel");
      this.$burger  = $(".burger-line");
    },

    bindEvents: function () {
      this.$toggle
        .add(this.$close)
        .add(this.$overlay)
        .on("click", $.proxy(this.toggle, this));
      $(document).on("keydown", $.proxy(this.onKeydown, this));
      // Delegate: close panel when a leaf-node link is tapped
      this.$panel.on("click", "a.mobile-nav-item", $.proxy(this.toggle, this));
      $(window).on("resize", $.proxy(this.onResize, this));
    },

    toggle: function () {
      const isOpen = this.$panel.hasClass("translate-x-0");

      this.$panel.toggleClass("translate-x-0 translate-x-full");
      this.$overlay.toggleClass("opacity-0 invisible opacity-100 visible");
      $("body").css("overflow", isOpen ? "" : "hidden");

      // Burger animation
      this.$burger.eq(0).toggleClass("rotate-45 translate-y-2", !isOpen);
      this.$burger.eq(1).toggleClass("opacity-0", !isOpen);
      this.$burger.eq(2).toggleClass("-rotate-45 -translate-y-2", !isOpen);

      this.$toggle.attr("aria-expanded", !isOpen);

      // Reset drill-down state after the close animation completes
      if (isOpen && window._mobileMenuReset) {
        setTimeout(window._mobileMenuReset, 320);
      }
    },

    onKeydown: function (e) {
      if (e.key === "Escape" && this.$panel.hasClass("translate-x-0")) {
        this.toggle();
      }
    },

    onResize: function () {
      if ($(window).width() > 768 && this.$panel.hasClass("translate-x-0")) {
        this.toggle();
      }
    },
  };

  mobileMenu.init();

  // Highlight Stats Number Spinners
  function animateCounter($element, target, options = {}) {
    const duration = options.duration || 2000;
    const delay = options.delay || 0;
    const separator = options.separator || "";
    const decimalPlaces = options.decimalPlaces || 0;
    const prefix = options.prefix || "";
    const suffix = options.suffix || "";

    setTimeout(() => {
      let start = 0;
      const increment = target / (duration / 16);

      const timer = setInterval(() => {
        start += increment;
        if (start >= target) {
          start = target;
          clearInterval(timer);
        }

        let displayValue;
        if (decimalPlaces > 0) {
          displayValue = start.toFixed(decimalPlaces);
        } else {
          displayValue = Math.floor(start);
        }

        // Add thousand separators
        if (separator) {
          displayValue = displayValue
            .toString()
            .replace(/\B(?=(\d{3})+(?!\d))/g, separator);
        }

        // Add prefix and suffix
        $element.text(prefix + displayValue + suffix);
      }, 16);
    }, delay);
  }

  function checkIfInView() {
    $(".counter").each(function () {
      const $this = $(this);
      const target = parseFloat($this.data("target"));
      const duration = $this.data("duration") || 2000;
      const delay = $this.data("delay") || 0;
      const separator = $this.data("separator") || "";
      const decimalPlaces = parseInt($this.data("decimal")) || 0;
      const prefix = $this.data("prefix") || ""; // Get prefix from data attribute
      const suffix = $this.data("suffix") || ""; // Get suffix from data attribute

      const elementTop = $this.offset().top;
      const elementBottom = elementTop + $this.outerHeight();
      const viewportTop = $(window).scrollTop();
      const viewportBottom = viewportTop + $(window).height();

      // Check if element is in viewport and hasn't been animated yet
      if (
        elementBottom >= viewportTop &&
        elementTop <= viewportBottom &&
        !$this.hasClass("animated")
      ) {
        $this.addClass("animated");
        animateCounter($this, target, {
          duration: duration,
          delay: delay,
          separator: separator,
          decimalPlaces: decimalPlaces,
          prefix: prefix,
          suffix: suffix,
        });
      }
    });
  }

  // Use Intersection Observer for better performance (modern browsers)
  if ("IntersectionObserver" in window) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const $target = $(entry.target);
            if (!$target.hasClass("animated")) {
              $target.addClass("animated");
              const target = parseFloat($target.data("target"));
              const duration = $target.data("duration") || 2000;
              const delay = $target.data("delay") || 0;
              const separator = $target.data("separator") || "";
              const decimalPlaces = parseInt($target.data("decimal")) || 0;
              const prefix = $target.data("prefix") || "";
              const suffix = $target.data("suffix") || "";

              animateCounter($target, target, {
                duration: duration,
                delay: delay,
                separator: separator,
                decimalPlaces: decimalPlaces,
                prefix: prefix,
                suffix: suffix,
              });
            }
          }
        });
      },
      { threshold: 0.5 }
    );

    $(".counter").each(function () {
      observer.observe(this);
    });
  } else {
    // Fallback for older browsers
    $(window).on("scroll", checkIfInView);
    checkIfInView();
  }

  // Smooth scroll for all anchor links
  $('a[href*="#"]').on("click", function (e) {

    // Ignore WooCommerce tabs
    if ($(this).closest('.wc-tabs').length) {
      return;
    }

    // Ignore new tab links
    if ($(this).attr('target') === '_blank') {
      return;
    }

    var href = $(this).attr("href");

    // Skip empty or "#" only links
    if (href === "#" || href === "#!") return;

    // Get hash from URL
    var hash = href.split("#")[1];
    if (!hash) return;

    // WooCommerce's review-count link points to #reviews, but the actual
    // tab panel's id is #tab-reviews (WooCommerce only special-cases the
    // literal "#reviews" hash in its own page-load tab-init code).
    if (hash === "reviews") {
      hash = "tab-reviews";
    }

    var path = href.split("#")[0];
    var currentPath = window.location.pathname + window.location.search;

    // If linking to a different page
    if (path && path !== "" && path !== currentPath) {
      // Add the anchor to the URL and let normal navigation happen
      // The browser will handle loading the page and jumping to anchor
      window.location.href = path + "#" + hash;
      e.preventDefault();
      return false;
    }

    // Same page anchor
    e.preventDefault();

    var $target = $("#" + hash);

    // WooCommerce tab panels are hidden until their tab is clicked, so a
    // hidden target has no usable position to scroll to. Activate the
    // matching tab first (WC's own click handler shows it synchronously).
    if ($target.length && $target.hasClass("panel") && !$target.is(":visible")) {
      $('.wc-tabs a[href="#' + hash + '"], ul.tabs a[href="#' + hash + '"]').trigger("click");
    }

    if ($target.length) {
      var headerHeight = $(".sticky").outerHeight() || 0;
      var offset = parseInt($(this).data("offset")) || headerHeight;

      $("html, body").animate(
        {
          scrollTop: $target.offset().top - offset,
        },
        800
      );

      // Update URL without scrolling
      history.pushState(null, null, "#" + hash);
    }
  });

  // Scroll to anchor on page load
  if (window.location.hash) {
    var hash = window.location.hash.replace("#", "");
    var $target = $("#" + hash);
    if ($target.length) {
      setTimeout(function () {
        var headerHeight = $(".sticky").outerHeight() || 0;
        $("html, body").scrollTop($target.offset().top - headerHeight);
      }, 100);
    }
  }

  // Back to top button function
  var backToTopButton = $("#backToTop");

  $(window).scroll(function () {
    var scrollPosition = $(window).scrollTop();
    var pageHeight = $(document).height() - $(window).height();
    var threeQuarterPoint = pageHeight * 0.75;

    if (scrollPosition > threeQuarterPoint) {
      backToTopButton.addClass("show");
    } else {
      backToTopButton.removeClass("show");
    }
  });

  backToTopButton.click(function (e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, 800);
  });

  // Coupon banner - Check if already dismissed in the last 30 days
  if (document.cookie.indexOf("info_banner_dismissed=1") === -1) {
    $("#info-top-banner").slideDown(400); // show it
  }

  const $banner = $("#info-top-banner");

  if ($banner.length) {
    if (document.cookie.indexOf("info_banner_dismissed=1") === -1) {
      $banner.slideDown(400);
    }

    $banner.on("click", ".fa-close, .close-banner", function () {
      $banner.slideUp(400, function () {
        const d = new Date();
        d.setTime(d.getTime() + 30 * 24 * 60 * 60 * 1000);
        document.cookie =
          "info_banner_dismissed=1;expires=" +
          d.toUTCString() +
          ";path=/;SameSite=Lax";
      });
    });
  }

  // WYZ Creations panel subscribe
  (function () {
    const openBtn = document.getElementById('open-linkme');
    const closeBtn = document.getElementById('close-linkme');
    const panel = document.getElementById('linkme-panel');

    if (!openBtn || !closeBtn || !panel) return;

    openBtn.addEventListener('click', function (e) {
      e.preventDefault();
      panel.classList.add('active');
      document.body.style.overflow = 'hidden';
    });

    closeBtn.addEventListener('click', function () {
      panel.classList.remove('active');
      document.body.style.overflow = '';
    });
  })();

  // Timed subscribe modal - auto-opens centered 10s after arrival, closing
  // it sets a cookie so it doesn't show again for 10 days
  (function () {
    const modal = document.getElementById('subscribe-modal');
    const overlay = document.getElementById('subscribe-modal-overlay');
    const closeBtn = document.getElementById('close-subscribe-modal');

    if (!modal || !overlay || !closeBtn) return;

    const SUBSCRIBE_MODAL_COOKIE = 'subscribe_modal_dismissed';

    function hasDismissedSubscribeModal() {
      return document.cookie.indexOf(SUBSCRIBE_MODAL_COOKIE + '=1') !== -1;
    }

    function dismissSubscribeModalFor10Days() {
      const d = new Date();
      d.setTime(d.getTime() + 10 * 24 * 60 * 60 * 1000);
      document.cookie =
        SUBSCRIBE_MODAL_COOKIE + '=1;expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
    }

    function closeSubscribeModal() {
      modal.classList.remove('active');
      document.body.style.overflow = '';
      dismissSubscribeModalFor10Days();
    }

    closeBtn.addEventListener('click', closeSubscribeModal);
    overlay.addEventListener('click', closeSubscribeModal);

    if (!hasDismissedSubscribeModal()) {
      setTimeout(function () {
        if (!hasDismissedSubscribeModal()) {
          modal.classList.add('active');
          document.body.style.overflow = 'hidden';
        }
      }, 15000);
    }
  })();

  // Widesign panel subscrFREE site
  (function () {
    const openBtn = document.getElementById('open-widesign');
    const closeBtn = document.getElementById('close-widesign');
    const panel = document.getElementById('widesign-panel');

    if (!openBtn || !closeBtn || !panel) return;

    openBtn.addEventListener('click', function (e) {
      e.preventDefault();
      panel.classList.add('active');
      document.body.style.overflow = 'hidden';
    });

    closeBtn.addEventListener('click', function () {
      panel.classList.remove('active');
      document.body.style.overflow = '';
    });
  })();


  // Infinite scroll for shop / category / tag archive pages
  (function () {
    if (typeof wyz_shop_infinite === 'undefined') return;

    var sentinel = document.getElementById('shop-infinite-sentinel');
    var loader   = document.getElementById('shop-infinite-loader');
    var grid     = document.querySelector('ul.products');

    if (!sentinel || !grid) return;

    var currentPage = 1;
    var loading     = false;
    var maxPages    = parseInt(sentinel.dataset.maxPages, 10) || 1;

    if (maxPages <= 1) return;

    function loadNextPage() {
      if (loading || currentPage >= maxPages) return;

      loading = true;
      currentPage++;

      if (loader) loader.classList.remove('hidden');

      $.post(wyz_shop_infinite.ajax_url, {
        action:   'wyz_infinite_products',
        nonce:    wyz_shop_infinite.nonce,
        page:     currentPage,
        taxonomy: (wyz_shop_infinite.tax && wyz_shop_infinite.tax.taxonomy) || '',
        term:     (wyz_shop_infinite.tax && wyz_shop_infinite.tax.term)     || '',
        orderby:  wyz_shop_infinite.orderby || '',
      }).done(function (res) {
        if (res.success && res.data.html) {
          grid.insertAdjacentHTML('beforeend', res.data.html);
        }
        if (!res.success || !res.data.has_more || currentPage >= maxPages) {
          observer.disconnect();
          sentinel.remove();
        }
      }).always(function () {
        loading = false;
        if (loader) loader.classList.add('hidden');
      });
    }

    var observer = new IntersectionObserver(function (entries) {
      if (entries[0].isIntersecting) loadNextPage();
    }, { rootMargin: '300px' });

    observer.observe(sentinel);
  })();

  // Infinite scroll for blog index
  (function () {
    if (typeof wyz_blog_infinite === 'undefined') return;

    var sentinel = document.getElementById('blog-infinite-sentinel');
    var loader   = document.getElementById('blog-infinite-loader');
    var grid     = document.getElementById('blog-posts-grid');

    if (!sentinel || !grid) return;

    var currentPage = 1;
    var loading     = false;
    var maxPages    = parseInt(sentinel.dataset.maxPages, 10) || 1;

    if (maxPages <= 1) return;

    function loadNextPage() {
      if (loading || currentPage >= maxPages) return;

      loading = true;
      currentPage++;

      if (loader) loader.classList.remove('hidden');

      $.post(wyz_blog_infinite.ajax_url, {
        action: 'wyz_infinite_posts',
        nonce:  wyz_blog_infinite.nonce,
        page:   currentPage,
      }).done(function (res) {
        if (res.success && res.data.html) {
          grid.insertAdjacentHTML('beforeend', res.data.html);
        }
        if (!res.success || !res.data.has_more || currentPage >= maxPages) {
          observer.disconnect();
          sentinel.remove();
        }
      }).always(function () {
        loading = false;
        if (loader) loader.classList.add('hidden');
      });
    }

    var observer = new IntersectionObserver(function (entries) {
      if (entries[0].isIntersecting) loadNextPage();
    }, { rootMargin: '300px' });

    observer.observe(sentinel);
  })();

  // FAQ seach facility
  const $search = $('#faqSearchInput');
  const $clear = $('#faqClearSearch');
  const $items = $('[data-faq-item]');
  const $noResults = $('#faqNoResults');

  function filterFAQs() {

    const query = $search.val().toLowerCase().trim();
    let visibleCount = 0;

    $items.each(function () {

      const $item = $(this);

      const question = $item.find('.faq-question h3').text().toLowerCase();
      const answer = $item.find('.faq-answer').text().toLowerCase();

      const match = question.includes(query) || answer.includes(query);

      if (match) {
        $item.show();
        visibleCount++;
      } else {
        $item.hide();
      }
    });

    // show/hide no results
    if (visibleCount === 0 && query.length > 0) {
      $noResults.removeClass('hidden');
    } else {
      $noResults.addClass('hidden');
    }

    // show/hide clear button
    if (query.length > 0) {
      $clear.removeClass('hidden');
    } else {
      $clear.addClass('hidden');
    }
  }

  // typing
  $search.on('input', filterFAQs);

  // clear button
  $clear.on('click', function () {
    $search.val('');
    filterFAQs();
    $search.focus();
  });
});

// Autumn sale countdown — ends 30 Nov 2026 midnight (UK time)
(function () {
  const el = document.getElementById('sale-countdown');
  if (!el) return;

  const end = new Date('2026-11-30T23:59:59+00:00');

  function tick() {
    const diff = end - Date.now();
    if (diff <= 0) {
      el.textContent = '';
      return;
    }
    const d = Math.floor(diff / 86400000);
    const h = Math.floor((diff % 86400000) / 3600000);
    const m = Math.floor((diff % 3600000) / 60000);
    const s = Math.floor((diff % 60000) / 1000);
    el.textContent = d + 'd ' + h + 'h ' + m + 'm ' + String(s).padStart(2, '0') + 's';
  }

  tick();
  setInterval(tick, 1000);
})();
