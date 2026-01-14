// GSAP animations
(function () {
  if (typeof window.gsap === "undefined") return;
  if (window.ScrollTrigger) gsap.registerPlugin(ScrollTrigger);

  // Stagger headings - text animation use 'stagger-words' to a sentence
  function wrapWords(el) {
    const words = el.textContent.trim().split(/\s+/);
    el.innerHTML = words
      .map((w, i) => `<span class="word">${w}</span>`)
      .join(" ");
    return el.querySelectorAll(".word");
  }

  const targets = document.querySelectorAll(".stagger-words");

  targets.forEach((el) => {
    const words = wrapWords(el);

    words.forEach((w) => {
      w.style.display = "inline-block";
      w.style.opacity = 0;
      w.style.transform = "translateX(20px)"; // start from right
    });

    const tl = gsap.timeline({
      defaults: { duration: 0.7, ease: "power3.out" },
      paused: true,
      delay: 0.5,
    });

    // stagger in all words from right
    tl.to(words, {
      opacity: 1,
      x: 0,
      stagger: 0.15, // slower stagger
    });

    if (window.ScrollTrigger) {
      ScrollTrigger.create({
        trigger: el,
        start: "top 85%",
        onEnter: () => tl.play(),
        once: true,
      });
    } else {
      tl.play();
    }
  });

  // Slide up elements animation
  // Select all elements with .slide-up class
  const slideUpTargets = document.querySelectorAll(".slide-up");

  slideUpTargets.forEach((el) => {
    gsap.from(el, {
      y: 50, // start 50px lower
      opacity: 0, // start transparent
      duration: 0.8, // animation duration
      ease: "power3.out", // easing
      scrollTrigger: {
        trigger: el,
        start: "top 90%", // when element enters viewport
        toggleActions: "play none none none", // play only once
      },
    });
  });

  // Scale up elements with .pulse-hover on hover only
  const pulseElements = document.querySelectorAll(".scale-hover");

  pulseElements.forEach((el) => {
    // Scale up on hover
    el.addEventListener("mouseenter", () => {
      gsap.to(el, {
        scale: 1.05,
        duration: 0.3,
        ease: "power1.out",
      });
    });

    // Scale back to normal on mouse leave
    el.addEventListener("mouseleave", () => {
      gsap.to(el, {
        scale: 1,
        duration: 0.3,
        ease: "power1.out",
      });
    });
  });
})();
