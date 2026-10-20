/*-------------- Accordion Ends --------------*/

/*------- Scroll Out JS ---------*/
var ScrollOut=function(){"use strict";function e(e,t,n){return e<t?t:n<e?n:e}function t(e){return+(0<e)-+(e<0)}var n,r={};function i(e){return"-"+e[0].toLowerCase()}function o(e){return r[e]||(r[e]=e.replace(/([A-Z])/g,i))}function l(e,t){return e&&0!==e.length?e.nodeName?[e]:[].slice.call(e[0].nodeName?e:(t||document.documentElement).querySelectorAll(e)):[]}function c(e,t){for(var n in t)n.indexOf("_")&&e.setAttribute("data-"+o(n),t[n])}var s=[];function f(){n=0,s.slice().forEach((function(e){return e()})),u()}function u(){!n&&s.length&&(n=requestAnimationFrame(f))}function a(e,t,n,r){return"function"==typeof e?e(t,n,r):e}function d(){}return function(r){var i,f,v,h,m=(r=r||{}).onChange||d,g=r.onHidden||d,p=r.onShown||d,w=r.onScroll||d,X=r.cssProps?(i=r.cssProps,function(e,t){for(var n in t)n.indexOf("_")&&(!0===i||i[n])&&e.style.setProperty("--"+o(n),(r=t[n],Math.round(1e4*r)/1e4));var r}):d,Y=r.scrollingElement,b=Y?l(Y)[0]:window,D=Y?l(Y)[0]:document.documentElement,E=!1,L={},P=[];function _(){P=l(r.targets||"[data-scroll]",l(r.scope||D)[0]).map((function(e){return{element:e}}))}function H(){var i=D.clientWidth,o=D.clientHeight,l=t(-f+(f=D.scrollLeft||window.pageXOffset)),c=t(-v+(v=D.scrollTop||window.pageYOffset)),d=D.scrollLeft/(D.scrollWidth-i||1),m=D.scrollTop/(D.scrollHeight-o||1);E=E||L.scrollDirX!==l||L.scrollDirY!==c||L.scrollPercentX!==d||L.scrollPercentY!==m,L.scrollDirX=l,L.scrollDirY=c,L.scrollPercentX=d,L.scrollPercentY=m;for(var g,p=!1,w=0;w<P.length;w++){for(var X=P[w],Y=X.element,_=Y,H=0,W=0;H+=_.offsetLeft,W+=_.offsetTop,(_=_.offsetParent)&&_!==b;);var x,O=Y.clientHeight||Y.offsetHeight||0,y=Y.clientWidth||Y.offsetWidth||0,C=(e(H+y,f,f+i)-e(H,f,f+i))/y,S=(e(W+O,v,v+o)-e(W,v,v+o))/O,T=1===C?0:t(H-f),q=1===S?0:t(W-v),z=e((f-(y/2+H-i/2))/(i/2),-1,1),F=e((v-(O/2+W-o/2))/(o/2),-1,1);x=r.offset?a(r.offset,Y,X,D)>v?0:1:(a(r.threshold,Y,X,D)||0)<C*S?1:0;var N=X.visible!==x;(X._changed||N||X.visibleX!==C||X.visibleY!==S||X.index!==w||X.elementHeight!==O||X.elementWidth!==y||X.offsetX!==H||X.offsetY!==W||X.intersectX!=X.intersectX||X.intersectY!=X.intersectY||X.viewportX!==z||X.viewportY!==F)&&(p=!0,X._changed=!0,X._visibleChanged=N,X.visible=x,X.elementHeight=O,X.elementWidth=y,X.index=w,X.offsetX=H,X.offsetY=W,X.visibleX=C,X.visibleY=S,X.intersectX=T,X.intersectY=q,X.viewportX=z,X.viewportY=F,X.visible=x)}h||!E&&!p||(g=A,s.push(g),u(),h=function(){!(s=s.filter((function(e){return e!==g}))).length&&n&&(cancelAnimationFrame(n),n=0)})}function A(){W(),E&&(E=!1,c(D,{scrollDirX:L.scrollDirX,scrollDirY:L.scrollDirY}),X(D,L),w(D,L,P));for(var e=P.length-1;-1<e;e--){var t=P[e],n=t.element,i=t.visible,o=n.hasAttribute("scrollout-once")||!1;t._changed&&(t._changed=!1,X(n,t)),t._visibleChanged&&(c(n,{scroll:i?"in":"out"}),m(n,t,D),(i?p:g)(n,t,D)),i&&(r.once||o)&&P.splice(e,1)}}function W(){h&&(h(),h=void 0)}_(),H(),A();var x=0,O=function(){x=x||setTimeout((function(){x=0,H()}),0)};return window.addEventListener("resize",O),b.addEventListener("scroll",O),{index:_,update:H,teardown:function(){W(),window.removeEventListener("resize",O),b.removeEventListener("scroll",O)}}}}();
/*------- Scroll Out JS Ends ---------*/

// Lenis Init
  const lenis = new Lenis({
	lerp:0.15, duration:1, smooth:true, smoothWheel:true, smoothTouch:false,
	prevent: (node) =>
		node.closest('.c-flymenu')
	});

  window.lenis = lenis;
  function raf(time) {
    lenis.raf(time);
    requestAnimationFrame(raf);
  }
  requestAnimationFrame(raf);



/**
 * Custom Lenis scroll speed / parallax effect.
 *
 * data-scroll-speed="0.8" = slower movement
 * data-scroll-speed="1"   = normal movement
 * data-scroll-speed="1.5" = faster movement
 */

function initScrollSpeed(lenisInstance) {
    if (!lenisInstance) return;
    const elements = document.querySelectorAll('[data-scroll-speed]');
    if (!elements.length) return;
    const items = Array.from(elements).map((element) => ( { element, speed: parseFloat(element.dataset.scrollSpeed) || 1, startTop: 0, height: 0, currentY: 0, targetY: 0 }
));

function updatePositions() {
  items.forEach((item) => { const rect = item.element.getBoundingClientRect(); item.startTop = rect.top + window.scrollY; item.height = rect.height; }
); }

  function updateScroll() {
      const scrollY = lenisInstance.scroll;
      items.forEach((item) => {
          const elementTop = item.startTop - scrollY;
          const viewportCenter = window.innerHeight / 2;
          const elementCenter = elementTop + item.height / 2;

          item.targetY =
            (viewportCenter - elementCenter) * (item.speed - 1) * -0.15;
            item.currentY += (item.targetY - item.currentY) * 0.12;
            item.element.style.transform = `translate3d(0, ${item.currentY.toFixed(2)}px, 0)`;
      });
  }

  function raf() {
    updateScroll(); requestAnimationFrame(raf);
  }

  updatePositions();
  lenisInstance.on('scroll', updateScroll);
  window.addEventListener('resize', updatePositions);

  raf();

  return {
      refresh: updatePositions,
      destroy() {
          lenisInstance.off('scroll', updateScroll);
          window.removeEventListener('resize', updatePositions);

          items.forEach((item) => {
              item.element.style.transform = '';
          });
      }
  };
}

// Use your existing Lenis instance:
const scrollSpeedEffect = initScrollSpeed(lenis);


// #links Management
const headOffset = -1;
if (window.location.hash) {
  const target = document.querySelector(window.location.hash);
  if (target) {
    setTimeout(() => {
      lenis.scrollTo(target, { offset: - headOffset });
    }, 100);
  }
}

document.addEventListener('click', (e) => {
  const link = e.target.closest('a[href^="#"]');
  if (!link) return;

  const target = document.querySelector(link.getAttribute('href'));
  if (!target) return;
  e.preventDefault();
  lenis.scrollTo(target, { offset: - headOffset });
});

// Header JS 
(function () {
	const body = document.querySelector("body");
	const siteHeader = document.querySelector(".c-head");
	const menuButton = document.querySelector('.c-menu-toggle');
	const menuLabelEl = document.querySelector('.c-menu-toggle__label');
	const siteNav = document.querySelector('#primary-menu');

	if (!siteHeader) return;

	function menuOpen() {
		menuLabelEl.innerText = 'Close Menu';
		menuButton.setAttribute('aria-label', 'Close Menu');
		body.classList.add('no-scroll', 'menu-open');
		menuButton.classList.add('is-opened');
		siteNav.removeAttribute('hidden');
		siteNav.classList.add('is-active');
    lenis.stop();
	}

	function menuClose() {
		menuLabelEl.innerText = 'Menu';
		body.classList.remove('no-scroll', 'menu-open');
		siteNav.setAttribute('hidden', '');
		menuButton.classList.remove('is-opened');
		siteNav.classList.remove('is-active');
		menuButton.setAttribute('aria-label', 'Open Menu');
		jQuery('.c-nav__submenu.is-open .c-nav__submenu-trigger--back').trigger('click');
    lenis.start();
  }
 
	// Main menu toggle
	menuButton.addEventListener('click', () => {
		(menuLabelEl.innerText === "Menu") ? menuOpen() : menuClose();
	});

  // Header Color Switcher

  const header = document.querySelector('.c-head');
	const sections = document.querySelectorAll('.c-block, .c-foot__right, .c-foot__newsletter__content');

	function getBrightness(rgb) {
		const result = rgb.match(/\d+/g);
		if (!result) return 255;
		const r = parseInt(result[0]);
		const g = parseInt(result[1]);
		const b = parseInt(result[2]);
		return (r * 299 + g * 587 + b * 114) / 1000;
	}

	function getEffectiveBg(el) {
		while (el && el !== document) {
			const bg = window.getComputedStyle(el).backgroundColor;
			if (bg && bg !== 'transparent' && bg !== 'rgba(0, 0, 0, 0)') {
				return bg;
			}
			el = el.parentElement;
		}
		return 'rgb(255, 255, 255)';
	}

	function getSkinType(el) {
		const bg = getEffectiveBg(el);
		const brightness = getBrightness(bg);
		return brightness > 155 ? 'light' : 'dark';
	}
	sections.forEach((el) => {
		const type = getSkinType(el);
		el.classList.remove('light-bg', 'dark-bg');
		el.classList.add(type === 'light' ? 'light-bg' : 'dark-bg');
	});

	function getCurrentSection() {
		const headerHeight = header.offsetHeight;

		for (let el of sections) {
			const rect = el.getBoundingClientRect();

			if (rect.top <= headerHeight && rect.bottom > headerHeight) {
				return el;
			}
		}
		return null;
	}

	let currentSkin = '';

	function updateHeaderSkin() {

    jQuery('body').css('--head-offest', jQuery('.c-head').outerHeight()+'px');
		
		const current = getCurrentSection();
		if (!current) return;

		const newSkin = current.classList.contains('light-bg')
			? 'dark-skin'
			: 'light-skin';

		if (newSkin !== currentSkin) {
			header.classList.remove('light-skin', 'dark-skin');
			header.classList.add(newSkin);
			currentSkin = newSkin;
		}

		if ( window.scrollY > (window.innerHeight) ) {
			header.classList.add('is-sticky');
		} else {
			header.classList.remove('is-sticky');
		}
	}

	if (typeof lenis !== 'undefined') {
		lenis.on('scroll', updateHeaderSkin);
	} else {
		window.addEventListener('scroll', updateHeaderSkin);
	}
	window.addEventListener('load', updateHeaderSkin);


})();
// Header JS Ends
 
	function smoothScroll() {
		ScrollOut({ targets: '.anim, .c-media', onShown(el) { el.classList.add("in"); } });
		ScrollOut({ targets: '[data-srcset]', onShown(el) { el.setAttribute('srcset', el.dataset.srcset); } }); 
		ScrollOut({ targets: '.custom-video.autoplay',
			onShown(video) {
				const source = video.querySelector('source');
				if (!source || source.src) return;
				source.src = source.dataset.src;
				video.load();
				if (video.autoplay) {
					video.play().catch(() => {});
				}
			}
		});

		ScrollOut({
			targets: '.anim.repeat', onShown(el) { el.classList.add("in"); el.classList.remove("out"); threshold: .3; }, onHidden(el) {
				el.classList.remove("in"); el.classList.add("out");
			}
		});

		ScrollOut({
			targets: '.c-block, .c-foot__right, .c-foot__newsletter__content', onShown(el) { 
				el.classList.add("in"); el.classList.remove("out"); threshold: .3; }, 
				onHidden(el) {
				el.classList.remove("in"); el.classList.add("out");
			}
		});
	}


// Youtube/Vimeo/Video loading Ends
document.addEventListener('DOMContentLoaded', function () {
  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el = entry.target;
      // Handle Lazy Load Images
      if (el.tagName.toLowerCase() === 'img' && el.hasAttribute('data-srcset')) {
        el.setAttribute('srcset', el.getAttribute('data-srcset'));
        el.setAttribute('sizes', el.getAttribute('data-sizes'));
        el.classList.add('loaded')
      }

      // add animation class
      if (el.classList.contains('anim') || el.classList.contains('c-media') ) {
        el.classList.add('in');
      }

      // Handle YouTube iframe
      if (el.tagName.toLowerCase() === 'iframe' && el.hasAttribute('data-src')) {
        const originalUrl = el.getAttribute('data-src');
        let embedUrl = '';

        // Handle YouTube: https://www.youtube.com/watch?v=xyz
        const ytMatch = originalUrl.match(/youtube\.com.*[?&]v=([^&]+)/);
        if (ytMatch && ytMatch[1]) {
          const videoId = ytMatch[1];
          embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&mute=1&playsinline=1&loop=1`;
        }

        // Handle Vimeo: https://vimeo.com/123456789
        const vimeoMatch = originalUrl.match(/vimeo\.com\/(\d+)/);
        if (vimeoMatch && vimeoMatch[1]) {
          const videoId = vimeoMatch[1];
          embedUrl = `https://player.vimeo.com/video/${videoId}?autoplay=1&muted=1&playsinline=1&loop=1`;
        }

        // If embed URL is generated, replace it
        if (embedUrl) {
          el.setAttribute('src', embedUrl);
          el.setAttribute('allow', 'autoplay; encrypted-media');
          el.setAttribute('allowfullscreen', '');
        }

        observer.unobserve(el);
      }

      // Handle <video> with <source data-src="...">
      if (el.tagName.toLowerCase() === 'video') {
        const source = el.querySelector('source[data-src]');
        if (source && !el.classList.contains('clickToplay')) {
          const src = source.dataset.src;
          source.src = src;
          source.removeAttribute('data-src');

          el.load();
          el.play().catch(() => {
            // autoplay blocked – ignore
          });
          observer.unobserve(el);
        }
      }

    });
  }, {
    root: null,
    threshold: 0.01
  });

  // Observe relevant elements
  document.querySelectorAll('img[data-srcset]').forEach(el => {
    observer.observe(el);
  });

  document.querySelectorAll('.c-media, .anim').forEach(el => {
    observer.observe(el);
  });

  document.querySelectorAll('iframe[data-src], video:has(source[data-src])').forEach(el => {
    observer.observe(el);
  });
});
// ==================================
// Click To Play Videos
// ==================================
document.addEventListener('DOMContentLoaded', () => {

    const mobileBreakpoint = 991;

    /**
     * Set the correct source for a video.
     */
    function updateVideoSource(video) {

        const desktopSrc = video.dataset.desktop || '';
        const mobileSrc  = video.dataset.mobile || '';

        const isMobile = window.innerWidth < mobileBreakpoint;

        // Fallback to desktop when no mobile video exists
        const newSrc = isMobile
            ? (mobileSrc || desktopSrc)
            : desktopSrc;

        if (!newSrc) {
            return;
        }

        const source = video.querySelector('source');

        if (source.getAttribute('src') === newSrc) {
            return;
        }

        const wasPlaying = !video.paused;
        const currentTime = video.currentTime;

        source.src = newSrc;
        video.load();

        video.addEventListener('loadedmetadata', function restore() {

            video.removeEventListener('loadedmetadata', restore);

            try {
                if (currentTime > 0) {
                    video.currentTime = currentTime;
                }
            } catch (e) {}

            if (wasPlaying || video.classList.contains('autoplay')) {
                video.play().catch(() => {});
            }

        });

    }

    /**
     * Pause every click-to-play video except the current one.
     * Ignore autoplay/background videos.
     */
    function pauseOtherVideos(currentVideo) {

        document.querySelectorAll('.custom-video').forEach(video => {

            if (video === currentVideo) {
              return;
            }

            if (video.classList.contains('autoplay')) {
              return;
            }

            video.pause();

            const wrapper = video.closest('.c-video-wrap');
            if (!wrapper) return;

            const button = wrapper.querySelector('.play-btn');

            if (button) {
              button.classList.remove('is-playing');
              button.setAttribute('aria-label', 'Play video');
              button.setAttribute('aria-pressed', 'false');
            }

        });

    }

    /**
     * Initialize videos.
     */
    document.querySelectorAll('.custom-video').forEach(video => {

        updateVideoSource(video);

        if (video.classList.contains('autoplay')) {
            video.play().catch(() => {});
        }

        const wrapper = video.closest('.c-video-wrap');
        if (!wrapper) return;

        const button = wrapper.querySelector('.play-btn');
        if (!button) return;

        video.addEventListener('play', () => {

            pauseOtherVideos(video);

            button.classList.add('is-playing');
            button.setAttribute('aria-label', 'Pause video');
            button.setAttribute('aria-pressed', 'true');

        });

        video.addEventListener('pause', () => {

            button.classList.remove('is-playing');
            button.setAttribute('aria-label', 'Play video');
            button.setAttribute('aria-pressed', 'false');

        });

        button.addEventListener('click', () => {

            if (video.paused) {
                pauseOtherVideos(video);
                video.play().catch(() => {});
            } else {
                video.pause();
            }

        });

    });

 /**
 * Update sources when crossing the breakpoint.
 */
 let wasMobile = window.innerWidth < mobileBreakpoint;

  window.addEventListener('resize', () => {
    const isMobile = window.innerWidth < mobileBreakpoint;
    if (isMobile === wasMobile) { return; }
    wasMobile = isMobile;
    document.querySelectorAll('.custom-video').forEach(updateVideoSource);
  });

});
// Youtube/Vimeo/Video Iframes loading Ends

/*-------------------------------------------------------- Popup JS ---------------------------------------------------*/
(function () {
  const root = document.documentElement;
  const focusableSelector = 'a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [contenteditable], [tabindex]:not([tabindex="-1"])';

  let lastFocused = null;
  let activeDialog = null;

  // Helper: prevent scroll and pause Lenis
  const lockScroll = () => {
    root.classList.add('no-scroll');
    lenis.stop();
  };

  // Helper: restore scroll and resume Lenis
  const unlockScroll = () => {
    root.classList.remove('no-scroll');
    lenis.start();
  };

  // Trap focus within dialog
  function trapFocus(event) {
    if (!activeDialog) return;
    const focusables = Array.from(activeDialog.querySelectorAll(focusableSelector));
    if (!focusables.length) return;
    const first = focusables[0];
    const last = focusables[focusables.length - 1];

    if (event.key === 'Tab') {
      if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
      } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
      }
    } else if (event.key === 'Escape') {
      event.preventDefault();
      closeDialog(activeDialog);
    }
  }

  function openDialog(dialog) {
    if (!(dialog instanceof HTMLDialogElement)) return;

    lastFocused = document.activeElement;
    activeDialog = dialog;
    dialog.showModal();

    lockScroll();
   
    // Focus first focusable element
    const firstFocusable = dialog.querySelector(focusableSelector);
    (firstFocusable || dialog).focus();
    
    setTimeout(() => {
      firstFocusable.focus();
    }, 900);

    document.addEventListener('keydown', trapFocus);
  }

  function closeDialog(dialog) {
    if (!(dialog instanceof HTMLDialogElement)) return;
    
    dialog.close();
    unlockScroll();

    // Restore focus
    if (lastFocused) lastFocused.focus();

    document.removeEventListener('keydown', trapFocus);
    activeDialog = null;
  }

  // Open dialog on trigger click
  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('.dialog-open-trigger');
    if (!trigger) return;

    const dialogId = trigger.getAttribute('aria-controls');
    const dialog = document.getElementById(dialogId);
    if (dialog) {
      e.preventDefault();
      openDialog(dialog);
    }
  });

  // Close dialog on .dialog-close-trigger click
  document.addEventListener('click', (e) => {
    const closeBtn = e.target.closest('.dialog-close-trigger');
    if (!closeBtn) return;

    const dialog = closeBtn.closest('.c-dialog');
    if (dialog) {
      e.preventDefault();
      closeDialog(dialog);
    }
  });

  // Close when clicking backdrop
  document.querySelectorAll('.c-dialog').forEach((dialog) => {
    dialog.addEventListener('click', (e) => {
      const panel = dialog.querySelector('.c-dialog__panel');
      if (panel && !panel.contains(e.target)) {
        closeDialog(dialog);
      }
    });
  });
})();
/*-------------------------------------------------------- Popup JS Ends ---------------------------------------------------*/



/*-------------- Accordion Starts --------------*/
 
jQuery(function ($) {

    $('.c-faqs').each(function () {

        var $faq = $(this);
        var $items = $faq.find('.c-faqs__item');

        /*
         * FAQ settings
         */
        var isOneOpen   = $faq.hasClass('oneOpen');
        var isAnyOpen   = $faq.hasClass('anyOpen');
        var isFirstOpen = $faq.hasClass('firstOpen');
        var isAllClosed = $faq.hasClass('allClosed');


        /*
         * Open FAQ
         */
        function openFaq($item, animate) {

            var $question = $item.find('.c-faqs__question').first();
            var $answer = $item.find('.c-faqs__answer').first();

            /*
             * Update state
             */
            $item.addClass('is-open');

            $question.attr('aria-expanded', 'true');

            $answer.attr('aria-hidden', 'false');


            /*
             * Animation
             */
            if (animate) {

                $answer
                    .stop(true, true)
                    .slideDown(350);

            } else {

                $answer.show();

            }
        }


        /*
         * Close FAQ
         */
        function closeFaq($item, animate) {

            var $question = $item.find('.c-faqs__question').first();
            var $answer = $item.find('.c-faqs__answer').first();

            /*
             * Update state
             */
            $item.removeClass('is-open');

            $question.attr('aria-expanded', 'false');

            $answer.attr('aria-hidden', 'true');


            /*
             * Animation
             */
            if (animate) {

                $answer
                    .stop(true, true)
                    .slideUp(350);

            } else {

                $answer.hide();

            }
        }


        /*
         * Close all FAQs except selected one
         */
        function closeOtherFaqs($currentItem) {

            if (!isOneOpen) {
                return;
            }

            $items.each(function () {

                var $item = $(this);

                if ($item[0] !== $currentItem[0]) {

                    closeFaq($item, true);

                }

            });
        }


        /*
         * Toggle FAQ
         */
        function toggleFaq($item) {

            /*
             * If already open → close it
             */
            if ($item.hasClass('is-open')) {

                closeFaq($item, true);

                return;
            }


            /*
             * oneOpen
             *
             * Close all other FAQs first.
             */
            closeOtherFaqs($item);


            /*
             * Open selected FAQ
             */
            openFaq($item, true);
        }


        /*
         * Initial state
         */
        $items.each(function () {

            closeFaq($(this), false);

        });


        /*
         * First FAQ open by default
         *
         * firstOpen takes priority over allClosed
         */
        if (
            isFirstOpen &&
            !isAllClosed &&
            $items.length
        ) {

            openFaq($items.first(), false);

        }


        /*
         * Click
         */
        $items.find('.c-faqs__question').on('click', function () {

            var $item = $(this).closest('.c-faqs__item');

            toggleFaq($item);

        });


        /*
         * Keyboard accessibility
         *
         * Native <button> already supports:
         *
         * Enter
         * Space
         *
         * So we don't need custom keydown handling.
         *
         * This is intentionally left empty.
         */


    });

});

/*-------------- Accordion Ends --------------*/

