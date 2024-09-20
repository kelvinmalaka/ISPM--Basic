"use strict";
(function () {
    // Global variables
    var userAgent = navigator.userAgent.toLowerCase(),
        initialDate = new Date(),
        $document = $(document),
        $window = $(window),
        $html = $("html"),
        $body = $("body"),
        isDesktop = $html.hasClass("desktop"),
        isIE =
            userAgent.indexOf("msie") !== -1
                ? parseInt(userAgent.split("msie")[1], 10)
                : userAgent.indexOf("trident") !== -1
                ? 11
                : userAgent.indexOf("edge") !== -1
                ? 12
                : false,
        isMobile =
            /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                navigator.userAgent
            ),
        windowReady = false,
        plugins = {
            lightGallery: $('[data-lightgallery="group"]'),
            lightGalleryItem: $('[data-lightgallery="item"]'),
            materialParallax: $(".parallax-container"),
            preloader: $(".preloader"),
            rdNavbar: $(".rd-navbar"),
            wow: $(".wow"),
            slick: $(".slick-slider"),
            swiper: document.querySelectorAll(".swiper-container"),
            waves: document.querySelectorAll(".waves"),
        };

    /**
     * @desc Check the element was been scrolled into the view
     * @param {object} elem - jQuery object
     * @return {boolean}
     */
    function isScrolledIntoView(elem) {
        return (
            elem.offset().top + elem.outerHeight() >= $window.scrollTop() &&
            elem.offset().top <= $window.scrollTop() + $window.height()
        );
    }

    // Initialize scripts that require a loaded window
    $window.on("load", function () {
        // Page loader & Page transition
        if (plugins.preloader.length) {
            pageTransition({
                target: document.querySelector(".page"),
                delay: 0,
                duration: 500,
                classIn: "fadeIn",
                classOut: "fadeOut",
                classActive: "completed",
                conditions: function (event, link) {
                    return (
                        link &&
                        !/(\#|javascript:void\(0\)|callto:|tel:|mailto:|:\/\/)/.test(
                            link
                        ) &&
                        !event.currentTarget.hasAttribute("data-lightgallery")
                    );
                },
                onTransitionStart: function (options) {
                    setTimeout(function () {
                        plugins.preloader.removeClass("loaded");
                    }, options.duration * 0.75);
                },
                onReady: function () {
                    plugins.preloader.addClass("loaded");
                    windowReady = true;
                },
            });
        }

        // WOW
        if (plugins.wow.length && isDesktop) {
            new WOW({
                offset: -100,
            }).init();
        }

        // Triangle
        function triangleCreate(element) {
            for (var i = 0; i < element.length; i++) {
                var node = $(element[i]);
                var triangle = node.find($(node.data("triangle")));

                var triangleWidth = node.innerWidth();
                var triangleHeight = node.innerHeight();

                triangle.css({
                    "border-top-width": triangleHeight + "px",
                    "border-left-width": triangleWidth + "px",
                });
            }
        }
        var elementWithTriangleRight = $("[data-triangle]");
        if (elementWithTriangleRight.length) {
            triangleCreate(elementWithTriangleRight);
            $window.on("resize orientationchange", function () {
                triangleCreate(elementWithTriangleRight);
            });
        }

        if (plugins.waves.length) {
            for (var i = 0; i < plugins.waves.length; i++) {
                var wave = plugins.waves[i];
                var waves = new SineWaves({
                    el: wave,
                    speed: wave.getAttribute("data-speed") || 5,
                    width: function () {
                        return $(window).width();
                    },

                    height: function () {
                        return $(window).height();
                    },

                    ease: wave.getAttribute("data-animation") || "SineInOut",
                    wavesWidth: wave.getAttribute("data-wave-width") || "150%",
                    waves: [
                        {
                            timeModifier: 0.6,
                            lineWidth: 5,
                            amplitude: -200,
                            wavelength: 200,
                        },
                        {
                            timeModifier: 0.13,
                            lineWidth: 5,
                            amplitude: -300,
                            wavelength: 300,
                        },
                    ],

                    // Called on window resize
                    resizeEvent: function () {
                        var gradient1 = this.ctx.createLinearGradient(
                            0,
                            0,
                            this.width,
                            0
                        );
                        gradient1.addColorStop(0, "rgba(0, 172, 238, 1)");
                        gradient1.addColorStop(0.54, "rgba(239, 165, 6, 1)");
                        gradient1.addColorStop(1, "rgba(236, 57, 139, 1)");

                        var gradient2 = this.ctx.createLinearGradient(
                            0,
                            0,
                            this.width,
                            0
                        );
                        gradient2.addColorStop(0, "rgba(32, 171, 208, 1)");
                        gradient2.addColorStop(0.5, "rgba(83, 72, 182, 1)");
                        gradient2.addColorStop(1, "rgba(234, 8, 140, 1)");

                        var index = -1;
                        var length = this.waves.length;
                        while (++index < length) {
                            if (index === 0) {
                                this.waves[index].strokeStyle = gradient1;
                            } else {
                                this.waves[index].strokeStyle = gradient2;
                            }
                        }

                        // Clean Up
                        index = void 0;
                        length = void 0;
                        gradient1 = void 0;
                        gradient2 = void 0;
                    },
                });

                $window.scroll(function () {
                    if (!isScrolledIntoView($(wave))) {
                        waves.running = false;
                        waves.update();
                    } else {
                        waves.running = true;
                        waves.update();
                    }
                });
            }
        }
    });

    // Initialize scripts that require a finished document
    $(function () {
        /**
         * @desc Sets the actual previous index based on the position of the slide in the markup. Should be the most recent action.
         * @param {object} swiper - swiper instance
         */
        function setRealPrevious(swiper) {
            var element = swiper.$wrapperEl[0].children[swiper.activeIndex];
            swiper.realPrevious = Array.prototype.indexOf.call(
                element.parentNode.children,
                element
            );
        }

        /**
         * @desc Sets slides background images from attribute 'data-slide-bg'
         * @param {object} swiper - swiper instance
         */
        function setBackgrounds(swiper) {
            var swiperSlides = swiper.el.querySelectorAll("[data-slide-bg]");
            for (var i = 0; i < swiperSlides.length; i++) {
                var swiperSlide = swiperSlides[i];
                swiperSlide.style.backgroundImage =
                    "url(" + swiperSlide.getAttribute("data-slide-bg") + ")";
            }
        }

        /**
         * @desc Animate captions on active slides
         * @param {object} swiper - swiper instance
         */
        function initCaptionAnimate(swiper) {
            var animate = function (caption) {
                    return function () {
                        var duration;
                        if (
                            (duration = caption.getAttribute(
                                "data-caption-duration"
                            ))
                        )
                            caption.style.animationDuration = duration + "ms";
                        caption.classList.remove("not-animated");
                        caption.classList.add(
                            caption.getAttribute("data-caption-animate")
                        );
                        caption.classList.add("animated");
                    };
                },
                initializeAnimation = function (captions) {
                    for (var i = 0; i < captions.length; i++) {
                        var caption = captions[i];
                        caption.classList.remove("animated");
                        caption.classList.remove(
                            caption.getAttribute("data-caption-animate")
                        );
                        caption.classList.add("not-animated");
                    }
                },
                finalizeAnimation = function (captions) {
                    for (var i = 0; i < captions.length; i++) {
                        var caption = captions[i];
                        if (caption.getAttribute("data-caption-delay")) {
                            setTimeout(
                                animate(caption),
                                Number(
                                    caption.getAttribute("data-caption-delay")
                                )
                            );
                        } else {
                            animate(caption)();
                        }
                    }
                };

            // Caption parameters
            swiper.params.caption = {
                animationEvent: "slideChangeTransitionEnd",
            };

            initializeAnimation(
                swiper.$wrapperEl[0].querySelectorAll("[data-caption-animate]")
            );
            finalizeAnimation(
                swiper.$wrapperEl[0].children[
                    swiper.activeIndex
                ].querySelectorAll("[data-caption-animate]")
            );

            if (
                swiper.params.caption.animationEvent ===
                "slideChangeTransitionEnd"
            ) {
                swiper.on(swiper.params.caption.animationEvent, function () {
                    initializeAnimation(
                        swiper.$wrapperEl[0].children[
                            swiper.previousIndex
                        ].querySelectorAll("[data-caption-animate]")
                    );
                    finalizeAnimation(
                        swiper.$wrapperEl[0].children[
                            swiper.activeIndex
                        ].querySelectorAll("[data-caption-animate]")
                    );
                });
            } else {
                swiper.on("slideChangeTransitionEnd", function () {
                    initializeAnimation(
                        swiper.$wrapperEl[0].children[
                            swiper.previousIndex
                        ].querySelectorAll("[data-caption-animate]")
                    );
                });

                swiper.on(swiper.params.caption.animationEvent, function () {
                    finalizeAnimation(
                        swiper.$wrapperEl[0].children[
                            swiper.activeIndex
                        ].querySelectorAll("[data-caption-animate]")
                    );
                });
            }
        }

        /**
         * @desc Initialize the gallery with set of images
         * @param {object} itemsToInit - jQuery object
         * @param {string} [addClass] - additional gallery class
         */
        function initLightGallery(itemsToInit, addClass) {
            $(itemsToInit).lightGallery({
                thumbnail: $(itemsToInit).attr("data-lg-thumbnail") !== "false",
                selector: "[data-lightgallery='item']",
                autoplay: $(itemsToInit).attr("data-lg-autoplay") === "true",
                pause:
                    parseInt($(itemsToInit).attr("data-lg-autoplay-delay")) ||
                    5000,
                addClass: addClass,
                mode: $(itemsToInit).attr("data-lg-animation") || "lg-slide",
                loop: $(itemsToInit).attr("data-lg-loop") !== "false",
            });
        }

        /**
         * @desc Initialize the gallery with one image
         * @param {object} itemToInit - jQuery object
         * @param {string} [addClass] - additional gallery class
         */
        function initLightGalleryItem(itemToInit, addClass) {
            $(itemToInit).lightGallery({
                selector: "this",
                addClass: addClass,
                counter: false,
                youtubePlayerParams: {
                    modestbranding: 1,
                    showinfo: 0,
                    rel: 0,
                    controls: 0,
                },
                vimeoPlayerParams: {
                    byline: 0,
                    portrait: 0,
                },
            });
        }

        // Additional class on html if mac os.
        if (navigator.platform.match(/(Mac)/i)) {
            $html.addClass("mac-os");
        }

        // Adds some loosing functionality to IE browsers (IE Polyfills)
        if (isIE) {
            if (isIE === 12) $html.addClass("ie-edge");
            if (isIE === 11) $html.addClass("ie-11");
            if (isIE < 10) $html.addClass("lt-ie-10");
            if (isIE < 11) $html.addClass("ie-10");
        }

        // UI To Top
        if (isDesktop) {
            $().UItoTop({
                easingType: "easeOutQuad",
                containerClass: "ui-to-top",
                text: "<i class='bi-chevron-up'></i>",
            });
        }

        // RD Navbar
        if (plugins.rdNavbar.length) {
            var navbar = plugins.rdNavbar,
                aliases = {
                    "-": 0,
                    "-sm-": 576,
                    "-md-": 768,
                    "-lg-": 992,
                    "-xl-": 1200,
                    "-xxl-": 1600,
                },
                responsive = {};

            for (var alias in aliases) {
                var link = (responsive[aliases[alias]] = {});
                if (navbar.attr("data" + alias + "layout"))
                    link.layout = navbar.attr("data" + alias + "layout");
                if (navbar.attr("data" + alias + "device-layout"))
                    link.deviceLayout = navbar.attr(
                        "data" + alias + "device-layout"
                    );
                if (navbar.attr("data" + alias + "hover-on"))
                    link.focusOnHover =
                        navbar.attr("data" + alias + "hover-on") === "true";
                if (navbar.attr("data" + alias + "auto-height"))
                    link.autoHeight =
                        navbar.attr("data" + alias + "auto-height") === "true";
                if (navbar.attr("data" + alias + "stick-up-offset"))
                    link.stickUpOffset = navbar.attr(
                        "data" + alias + "stick-up-offset"
                    );
                if (navbar.attr("data" + alias + "stick-up"))
                    link.stickUp =
                        navbar.attr("data" + alias + "stick-up") === "true";
                else if (navbar.attr("data" + alias + "stick-up"))
                    link.stickUp =
                        navbar.attr("data" + alias + "stick-up") === "true";
            }

            plugins.rdNavbar.RDNavbar({
                anchorNav: true,
                stickUpClone: plugins.rdNavbar.attr("data-stick-up-clone")
                    ? plugins.rdNavbar.attr("data-stick-up-clone") === "true"
                    : false,
                responsive: responsive,
                autoHeight: false,
                callbacks: {
                    onStuck: function () {},
                    onDropdownOver: function () {
                        return true;
                    },
                    onUnstuck: function () {
                        if (this.$clone === null) return;
                    },
                },
            });

            var currentScroll = 0;
            $window.scroll(function (event) {
                var nextScroll = $(this).scrollTop();

                if (nextScroll > currentScroll) {
                    plugins.rdNavbar.addClass("scroll-bottom");
                } else {
                    plugins.rdNavbar.removeClass("scroll-bottom");
                }

                currentScroll = nextScroll;
            });
        }

        // Swiper
        if (plugins.swiper.length) {
            for (var i = 0; i < plugins.swiper.length; i++) {
                var sliderMarkup = plugins.swiper[i],
                    swiper,
                    options = {
                        loop:
                            sliderMarkup.getAttribute("data-loop") === "true" ||
                            false,
                        effect: isIE
                            ? "slide"
                            : sliderMarkup.getAttribute("data-effect") ||
                              "slide",
                        direction:
                            sliderMarkup.getAttribute("data-direction") ||
                            "horizontal",
                        speed: sliderMarkup.getAttribute("data-speed")
                            ? Number(sliderMarkup.getAttribute("data-speed"))
                            : 1000,
                        allowTouchMove: false,
                        preventIntercationOnTransition: true,
                        runCallbacksOnInit: false,
                        separateCaptions:
                            sliderMarkup.getAttribute(
                                "data-separate-captions"
                            ) === "true" || false,
                    };

                if (sliderMarkup.getAttribute("data-autoplay")) {
                    options.autoplay = {
                        delay:
                            Number(
                                sliderMarkup.getAttribute("data-autoplay")
                            ) || 3000,
                        stopOnLastSlide: false,
                        disableOnInteraction: true,
                        reverseDirection: false,
                    };
                }

                if (sliderMarkup.getAttribute("data-keyboard") === "true") {
                    options.keyboard = {
                        enabled:
                            sliderMarkup.getAttribute("data-keyboard") ===
                            "true",
                        onlyInViewport: true,
                    };
                }

                if (sliderMarkup.getAttribute("data-mousewheel") === "true") {
                    options.mousewheel = {
                        releaseOnEdges: true,
                        sensitivity: 0.1,
                    };
                }

                if (
                    sliderMarkup.querySelector(
                        ".swiper-button-next, .swiper-button-prev"
                    )
                ) {
                    options.navigation = {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    };
                }

                if (sliderMarkup.querySelector(".swiper-pagination")) {
                    options.pagination = {
                        el: ".swiper-pagination",
                        type: "bullets",
                        clickable: true,
                    };
                }

                if (sliderMarkup.querySelector(".swiper-scrollbar")) {
                    options.scrollbar = {
                        el: ".swiper-scrollbar",
                        hide: true,
                        draggable: true,
                    };
                }

                options.on = {
                    init: function () {
                        setBackgrounds(this);
                        setRealPrevious(this);
                        initCaptionAnimate(this);

                        // Real Previous Index must be set recent
                        this.on("slideChangeTransitionEnd", function () {
                            setRealPrevious(this);
                        });
                    },
                };

                swiper = new Swiper(plugins.swiper[i], options);
            }
        }

        // lightGallery
        if (plugins.lightGallery.length) {
            for (var i = 0; i < plugins.lightGallery.length; i++) {
                initLightGallery(plugins.lightGallery[i]);
            }
        }

        // lightGallery item
        if (plugins.lightGalleryItem.length) {
            // Filter carousel items
            var notCarouselItems = [];

            for (var z = 0; z < plugins.lightGalleryItem.length; z++) {
                if (
                    !$(plugins.lightGalleryItem[z]).parents(".owl-carousel")
                        .length &&
                    !$(plugins.lightGalleryItem[z]).parents(".swiper-slider")
                        .length &&
                    !$(plugins.lightGalleryItem[z]).parents(".slick-slider")
                        .length
                ) {
                    notCarouselItems.push(plugins.lightGalleryItem[z]);
                }
            }

            plugins.lightGalleryItem = notCarouselItems;

            for (var i = 0; i < plugins.lightGalleryItem.length; i++) {
                initLightGalleryItem(plugins.lightGalleryItem[i]);
            }
        }

        // Slick carousel
        if (plugins.slick.length) {
            for (var i = 0; i < plugins.slick.length; i++) {
                var $slickItem = $(plugins.slick[i]);

                $slickItem.on("init", function (slick) {
                    initLightGallery(
                        $('[data-lightgallery="group-slick"]'),
                        "lightGallery-in-carousel"
                    );
                    initLightGallery(
                        $('[data-lightgallery="item-slick"]'),
                        "lightGallery-in-carousel"
                    );
                });

                $slickItem
                    .slick({
                        slidesToScroll:
                            parseInt(
                                $slickItem.attr("data-slide-to-scroll"),
                                10
                            ) || 1,
                        asNavFor: $slickItem.attr("data-for") || false,
                        dots: $slickItem.attr("data-dots") === "true",
                        infinite: $slickItem.attr("data-loop") === "true",
                        focusOnSelect: true,
                        arrows: $slickItem.attr("data-arrows") === "true",
                        swipe: $slickItem.attr("data-swipe") === "true",
                        autoplay: $slickItem.attr("data-autoplay") === "true",
                        vertical: $slickItem.attr("data-vertical") === "true",
                        centerMode:
                            $slickItem.attr("data-center-mode") === "true",
                        centerPadding: $slickItem.attr("data-center-padding")
                            ? $slickItem.attr("data-center-padding")
                            : "0.50",
                        mobileFirst: true,
                        responsive: [
                            {
                                breakpoint: 0,
                                settings: {
                                    slidesToShow:
                                        parseInt(
                                            $slickItem.attr("data-items"),
                                            10
                                        ) || 1,
                                },
                            },
                            {
                                breakpoint: 575,
                                settings: {
                                    slidesToShow:
                                        parseInt(
                                            $slickItem.attr("data-sm-items"),
                                            10
                                        ) || 1,
                                },
                            },
                            {
                                breakpoint: 767,
                                settings: {
                                    slidesToShow:
                                        parseInt(
                                            $slickItem.attr("data-md-items"),
                                            10
                                        ) || 1,
                                },
                            },
                            {
                                breakpoint: 991,
                                settings: {
                                    slidesToShow:
                                        parseInt(
                                            $slickItem.attr("data-lg-items"),
                                            10
                                        ) || 1,
                                },
                            },
                            {
                                breakpoint: 1199,
                                settings: {
                                    slidesToShow:
                                        parseInt(
                                            $slickItem.attr("data-xl-items"),
                                            10
                                        ) || 1,
                                },
                            },
                        ],
                    })
                    .on(
                        "afterChange",
                        function (event, slick, currentSlide, nextSlide) {
                            var $this = $(this),
                                childCarousel = $this.attr("data-child");

                            if (childCarousel) {
                                $(childCarousel + " .slick-slide").removeClass(
                                    "slick-current"
                                );
                                $(childCarousel + " .slick-slide")
                                    .eq(currentSlide)
                                    .addClass("slick-current");
                            }
                        }
                    );
            }
        }

        // Material Parallax
        if (plugins.materialParallax.length) {
            if (!isIE && !isMobile) {
                plugins.materialParallax.parallax();
            } else {
                for (var i = 0; i < plugins.materialParallax.length; i++) {
                    var $parallax = $(plugins.materialParallax[i]);

                    $parallax.addClass("parallax-disabled");
                    $parallax.css({
                        "background-image":
                            "url(" + $parallax.data("parallax-img") + ")",
                    });
                }
            }
        }
    });
})();
