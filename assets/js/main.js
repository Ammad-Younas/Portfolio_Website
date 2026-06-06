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
                filterBtns.forEach(b => b.classList.remove('active'));
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


    // 7-Click Easter Egg for Course Roadmap
    let clickCount = 0;
    let clickTimer = null;
    document.body.addEventListener('click', () => {
        clickCount++;
        clearTimeout(clickTimer);
        if (clickCount >= 7) {
            clickCount = 0;
            const baseUrl = portfolio_ajax.ajax_url.replace('/includes/core/ajax.php', '');
            window.location.href = baseUrl + '/src/courses/course_roadmap.php';
        }
        clickTimer = setTimeout(() => {
            clickCount = 0;
        }, 2000);
    });


    // GitHub README Rendering
    const repoLink = document.getElementById('github-repo-link');
    const readmeContainer = document.getElementById('github-readme-content');
    
    if (repoLink && readmeContainer && typeof marked !== 'undefined') {
        const repoUrl = repoLink.href;
        
        const match = repoUrl.match(/github\.com\/([^\/]+)\/([^\/]+)/);
        if (match) {
            const owner = match[1];
            const repo = match[2].replace(/\/$/, '');
            
            readmeContainer.innerHTML = '<p class="text-muted"><i class="fa-solid fa-spinner fa-spin"></i> Loading full project README...</p>';
            
            const fetchReadme = (branch) => {
                const rawUrl = `https://raw.githubusercontent.com/${owner}/${repo}/${branch}/README.md`;
                return fetch(rawUrl).then(response => {
                    if (!response.ok) throw new Error('Not found');
                    return response.text();
                });
            };

            fetchReadme('main')
                .catch(() => fetchReadme('master'))
                .then(markdown => {
                    readmeContainer.innerHTML = marked.parse(markdown);
                    
                    const mdElements = readmeContainer.querySelectorAll('img');
                    mdElements.forEach(img => {
                        img.style.maxWidth = '100%';
                        img.style.height = 'auto';
                        img.style.borderRadius = '8px';
                        img.style.margin = '10px 0';
                    });

                    // Add Copy Buttons to Code Blocks
                    const preElements = readmeContainer.querySelectorAll('pre');
                    preElements.forEach(pre => {
                        const wrapper = document.createElement('div');
                        wrapper.style.position = 'relative';
                        wrapper.style.marginBottom = '1rem';
                        pre.parentNode.insertBefore(wrapper, pre);
                        wrapper.appendChild(pre);
                        
                        pre.style.margin = '0';

                        const btn = document.createElement('button');
                        btn.className = 'copy-btn';
                        btn.innerHTML = '<i class="fa-regular fa-copy"></i> Copy';
                        btn.addEventListener('click', () => {
                            const code = pre.querySelector('code');
                            if (code) {
                                navigator.clipboard.writeText(code.innerText).then(() => {
                                    btn.innerHTML = '<i class="fa-solid fa-check"></i> Copied!';
                                    setTimeout(() => {
                                        btn.innerHTML = '<i class="fa-regular fa-copy"></i> Copy';
                                    }, 2000);
                                });
                            }
                        });
                        wrapper.appendChild(btn);
                    });
                })
                .catch(error => {
                    readmeContainer.innerHTML = '<p class="text-muted">Could not load README automatically from GitHub. Click the repository link below to view it.</p>';
                });
        }
    }
});
