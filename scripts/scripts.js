gsap.registerPlugin(ScrollTrigger);

// Set initial states
gsap.set("#logo_white", { autoAlpha: 1, display: "none", height: 'auto', zIndex: 'auto' });
gsap.set("#logo_black", { autoAlpha: 0, display: "block", height: 'auto', zIndex: 'auto' });
gsap.set("#logo_main", { autoAlpha: 1, display: "none" });
gsap.set("#bg_grids", { autoAlpha: 1, display: "block" });
gsap.set("#bg_build", { autoAlpha: 1, display: "block", width: '100%' });
gsap.set("#bg_buildCropped", { autoAlpha: 1, display: "block", width: '51%' });

// Create a timeline for animations
let tl = gsap.timeline({
    scrollTrigger: {
        trigger: ".hero_secion",
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
    delay: 0.5,
})
.to("#bg_build", {
    autoAlpha: 1,
    width: '75.5%',
    duration: 0,
    delay: 2,
})
.set("#bg_build", {
    autoAlpha: 0,
    width: '75.5%',
    duration: 0,
    delay: 4,
})
.to('#logo_main', {
    autoAlpha: 1,
    display: "block",
    duration: 0,
    zIndex: 0,
    delay: 0,
})
.to('#logo_white', {
    autoAlpha: 1,
    display: "block",
    duration: 0,
    zIndex: 40,
    delay: 0,
})
.to('#logo_white', {
    autoAlpha: 1,
    display: "block",
    duration: 0,
    zIndex: 99,
    delay: 3,
})
.to('#logo_main', {
    autoAlpha: 1,
    display: "none",
    duration: 0,
    zIndex: 0,
    delay: 2,
});