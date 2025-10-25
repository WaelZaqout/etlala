// =========================
// Main JavaScript File
// Consolidated & Optimized Version
// =========================

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM Content Loaded - Starting initialization...');

    // =========================
    // LOADING SCREEN
    // =========================
    const loadingScreen = document.querySelector('.loading-screen');
    const loadingBar = document.querySelector('.loading-bar');

    if (loadingScreen && loadingBar) {
        let width = 0;
        const interval = setInterval(() => {
            width += 2;
            loadingBar.style.width = width + '%';
            if (width >= 100) {
                clearInterval(interval);
                setTimeout(() => {
                    loadingScreen.style.opacity = '0';
                    setTimeout(() => {
                        loadingScreen.style.display = 'none';
                    }, 500);
                }, 500);
            }
        }, 50);
    }

    // =========================
    // MOBILE MENU FUNCTIONALITY
    // =========================
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenuClose = document.querySelector('.mobile-menu-close');
    const mobileMenu = document.querySelector('.mobile-menu');
    const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
    const mobileMenuItems = document.querySelectorAll('.stagger-animation');

    function openMobileMenu() {
        if (mobileMenu && mobileMenuOverlay) {
            mobileMenu.classList.add('active');
            mobileMenuOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';

            // Animate menu items
            setTimeout(() => {
                mobileMenuItems.forEach((item, index) => {
                    if (item) {
                        item.style.animationDelay = `${index * 0.05}s`;
                        item.style.animation = 'staggerFade 0.4s ease forwards';
                    }
                });
            }, 100);
        }
    }

    function closeMobileMenu() {
        if (mobileMenu && mobileMenuOverlay) {
            mobileMenu.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';

            // Reset animations
            mobileMenuItems.forEach(item => {
                if (item) {
                    item.classList.remove('active');
                }
            });
        }
    }

    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', openMobileMenu);
    }

    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', closeMobileMenu);
    }

    if (mobileMenuOverlay) {
        mobileMenuOverlay.addEventListener('click', closeMobileMenu);
    }

    // =========================
    // HEADER SCROLL EFFECT
    // =========================
    const header = document.querySelector('header');
    if (header) {
        let lastScrollTop = 0;
        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > 20) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }

            lastScrollTop = scrollTop;
        });
    }

    // =========================
    // SCROLL ANIMATIONS
    // =========================
    function checkScroll() {
        const elements = document.querySelectorAll('.slide-up, .product-card');
        const windowHeight = window.innerHeight;

        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            if (elementTop < windowHeight - 50) {
                element.classList.add('visible');
            }
        });
    }

    // Initialize animations on load
    setTimeout(() => {
        const slideUpElements = document.querySelectorAll('.slide-up');
        slideUpElements.forEach((element, index) => {
            const delay = element.classList.contains('delay-100') ? 0.1 :
                element.classList.contains('delay-200') ? 0.2 :
                    element.classList.contains('delay-300') ? 0.3 :
                        element.classList.contains('delay-400') ? 0.4 :
                            element.classList.contains('delay-500') ? 0.5 :
                                element.classList.contains('delay-600') ? 0.6 :
                                    element.classList.contains('delay-700') ? 0.7 :
                                        element.classList.contains('delay-800') ? 0.8 :
                                            element.classList.contains('delay-900') ? 0.9 :
                                                element.classList.contains('delay-1000') ? 1.0 :
                                                    element.classList.contains('delay-1100') ? 1.1 :
                                                        element.classList.contains('delay-1200') ? 1.2 : 0;

            setTimeout(() => {
                element.classList.add('visible');
            }, delay * 1000);
        });
    }, 300);

    // Product card animations
    setTimeout(() => {
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('visible');
            }, 500 + (index % 5) * 100);
        });
    }, 500);

    // Add scroll event listener
    window.addEventListener('scroll', checkScroll);
    checkScroll(); // Check on load

    // =========================
    // WISHLIST FUNCTIONALITY
    // =========================
    const heartButtons = document.querySelectorAll('.wishlist-button, .product-favorite');
    heartButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const icon = this.querySelector('i');

            if (icon) {
                if (icon.classList.contains('far')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    icon.style.color = 'var(--secondary)';
                    this.style.transform = 'scale(1.2)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 300);
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    icon.style.color = '';
                }
            } else {
                // Handle buttons without icons
                this.classList.toggle('liked');
                if (this.classList.contains('liked')) {
                    this.innerHTML = '<i class="fas fa-heart"></i>';
                } else {
                    this.innerHTML = '<i class="far fa-heart"></i>';
                }
            }
        });
    });

    // =========================
    // CAROUSEL FUNCTIONALITY
    // =========================

    const prevBtn = document.querySelector('.carousel-nav.prev');
    const nextBtn = document.querySelector('.carousel-nav.next');
    const carouselTrack = document.querySelector('.carousel-track');
    const carouselItems = document.querySelectorAll('.carousel-card'); // استخدم فقط carousel-card

    if (prevBtn && nextBtn && carouselTrack && carouselItems.length > 0) {
        let currentIndex = 0;

        function updateCarousel() {
            const itemWidth = carouselItems[0].offsetWidth + parseInt(getComputedStyle(carouselTrack).gap || 0);
            carouselTrack.scrollTo({
                left: currentIndex * itemWidth,
                behavior: 'smooth'
            });
        }

        prevBtn.addEventListener('click', () => {
            currentIndex--;
            if (currentIndex < 0) currentIndex = 0; // لا تخرج عن الحد الأدنى
            updateCarousel();
        });

        nextBtn.addEventListener('click', () => {
            currentIndex++;
            if (currentIndex > carouselItems.length - 1) currentIndex = carouselItems.length - 1; // لا تخرج عن الحد الأقصى
            updateCarousel();
        });

        // إعادة الحساب عند تغيير حجم الشاشة
        window.addEventListener('resize', updateCarousel);
    }


    // =========================
    // VIEW OPTIONS TOGGLE
    // =========================
    const viewOptions = document.querySelectorAll('.view-option');
    viewOptions.forEach(option => {
        option.addEventListener('click', function () {
            viewOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // =========================
    // FILTER FUNCTIONALITY
    // =========================
    // Remove filter tags
    const removeFilters = document.querySelectorAll('.remove-filter');
    removeFilters.forEach(filter => {
        filter.addEventListener('click', function () {
            this.parentElement.remove();
        });
    });

    // Apply button for price range
    const applyBtn = document.querySelector('.apply-btn');
    if (applyBtn) {
        applyBtn.addEventListener('click', function () {
            this.innerHTML = 'APPLYING...';
            this.style.transform = 'translateY(2px)';

            setTimeout(() => {
                this.innerHTML = 'APPLIED!';
                this.style.background = 'linear-gradient(135deg, #2ecc71, #27ae60)';

                setTimeout(() => {
                    this.innerHTML = 'APPLY';
                    this.style.background = 'linear-gradient(135deg, var(--primary), #e0a88a)';
                    this.style.transform = 'translateY(0)';
                }, 1500);
            }, 800);
        });
    }

    // Clear all filters
    const clearFiltersBtn = document.querySelector('.clear-filters');
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function () {
            // Reset all checkboxes
            const checkboxes = document.querySelectorAll('.filter-checkbox input');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });

            // Show success message
            this.innerHTML = 'CLEARED!';
            this.style.background = 'linear-gradient(135deg, #2ecc71, #27ae60)';

            setTimeout(() => {
                this.innerHTML = 'CLEAR ALL FILTERS';
                this.style.background = 'var(--white)';
                this.style.color = 'var(--primary)';
            }, 1500);
        });
    }

    // Filter section collapse/expand
    const filterTitles = document.querySelectorAll('.filter-title');
    filterTitles.forEach(title => {
        title.addEventListener('click', function () {
            const content = this.nextElementSibling;
            const icon = this.querySelector('.collapse-icon');

            content.classList.toggle('collapsed');
            icon.classList.toggle('collapsed');

            if (content.classList.contains('collapsed')) {
                content.style.maxHeight = '0';
            } else {
                content.style.maxHeight = content.scrollHeight + 'px';
            }
        });
    });

    // Mobile filter button
    const mobileFilterBtn = document.querySelector('.mobile-filter-btn');
    const filterSidebar = document.querySelector('.filter-sidebar');

    if (mobileFilterBtn && filterSidebar && mobileMenuOverlay) {
        mobileFilterBtn.addEventListener('click', function () {
            filterSidebar.classList.add('active');
            mobileMenuOverlay.classList.add('active');
        });

        mobileMenuOverlay.addEventListener('click', function () {
            if (filterSidebar.classList.contains('active')) {
                filterSidebar.classList.remove('active');
                this.classList.remove('active');
            }
        });
    }

    // =========================
    // DESKTOP SELECTORS
    // =========================
    const desktopCountry = document.querySelector('.desktop-country');
    if (window.innerWidth >= 768 && desktopCountry) {
        desktopCountry.style.display = 'block';
    }

    const desktopLang = document.querySelector('.desktop-lang');
    if (window.innerWidth >= 768 && desktopLang) {
        desktopLang.style.display = 'block';
    }

    // Responsive adjustments
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 768) {
            if (desktopCountry) desktopCountry.style.display = 'block';
            if (desktopLang) desktopLang.style.display = 'block';
        } else {
            if (desktopCountry) desktopCountry.style.display = 'none';
            if (desktopLang) desktopLang.style.display = 'none';
        }
    });

    // =========================
    // ANIMATIONS & EFFECTS
    // =========================
    // Add floating animation to the "JOIN OR LOG IN" button
    const joinButton = document.querySelector('.cta-button.float');
    if (joinButton) {
        joinButton.style.animation = 'float 3s ease-in-out infinite';
    }

    // Add pulse animation to the hero CTA button
    const heroCta = document.querySelector('.hero-cta');
    if (heroCta) {
        heroCta.style.animation = 'pulse 2s ease-in-out infinite';
    }

    // Add hover effects to various elements
    const categoryItems = document.querySelectorAll('.category-item');
    categoryItems.forEach(item => {
        item.style.transition = 'all 0.3s ease';
        item.style.cursor = 'pointer';
    });

    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.style.transition = 'all 0.3s ease';
        card.style.cursor = 'pointer';
    });

    const highlightItems = document.querySelectorAll('.highlight-item');
    highlightItems.forEach(item => {
        item.style.transition = 'all 0.3s ease';
        item.style.cursor = 'pointer';
    });

    const sneakerCards = document.querySelectorAll('.sneaker-card');
    sneakerCards.forEach(card => {
        card.style.transition = 'all 0.3s ease';
        card.style.cursor = 'pointer';
    });

    // Add hover effects to images
    const heroImage = document.querySelector('.hero-image');
    if (heroImage) {
        heroImage.style.transition = 'transform 0.5s ease';
        heroImage.style.cursor = 'pointer';
    }

    const filmImage = document.querySelector('.film-image');
    if (filmImage) {
        filmImage.style.transition = 'transform 0.5s ease';
        filmImage.style.cursor = 'pointer';
    }

    const brandImage = document.querySelector('.brand-image');
    if (brandImage) {
        brandImage.style.transition = 'transform 0.5s ease';
        brandImage.style.cursor = 'pointer';
    }

    // Add hover effects to buttons and links
    const newsletterButton = document.querySelector('.newsletter-button');
    if (newsletterButton) {
        newsletterButton.style.transition = 'all 0.3s ease';
        newsletterButton.style.cursor = 'pointer';
    }

    const socialIcons = document.querySelectorAll('.social-links a');
    socialIcons.forEach(icon => {
        icon.style.transition = 'all 0.3s ease';
        icon.style.cursor = 'pointer';
    });

    const footerLinks = document.querySelectorAll('.footer-links a');
    footerLinks.forEach(link => {
        link.style.transition = 'all 0.3s ease';
        link.style.cursor = 'pointer';
    });

    const appStoreButtons = document.querySelectorAll('.app-store');
    appStoreButtons.forEach(button => {
        button.style.transition = 'all 0.3s ease';
        button.style.cursor = 'pointer';
    });

    // =========================
    // DROPDOWN MENUS
    // =========================
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.addEventListener('mouseenter', function () {
            const dropdown = this.querySelector('.dropdown');
            if (dropdown) {
                dropdown.style.opacity = '1';
                dropdown.style.visibility = 'visible';
                dropdown.style.transform = 'translateY(0)';
            }
        });

        item.addEventListener('mouseleave', function () {
            const dropdown = this.querySelector('.dropdown');
            if (dropdown) {
                dropdown.style.opacity = '0';
                dropdown.style.visibility = 'hidden';
                dropdown.style.transform = 'translateY(-10px)';
            }
        });
    });

    // =========================
    // IMAGE MODAL FUNCTIONALITY
    // =========================
    const modal = document.querySelector('.image-modal');
    const modalImage = document.getElementById('modal-image');
    const modalClose = document.querySelector('.modal-close');
    const modalOverlay = document.querySelector('.modal-overlay');
    const modalThumbnails = document.getElementById('modal-thumbnails');
    const quickViews = document.querySelectorAll('.quick-view');

    let currentImages = [];
    let currentIndex = 0;

    function openModal(imageSrc, images = []) {
        if (modal && modalImage) {
            console.log('openModal called with imageSrc:', imageSrc);
            currentImages = images.length > 0 ? images : [imageSrc];
            currentIndex = images.length > 0 ? images.indexOf(imageSrc) : 0;

            if (currentIndex === -1) currentIndex = 0;

            showImage(currentIndex);
            createThumbnails();
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal() {
        if (modal) {
            console.log('closeModal called');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
            // Clear thumbnails
            if (modalThumbnails) {
                modalThumbnails.innerHTML = '';
            }
        }
    }

    function showImage(index) {
        if (modal && modalImage && currentImages[index]) {
            modalImage.src = currentImages[index];
            updateActiveThumbnail(index);
        }
    }

    function createThumbnails() {
        if (!modalThumbnails) return;

        modalThumbnails.innerHTML = '';

        currentImages.forEach((imageSrc, index) => {
            const thumbnail = document.createElement('div');
            thumbnail.className = 'modal-thumbnail';
            thumbnail.innerHTML = `<img src="${imageSrc}" alt="Thumbnail ${index + 1}" loading="lazy">`;

            thumbnail.addEventListener('click', () => {
                currentIndex = index;
                showImage(index);
            });

            modalThumbnails.appendChild(thumbnail);
        });

        updateActiveThumbnail(currentIndex);
    }

    function updateActiveThumbnail(activeIndex) {
        if (!modalThumbnails) return;

        const thumbnails = modalThumbnails.querySelectorAll('.modal-thumbnail');
        thumbnails.forEach((thumb, index) => {
            if (index === activeIndex) {
                thumb.classList.add('active');
            } else {
                thumb.classList.remove('active');
            }
        });
    }

    // Quick view buttons
    quickViews.forEach(quickView => {
        quickView.addEventListener('click', function (e) {
            console.log('quickView clicked');
            e.preventDefault();
            e.stopPropagation();
            const productCard = this.closest('.product-card');
            if (productCard) {
                const productImages = Array.from(productCard.querySelectorAll('.product-img, .product-image')).map(img => img.src);
                const mainImage = productCard.querySelector('.product-img, .product-image');

                if (mainImage && mainImage.src) {
                    openModal(mainImage.src, productImages);
                }
            }
        });
    });

    // Modal controls
    if (modalClose) {
        modalClose.addEventListener('click', closeModal);
    }

    if (modalOverlay) {
        modalOverlay.addEventListener('click', closeModal);
    }

    // Keyboard controls
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal && modal.classList.contains('active')) {
            closeModal();
        } else if (e.key === 'ArrowLeft' && modal && modal.classList.contains('active')) {
            e.preventDefault();
            currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
            showImage(currentIndex);
        } else if (e.key === 'ArrowRight' && modal && modal.classList.contains('active')) {
            e.preventDefault();
            currentIndex = (currentIndex + 1) % currentImages.length;
            showImage(currentIndex);
        }
    });

    // Modal navigation buttons
    const modalPrev = document.querySelector('.modal-prev');
    const modalNext = document.querySelector('.modal-next');

    if (modalPrev) {
        modalPrev.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
            showImage(currentIndex);
        });
    }

    if (modalNext) {
        modalNext.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % currentImages.length;
            showImage(currentIndex);
        });
    }

    // =========================
    // PRODUCT CARD HOVER EFFECTS
    // =========================
    productCards.forEach(card => {
        // Skip hover effects for highlight items and other specific products
        if (card.closest('.highlight-item') || card.classList.contains('no-hover-bg')) {
            return;
        }

        card.addEventListener('mouseenter', () => {
            const image = card.querySelector('.product-img, .product-image');
            const imageAlt = card.querySelector('.product-img-alt, .product-image-alt');

            if (image) image.style.opacity = '0';
            if (imageAlt) imageAlt.style.opacity = '1';
        });

        card.addEventListener('mouseleave', () => {
            const image = card.querySelector('.product-image, .product-img');
            const imageAlt = card.querySelector('.product-image-alt, .product-img-alt');
            if (image) image.style.opacity = '1';
            if (imageAlt) imageAlt.style.opacity = '0';
        });
    });

    // =========================
    // HIGHLIGHT ITEM HOVER EFFECTS
    // =========================
    highlightItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            const image = item.querySelector('.highlight-image');
            if (image) {
                image.style.opacity = '0.7'; // Slight opacity change instead of white background
            }
        });

        item.addEventListener('mouseleave', () => {
            const image = item.querySelector('.highlight-image');
            if (image) {
                image.style.opacity = '1'; // Restore full opacity
            }
        });
    });

    // =========================
    // COLOR DOT SELECTION
    // =========================
    const colorDots = document.querySelectorAll('.color-dot');
    colorDots.forEach(dot => {
        dot.addEventListener('click', function () {
            // Remove active class from siblings
            const siblings = this.parentElement.querySelectorAll('.color-dot');
            siblings.forEach(sibling => {
                sibling.classList.remove('active');
            });
            // Add active class to clicked dot
            this.classList.add('active');
        });
    });

    // =========================
    // VIEW SWITCHER
    // =========================
    const buttons = document.querySelectorAll('.view-switcher button');
    const productGrid = document.querySelector('.product-grid');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const cols = btn.getAttribute('data-cols');
            if (productGrid) {
                productGrid.style.gridTemplateColumns = `repeat(${cols}, 1fr)`;
            }
        });
    });

    // =========================
    // SHOW MORE DESIGNERS
    // =========================
    const showMore = document.querySelector('.show-more');
    if (showMore) {
        showMore.addEventListener('click', function (e) {
            e.preventDefault();
            alert('Showing more designers...');
        });
    }

    console.log('DOM Content Loaded - All functionality initialized successfully!');
});

