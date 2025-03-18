gsap.registerPlugin(ScrollTrigger);

// Set initial states
gsap.set("#logo_white", { autoAlpha: 0, display: "none", height: 'auto', zIndex: 'auto' });
gsap.set("#logo_black", { autoAlpha: 0, display: "none", height: 'auto', zIndex: 'auto' });
gsap.set("#logo_main", { autoAlpha: 0, display: "none" });
gsap.set("#bg_grids", { autoAlpha: 1, display: "block" });
gsap.set("#bg_build", { autoAlpha: 1, display: "block", width: '100%' });
gsap.set("#bg_buildCropped", { autoAlpha: 1, display: "block", width: '51%' });

// Create a timeline for animations
let tl = gsap.timeline({
    scrollTrigger: {
        trigger: ".hero_section", // Fixed typo
        start: "top top",
        end: "+=1200px", // Pin for 1200 pixels of scroll
        scrub: true,
        pin: true,
    },
});

// Animate the main logo
tl.to("#logo_main", {
    autoAlpha: 1,
    display: "block",
    duration: 2,
})
.to("#bg_build", {
    width: '75.5%',
    duration: 2,
})
.set("#bg_build", {
    autoAlpha: 0,
})
.to('#logo_white', {
    autoAlpha: 1,
    zIndex: 99,
})
.to('#logo_main', {
    autoAlpha: 0,
    display: "none",
});

// Add parallax effect to panels
document.querySelectorAll('.panel').forEach((panel, index) => {
    gsap.from(panel, {
        y: 30 * (index + 1), // Smaller parallax distance for smoother effect
        opacity: 0,
        duration: 1,
        scrollTrigger: {
            trigger: panel,
            start: "top 80%",
            end: "bottom 20%",
            scrub: true,
        },
    });
});