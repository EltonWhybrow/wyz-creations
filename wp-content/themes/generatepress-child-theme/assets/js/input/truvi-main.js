jQuery(function ($) {
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
      this.$links = $("#truvi-mobile-menu a").not(".dropdown-toggle");
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
    var href = $(this).attr("href");

    // Skip empty or "#" only links
    if (href === "#" || href === "#!") return;

    // Get hash from URL
    var hash = href.split("#")[1];
    if (!hash) return;

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
    if ($target.length) {
      var headerHeight = $(".fixed-header").outerHeight() || 0;
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
        var headerHeight = $(".fixed-header").outerHeight() || 0;
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

  $("#info-top-banner").on("click", ".fa-close, .close-banner", function () {
    $("#info-top-banner").slideUp(400, function () {
      // Set cookie for 30 days
      var d = new Date();
      d.setTime(d.getTime() + 30 * 24 * 60 * 60 * 1000);
      document.cookie =
        "info_banner_dismissed=1;expires=" + d.toUTCString() + ";path=/";
    });
  });


  const openBtn = document.getElementById('open-linkme');
  const closeBtn = document.getElementById('close-linkme');
  const panel = document.getElementById('linkme-panel');

  openBtn.addEventListener('click', function (e) {
    e.preventDefault();
    panel.classList.add('active');
    document.body.style.overflow = 'hidden';
  });

  closeBtn.addEventListener('click', function () {
    panel.classList.remove('active');
    document.body.style.overflow = '';
  });

});
