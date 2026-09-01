jQuery(function ($) {

  // Hero banner image: show a spinner over it until the <img> actually
  // fires its load event, then fade the spinner out and the image in.
  (function () {
    document.querySelectorAll('.hero-banner-image').forEach(function (img) {
      const spinner = img.parentElement.querySelector('.hero-banner-spinner');

      function reveal() {
        if (spinner) {
          // Let the spinner fully fade out before the image starts
          // fading in, so the two transitions never overlap.
          spinner.classList.add('is-hidden');
          setTimeout(function () {
            img.classList.remove('opacity-0');
          }, 300);
        } else {
          img.classList.remove('opacity-0');
        }
      }

      if (img.complete && img.naturalWidth > 0) {
        reveal();
      } else {
        img.addEventListener('load', reveal, { once: true });
        img.addEventListener('error', reveal, { once: true });
      }
    });
  })();

  // Hero banner video: the hero image renders immediately and doubles as
  // the video's poster/placeholder. The video itself has no src on page
  // load (only data-src), so the browser never fetches it up front — we
  // assign the src once the page is idle/loaded, then fade the video in
  // over the image once it's actually ready to play.
  (function () {
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

  //mobile specific main menu mobile
  const SUBMENU_SLIDE_DURATION = 300; // keep in sync with the CSS transition duration

  function slideSubmenuOpen(submenu) {
    clearTimeout(submenu._slideTimeout);

    submenu.style.display = 'flex';
    submenu.style.flexDirection = 'column';
    submenu.style.overflow = 'hidden';
    submenu.style.maxHeight = '0px';
    submenu.style.opacity = '0';

    submenu.offsetHeight; // force reflow so the transition runs

    submenu.style.maxHeight = submenu.scrollHeight + 'px';
    submenu.style.opacity = '1';

    // Once open, drop the height cap so a nested submenu can expand
    // inside it later without being clipped by this fixed value.
    submenu._slideTimeout = setTimeout(() => {
      submenu.style.maxHeight = 'none';
    }, SUBMENU_SLIDE_DURATION);
  }

  function slideSubmenuClosed(submenu) {
    clearTimeout(submenu._slideTimeout);

    submenu.style.overflow = 'hidden';
    submenu.style.maxHeight = submenu.scrollHeight + 'px';
    submenu.style.opacity = '1';

    submenu.offsetHeight; // force reflow so the transition runs

    submenu.style.maxHeight = '0px';
    submenu.style.opacity = '0';

    submenu._slideTimeout = setTimeout(() => {
      submenu.style.display = 'none';
    }, SUBMENU_SLIDE_DURATION);
  }

  document.querySelectorAll('.menu-item-has-children').forEach(item => {

    const link = item.querySelector(':scope > a');
    const button = link ? link.nextElementSibling : null;

    function toggleMenu(e) {
      if (window.innerWidth >= 1024) return;

      e.preventDefault();

      const submenu = item.querySelector(':scope > ul');
      if (!submenu) return;

      const isOpen = item.classList.contains('is-active');

      // Close sibling dropdowns at the same level so only one is open at a time
      const parentList = item.parentElement;
      if (parentList) {
        parentList.querySelectorAll(':scope > .menu-item-has-children').forEach(sibling => {
          if (sibling === item) return;

          const siblingSubmenu = sibling.querySelector(':scope > ul');
          if (siblingSubmenu) slideSubmenuClosed(siblingSubmenu);
          sibling.classList.remove('is-active');
        });
      }

      if (isOpen) {
        slideSubmenuClosed(submenu);
        item.classList.remove('is-active');
      } else {
        slideSubmenuOpen(submenu);
        item.classList.add('is-active');
      }
    }

    if (link) {
      link.addEventListener('click', toggleMenu);
    }

    if (button) {
      button.addEventListener('click', toggleMenu);
    }

  });


  // Mobile menu
  const mobileMenu = {
    init: function () {
      this.cacheElements();
      this.bindEvents();
    },

    cacheElements: function () {
      this.$toggle = $("#mobile-menu-toggle");
      this.$close = $("#mobile-menu-close");
      this.$overlay = $("#mobile-menu-overlay");
      this.$panel = $("#mobile-menu-panel");
      this.$burger = $(".burger-line");
      this.$links = $("#wyz-creations-mobile-menu a").not(".dropdown-toggle");
    },

    bindEvents: function () {
      this.$toggle
        .add(this.$close)
        .add(this.$overlay)
        .on("click", $.proxy(this.toggle, this));
      $(document).on("keydown", $.proxy(this.onKeydown, this));
      this.$links.on("click", $.proxy(this.toggle, this));
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
      }, 10000);
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
