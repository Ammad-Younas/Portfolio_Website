document.addEventListener('DOMContentLoaded', () => {
    // Theme Toggle Logic
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeIcon = themeToggleBtn ? themeToggleBtn.querySelector('i') : null;

    if (themeToggleBtn && themeIcon) {
        // Check for saved theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'light') {
            document.body.classList.add('light-mode');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }

        themeToggleBtn.addEventListener('click', () => {
            document.body.classList.toggle('light-mode');
            const isLight = document.body.classList.contains('light-mode');
            
            if (isLight) {
                localStorage.setItem('theme', 'light');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            } else {
                localStorage.setItem('theme', 'dark');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            }
        });
    }

    // Mobile Menu Toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const menuContainer = document.querySelector('.menu-container');
    const menuIcon = menuToggle.querySelector('i');

    if (menuToggle && menuContainer) {
        menuToggle.addEventListener('click', () => {
            menuContainer.classList.toggle('active');
            
            if (menuContainer.classList.contains('active')) {
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-xmark');
            } else {
                menuIcon.classList.remove('fa-xmark');
                menuIcon.classList.add('fa-bars');
            }
        });

        // Close menu when clicking a link
        const menuLinks = document.querySelectorAll('.menu a');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                menuContainer.classList.remove('active');
                menuIcon.classList.remove('fa-xmark');
                menuIcon.classList.add('fa-bars');
            });
        });
    }

    // Header Scroll Effect
    const header = document.querySelector('.site-header');
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Intersection Observer for Scroll Animations
    const animatedElements = document.querySelectorAll('.animate-fade-up');
    
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    animatedElements.forEach(el => {
        observer.observe(el);
    });

    // Active Navigation Link on Scroll
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.menu a:not(.btn-primary-nav)');

    window.addEventListener('scroll', () => {
        let current = '';

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            
            if (scrollY >= (sectionTop - 200)) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });

    // Contact Form AJAX Submission
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submit-btn');
            const formMessages = document.getElementById('form-messages');
            const originalBtnText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';
            submitBtn.disabled = true;
            formMessages.innerHTML = '';
            formMessages.className = 'mt-3 form-message';
            
            const formData = new FormData(this);
            formData.append('action', 'submit_contact_form');
            
            fetch(portfolio_ajax.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
                
                if (data.success) {
                    formMessages.classList.add('success');
                    formMessages.innerHTML = data.data.message || 'Message sent successfully!';
                    contactForm.reset();
                } else {
                    formMessages.classList.add('error');
                    formMessages.innerHTML = data.data.message || 'An error occurred. Please try again.';
                }
            })
            .catch(error => {
                console.error(error);
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
                formMessages.classList.add('error');
                formMessages.innerHTML = 'A network error occurred. Please try again.';
            });
        });
    }

    // Projects Filtering
    const filterBtns = document.querySelectorAll('.filter-btn');
    const projectItems = document.querySelectorAll('.project-item');

    if (filterBtns.length > 0 && projectItems.length > 0) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active class
                filterBtns.forEach(b => b.classList.remove('active'));
                // Add to current
                btn.classList.add('active');

                const filterValue = btn.getAttribute('data-filter');

                projectItems.forEach(item => {
                    item.style.transition = 'all 0.3s ease';
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.style.display = 'flex';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'scale(1)';
                        }, 10);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.8)';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
    }

    // Preview Modal
    const certLinks = document.querySelectorAll('.btn-cert, .btn-cert-small, a[href$=".pdf"], a[href$=".jpg"]');
    const modal = document.getElementById('preview-modal');
    const modalContent = document.querySelector('.preview-modal-content');
    const closeBtn = document.querySelector('.preview-modal-close');

    if (modal && modalContent) {
        let viewerElement = null;

        certLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                let url = link.getAttribute('href');
                
                // Clean up previous viewer
                if (viewerElement) {
                    viewerElement.remove();
                }

                if (url && url.toLowerCase().endsWith('.jpg')) {
                    // Create image element for JPGs
                    viewerElement = document.createElement('img');
                    viewerElement.src = url;
                    viewerElement.style.width = '100%';
                    viewerElement.style.height = '100%';
                    viewerElement.style.objectFit = 'contain';
                    viewerElement.style.borderRadius = '12px';
                } else {
                    // Create object for PDFs
                    viewerElement = document.createElement('object');
                    viewerElement.data = url;
                    viewerElement.type = 'application/pdf';
                    viewerElement.style.width = '100%';
                    viewerElement.style.height = '100%';
                    viewerElement.style.border = 'none';
                    viewerElement.style.borderRadius = '12px';
                    viewerElement.innerHTML = `<p style="text-align:center; padding: 50px;">Unable to display PDF. <a href="${url}" target="_blank" style="color:var(--color-orange); text-decoration:underline;">Download it here</a>.</p>`;
                }

                const container = document.getElementById('preview-container');
                container.appendChild(viewerElement);
                modal.style.display = 'block';
            });
        });
        
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
            if (viewerElement) {
                viewerElement.src = '';
            }
        });
        
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
                if (viewerElement) {
                    viewerElement.src = '';
                }
            }
        });
    }
});
