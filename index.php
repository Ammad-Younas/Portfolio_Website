<?php
require_once __DIR__ . '/includes/functions.php';
get_header();
?>

	<main id="primary" class="site-main">

        <!-- HERO SECTION -->
        <section id="hero" class="hero-section">
            <div class="hero-background-effects">
                <div class="glow-orb red-orb"></div>
                <div class="glow-orb orange-orb"></div>
            </div>
            <div class="container hero-content grid-2-col" style="align-items: center;">
                <div class="hero-text animate-fade-up">
                    <p class="hero-greeting">Hi, I'm</p>
                    <h1 class="hero-title" style="user-select: none;">Muhammad <span class="highlight-red" id="roadmap-trigger">Ammad</span> Younas</h1>
                    <h2 class="hero-subtitle type-effect">Android Developer & Python Enthusiast</h2>
                    <p class="hero-description">
                        I specialize in building native Android applications and automating workflows with Python. Turning ideas into functional, clean and user-friendly digital experiences.
                    </p>
                    <div class="hero-actions">
                        <a href="#projects" class="btn btn-primary">View My Work &nbsp;<i class="fa-solid fa-arrow-right"></i></a>
                        <a href="#contact" class="btn btn-secondary">Get in Touch &nbsp;<i class="fa-solid fa-envelope"></i></a>
                        <a href="https://drive.google.com/file/d/1nNG011n5-dohLoW5seiV78bAsG0getTi/view?usp=sharing" target="_blank" class="btn btn-secondary">Download CV &nbsp;<i class="fa-solid fa-download"></i></a>
                    </div>
                </div>
                <div class="hero-image-container animate-fade-up" style="animation-delay: 0.2s; text-align: center;">
                    <div class="hero-image-wrapper glass-card" style="display: inline-block; padding: 20px; border-radius: 50%; width: 100%; max-width: 350px; aspect-ratio: 1/1; position: relative;">
                        <!-- Profile Pic -->
                        <div class="image-placeholder" style="width: 100%; height: 100%; border-radius: 50%; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 2px solid var(--color-red); background-color: #EFD6AE;">
                            <img src="<?php echo esc_url( home_url( '/assets/' ) ); ?>avatar/ammad.png" alt="Ammad Younas" style="width: 100%; height: 100%; object-fit: contain; margin-top: 40px;">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ABOUT SECTION -->
        <section id="about" class="about-section section-padding">
            <div class="container">
                <div class="section-heading animate-fade-up">
                    <h2 class="section-title">About <span class="highlight-orange">Me</span></h2>
                    <div class="section-line"></div>
                </div>
                <div class="about-content grid-2-col">
                    <div class="about-text glass-card animate-fade-up" style="animation-delay: 0.1s;">
                        <h3>Aspiring Developer with a passion for problem-solving</h3>
                        <p>I am actively developing my skills across the software development lifecycle, including UI design, feature implementation, backend integration, performance optimization and testing.</p>
                        <p>Alongside Android development, I have hands-on experience in web scraping, automation and desktop application development, which strengthens my technical foundation.</p>
                        <p>I am continuously learning, experimenting, and seeking opportunities to grow my career in Android development through internships, collaborations, and real-world projects.</p>

                        <div class="text-center mt-5 animate-fade-up" style="animation-delay: 0.7s;">
                            <a href="#contact" class="btn btn-primary" style="margin-top: 30px; display: block; width: 100%;">Let's Talk</a>
                        </div>

                    </div>
                    <div class="about-image-container animate-fade-up" style="animation-delay: 0.2s;">
                        <div class="about-image-wrapper">
                            <div class="image-placeholder profile-card">
                                <div class="profile-socials">
                                    <a href="https://github.com/Ammad-Younas" target="_blank" class="profile-social-item">
                                        <div class="social-icon-box"><i class="fa-brands fa-github"></i></div>
                                        <div class="social-text">
                                            <span class="social-name">GitHub</span>
                                            <span class="social-username">@Ammad-Younas</span>
                                        </div>
                                    </a>
                                    
                                    <a href="https://www.linkedin.com/in/ammad-younas" target="_blank" class="profile-social-item">
                                        <div class="social-icon-box"><i class="fa-brands fa-linkedin-in"></i></div>
                                        <div class="social-text">
                                            <span class="social-name">LinkedIn</span>
                                            <span class="social-username">ammad-younas</span>
                                        </div>
                                    </a>
                                    
                                    <a href="mailto:ammadyounas.tech@gmail.com" class="profile-social-item">
                                        <div class="social-icon-box"><i class="fa-solid fa-envelope"></i></div>
                                        <div class="social-text">
                                            <span class="social-name">Email</span>
                                            <span class="social-username">ammadyounas.tech@gmail.com</span>
                                        </div>
                                    </a>

                                    <a href="https://www.facebook.com/ammad.younas.92" target="_blank" class="profile-social-item">
                                        <div class="social-icon-box"><i class="fa-brands fa-facebook"></i></div>
                                        <div class="social-text">
                                            <span class="social-name">Facebook</span>
                                            <span class="social-username">ammad.younas.92</span>
                                        </div>
                                    </a>

                                    <a href="https://www.instagram.com/ammad.younas.92" target="_blank" class="profile-social-item">
                                        <div class="social-icon-box"><i class="fa-brands fa-instagram"></i></div>
                                        <div class="social-text">
                                            <span class="social-name">Instagram</span>
                                            <span class="social-username">ammad.younas.92</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- JOURNEY/TIMELINE SECTION -->
        <section id="journey" class="journey-section section-padding">
            <div class="container">
                <div class="section-heading text-center animate-fade-up">
                    <h2 class="section-title">My <span class="highlight-red">Journey</span></h2>
                    <div class="section-line mx-auto"></div>
                </div>
                
                <div class="timeline-grid mt-5">
                    <!-- Education Column -->
                    <div class="timeline-col animate-fade-up" style="animation-delay: 0.1s;">
                        <h3 class="timeline-title mb-4"><i class="fa-solid fa-graduation-cap highlight-red"></i> Education</h3>
                        <div class="timeline">
                            <div class="timeline-item glass-card">
                                <div class="timeline-dot"></div>
                                <h4>Bachelor of Science in Computer Science (BSCS)</h4>
                                <h5><strong><span class="highlight-red">University:</span></strong> The University of Lahore</h5>
                                <span class="timeline-date">Nov 2022 - June 2026</span>
                                <p class="mt-3 text-muted" style="font-size: 0.9rem; color: var(--text-muted);">Learned core concepts of Software Engineering, including programming fundamentals, object-oriented design, database systems, operating systems, computer networks. Developed practical skills in mobile application development and problem-solving through academic coursework and real-world projects. Gained experience in translating theoretical knowledge into scalable and user-focused software solutions.</p>
                                <a href="https://drive.google.com/file/d/1SL44XruiowFVh9g0n_PjtN03EcVX1Oqx/view?usp=sharing" target="_blank" class="btn-cert mt-3"><i class="fa-solid fa-file-lines"></i> View Transcript</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Experience Column -->
                    <div class="timeline-col animate-fade-up" style="animation-delay: 0.2s;">
                        <h3 class="timeline-title mb-4"><i class="fa-solid fa-briefcase highlight-orange"></i> Experience</h3>
                        
                        <div class="timeline">
                            <div class="timeline-item glass-card">
                                <div class="timeline-dot"></div>
                                <h4>Android App Development</h4>
                                <h5><strong><span class="highlight-orange">Highlight:</span></strong> Native Developer</h5>
                                <span class="timeline-date">2025 - Current</span>
                                <p class="mt-3 text-muted" style="font-size: 0.9rem; color: var(--text-muted);">Building scalable, user-centric mobile applications using modern Android frameworks and industry best practices.</p>
                                <a href="#projects" class="btn-cert-small mt-2"><i class="fa-solid fa-eye"></i> View Projects</a>
                            </div>
                            <div class="timeline-item glass-card">
                                <div class="timeline-dot"></div>
                                <h4>Python Desktop Application Development</h4>
                                <h5><strong><span class="highlight-orange">Highlight:</span></strong> Python Internship at <a href="https://www.linkedin.com/company/codsoft/" target="_blank" style="color: var(--highlight-orange); text-decoration: underline;">CodSoft</a></h5>
                                <span class="timeline-date">2023 - 2024</span>
                                <p class="mt-3 text-muted" style="font-size: 0.9rem; color: var(--text-muted);">Completed a comprehensive Python internship focused on building robust desktop applications with intuitive user interfaces.</p>
                                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; margin-top: 15px;">
                                    <a href="https://drive.google.com/file/d/1ALY-1tRmbGh2cSTOCn98DuiJf8O_Ltej/view?usp=sharing" target="_blank" class="btn-cert-small"><i class="fa-solid fa-file-lines"></i> View Certificate</a>
                                    <a href="https://github.com/Ammad-Younas?tab=repositories" target="_blank" class="btn-cert-small"><i class="fa-solid fa-eye"></i> View Projects</a>
                                </div>
                            </div>
                            <div class="timeline-item glass-card">
                                <div class="timeline-dot"></div>
                                <h4>Python Web Scraping</h4>
                                <h5><strong><span class="highlight-orange">Highlight:</span></strong> Freelance</h5>
                                <span class="timeline-date">2020 - 2022</span>
                                <p class="mt-3 text-muted" style="font-size: 0.9rem; color: var(--text-muted);">Developed efficient automation scripts and web scrapers to extract and manage data from complex web platforms.</p>
                                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; margin-top: 15px;">
                                    <a href="#odoo_scraper" class="btn-cert-small"><i class="fa-solid fa-eye"></i> View Project</a>
                                    <a href="https://github.com/Ammad-Younas?tab=repositories" target="_blank" class="btn-cert-small"><i class="fa-brands fa-github"></i> Other Projects</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Certifications Column -->
                    <div class="timeline-col timeline-orange animate-fade-up" style="animation-delay: 0.3s;">
                        <h3 class="timeline-title mb-4"><i class="fa-solid fa-certificate highlight-orange"></i> Certifications</h3>
                        <div class="timeline">
                            <div class="timeline-item glass-card">
                                <div class="timeline-dot"></div>
                                <h4>Defronix Certified Junior Security Practitioner (DCjSP)</h4>
                                <h5><strong><span class="highlight-orange">Defronix:</span></strong> Side Learning</h5>
                                <span class="timeline-date">2021</span>
                                <p class="mt-3 text-muted" style="font-size: 0.9rem; color: var(--text-muted);">I learned the basics of cybersecurity and how to protect computers and networks from online threats. I also gained practical experience in finding weak spots in systems so they can be safely fixed before hackers can take advantage of them.</p>
                                <a href="https://drive.google.com/file/d/1Ohfpn9g187XD9tKTaKcCiDj4wL6747lT/view?usp=sharing" target="_blank" class="btn-cert-small mt-2"><i class="fa-solid fa-file-lines"></i> View Certificate</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TECH STACK/Skills SECTION -->
        <section id="skills" class="skills-section section-padding dark-bg">
            <div class="container">
                <div class="section-heading text-center animate-fade-up">
                    <h2 class="section-title">Tech <span class="highlight-red">Stack</span></h2>
                    <div class="section-line mx-auto"></div>
                </div>
                
                <div class="tech-stack-grid animate-fade-up">
                    <?php
                    $tech_stack = [
                        ['name' => 'Kotlin', 'icon' => home_url( '/assets/images/tech_stack/kotlin.svg' )],
                        ['name' => 'Jetpack Compose', 'icon' => home_url( '/assets/images/tech_stack/jetpackcompose.svg' )],
                        ['name' => 'Python', 'icon' => home_url( '/assets/images/tech_stack/python.svg' )],
                        ['name' => 'Dart', 'icon' => home_url( '/assets/images/tech_stack/dart.svg' )],
                        ['name' => 'Flutter', 'icon' => home_url( '/assets/images/tech_stack/flutter.svg' )],
                        ['name' => 'FastAPI', 'icon' => home_url( '/assets/images/tech_stack/fastapi.svg' )],
                        ['name' => 'Redis', 'icon' => home_url( '/assets/images/tech_stack/redis.svg' )],
                        ['name' => 'SQL', 'icon' => home_url( '/assets/images/tech_stack/sql.svg' )],
                        ['name' => 'SQLite', 'icon' => home_url( '/assets/images/tech_stack/sqlite.svg' )],
                        ['name' => 'Firebase', 'icon' => home_url( '/assets/images/tech_stack/firebase.svg' )],
                        ['name' => 'Git', 'icon' => home_url( '/assets/images/tech_stack/git.svg' )],
                        ['name' => 'GitHub', 'icon' => home_url( '/assets/images/tech_stack/github.svg' )],
                        ['name' => 'REST APIs', 'icon' => home_url( '/assets/images/tech_stack/rest-apis.svg' )],
                        ['name' => 'Selenium', 'icon' => home_url( '/assets/images/tech_stack/selenium.svg' )],
                        ['name' => 'Scrapy', 'icon' => home_url( '/assets/images/tech_stack/scrapy.svg' )],
                        ['name' => 'Postman', 'icon' => home_url( '/assets/images/tech_stack/postman.svg' )],
                        ['name' => 'Linux', 'icon' => home_url( '/assets/images/tech_stack/linux.svg' )],
                    ];
                    
                    foreach ($tech_stack as $tech) {
                        echo '<div class="tech-card glass-card">';
                        echo '<img src="' . esc_url($tech['icon']) . '" alt="' . esc_attr($tech['name']) . '" class="tech-icon">';
                        echo '<span class="tech-name">' . esc_html($tech['name']) . '</span>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- PROJECTS SECTION -->
        <section id="projects" class="projects-section section-padding">
            <div class="container">
                <div class="section-heading text-center animate-fade-up">
                    <h2 class="section-title">Featured <span class="highlight-orange">Projects</span></h2>
                    <div class="section-line mx-auto"></div>
                </div>

                <div class="projects-filter animate-fade-up" style="animation-delay: 0.1s;">
                    <button class="filter-btn active" data-filter="all">All</button>
                    <button class="filter-btn" data-filter="python">Python</button>
                    <button class="filter-btn" data-filter="android">Android</button>
                </div>

                <div class="projects-grid">
                    <!-- Project 1 -->
                    <div class="project-card glass-card animate-fade-up project-item" data-category="android" style="animation-delay: 0.1s;">
                        <img src="<?php echo esc_url( home_url( '/assets/' ) ); ?>images/projects_header_images/appointment_booking_app.jpg" alt="Appointment Booking App" class="project-img">
                        <div class="project-content">
                            <h3 class="project-title">Appointment Booking App</h3>
                            <p class="project-desc">A cross-platform Flutter application designed to seamlessly connect patients with healthcare professionals by appointment scheduling and management.</p>
                            <div class="project-tags">
                                <span>Flutter</span>    
                                <span>Dart</span>
                                <span>Firebase</span>
                                <span>Cross Platform Development</span>
                            </div>
                            <div class="project-links" style="display: flex; gap: 15px; flex-wrap: wrap;">
                                <a href="https://github.com/Ammad-Younas/Appointment_Booking_App" target="_blank" class="project-link"><i class="fa-brands fa-github"></i> View Repository</a>
                                <a href="<?php echo esc_url( home_url( '/src/projects/appointment_booking_app.php' )  ); ?>" class="project-link"><i class="fa-solid fa-arrow-up-right-from-square"></i> View Details</a>
                            </div>
                        </div>
                    </div>

                    <!-- Project 2 -->
                    <div class="project-card glass-card animate-fade-up project-item" data-category="android" style="animation-delay: 0.2s;">
                        <img src="<?php echo esc_url( home_url( '/assets/' ) ); ?>images/projects_header_images/under_byte.jpg" alt="Under Byte" class="project-img">
                        <div class="project-content">
                            <h3 class="project-title">Under Byte</h3>
                            <p class="project-desc">An Android messaging app combining room-based chat functionality with advanced steganography integration.</p>
                            <div class="project-tags">
                                <span>Android Development</span>
                                <span>Kotlin</span>
                                <span>Steganography</span>
                                <span>Mobile Chat Application</span>
                            </div>
                            <div class="project-links" style="display: flex; gap: 15px; flex-wrap: wrap;">
                                <a href="https://github.com/Ammad-Younas/Under-Byte" target="_blank" class="project-link"><i class="fa-brands fa-github"></i> View Repository</a>
                                <a href="<?php echo esc_url( home_url( '/src/projects/under_byte.php' )  ); ?>" class="project-link"><i class="fa-solid fa-arrow-up-right-from-square"></i> View Details</a>
                            </div>
                        </div>
                    </div>

                    <!-- Project 3 -->
                    <div class="project-card glass-card animate-fade-up project-item" data-category="android" style="animation-delay: 0.3s;">
                        <img src="<?php echo esc_url( home_url( '/assets/' ) ); ?>images/projects_header_images/recipe_app.jpg" alt="Recipe App" class="project-img">
                        <div class="project-content">
                            <h3 class="project-title">Recipe App</h3>
                            <p class="project-desc">An Android application developed in Kotlin that fetches and displays recipe categories via modern API integration.</p>
                            <div class="project-tags">
                                <span>Android Development</span>
                                <span>Kotlin</span>
                                <span>API Integration</span>
                                <span>MVVM Architecture</span>
                            </div>
                            <div class="project-links" style="display: flex; gap: 15px; flex-wrap: wrap;">
                                <a href="https://github.com/Ammad-Younas/Android_Development_Journey/tree/main/RecipeApp" target="_blank" class="project-link"><i class="fa-brands fa-github"></i> View Repository</a>
                                <a href="<?php echo esc_url( home_url( '/src/projects/recipe_app.php' )  ); ?>" class="project-link"><i class="fa-solid fa-arrow-up-right-from-square"></i> View Details</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Project 4 -->
                    <div class="project-card glass-card animate-fade-up project-item" data-category="python" style="animation-delay: 0.4s;" id="odoo_scraper">
                        <img src="<?php echo esc_url( home_url( '/assets/' ) ); ?>images/projects_header_images/odoo_partner_scraper.jpg" alt="Odoo Partner Scraper" class="project-img">
                        <div class="project-content">
                            <h3 class="project-title">Odoo Partner Scraper</h3>
                            <p class="project-desc">A Python automation utility built to extract partner data from Odoo platforms, driven by a central scraping script and managed via standard Python dependency files.</p>
                            <div class="project-tags">
                                <span>Python</span>
                                <span>Automation</span>
                                <span>Web Scraping</span>
                                <span>Odoo</span>
                            </div>
                            <div class="project-links" style="display: flex; gap: 15px; flex-wrap: wrap;">
                                <a href="https://github.com/Ammad-Younas/Odoo_Scraper" target="_blank" class="project-link"><i class="fa-brands fa-github"></i> View Repository</a>
                                <a href="<?php echo esc_url( home_url( '/src/projects/odoo_partner_scraper.php' )  ); ?>" class="project-link"><i class="fa-solid fa-arrow-up-right-from-square"></i> View Details</a>
                            </div>
                        </div>
                    </div>

                    <!-- Project 5 -->
                    <div class="project-card glass-card animate-fade-up project-item" data-category="python" style="animation-delay: 0.5s;">
                        <img src="<?php echo esc_url( home_url( '/assets/' ) ); ?>images/projects_header_images/yt_as_storage.png" alt="Youtube As Unlimited Storage" class="project-img">
                        <div class="project-content">
                            <h3 class="project-title">YouTube As Unlimited Storage</h3>
                            <p class="project-desc">A Python tool designed to encode files into videos and decode them back, effectively transforming YouTube into an unlimited storage drive.</p>
                            <div class="project-tags">
                                <span>Python</span>
                                <span>File Conversion</span>
                                <span>Data Encoding</span>
                            </div>
                            <div class="project-links" style="display: flex; gap: 15px; flex-wrap: wrap;">
                                <a href="https://github.com/Ammad-Younas/Youtube_As_Unlimited_Storage" target="_blank" class="project-link"><i class="fa-brands fa-github"></i> View Repository</a>
                                <a href="<?php echo esc_url( home_url( '/src/projects/youtube_as_unlimited_storage.php' )  ); ?>" class="project-link"><i class="fa-solid fa-arrow-up-right-from-square"></i> View Details</a>
                            </div>
                        </div>
                    </div>

                    <!-- Project 6 -->
                    <div class="project-card glass-card animate-fade-up project-item" data-category="python" style="animation-delay: 0.6s;">
                        <img src="<?php echo esc_url( home_url( '/assets/' ) ); ?>images/projects_header_images/portable_exe_gen.png" alt="Portable EXE Generator" class="project-img">
                        <div class="project-content">
                            <h3 class="project-title">Portable EXE Generator</h3>
                            <p class="project-desc">A software tool built with Python for generating standalone portable executables using self-extracting archive modules.</p>
                            <div class="project-tags">
                                <span>Python</span>
                                <span>Automation</span>
                                <span>SFX Archive</span>
                                <span>Executable Generator</span>
                            </div>
                            <div class="project-links" style="display: flex; gap: 15px; flex-wrap: wrap;">
                                <a href="https://github.com/Ammad-Younas/Portable_EXE_Generator" target="_blank" class="project-link"><i class="fa-brands fa-github"></i> View Repository</a>
                                <a href="<?php echo esc_url( home_url( '/src/projects/portable_exe_gen.php' )  ); ?>" class="project-link"><i class="fa-solid fa-arrow-up-right-from-square"></i> View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5 animate-fade-up" style="animation-delay: 0.7s;">
                    <a href="https://github.com/Ammad-Younas?tab=repositories" target="_blank" class="btn btn-primary" style="margin-top: 30px;">View all projects</a>
                </div>
            </div>
        </section>

        <!-- CONTACT SECTION -->
        <section id="contact" class="contact-section section-padding dark-bg relative">
            <div class="glow-orb orange-orb bottom-orb"></div>
            <div class="container">
                <div class="section-heading text-center animate-fade-up">
                    <h2 class="section-title">Get In <span class="highlight-red">Touch</span></h2>
                    <div class="section-line mx-auto"></div>
                    <p class="contact-subtitle mt-3">I'm currently looking for new opportunities. My inbox is always open.</p>
                </div>

                <div class="contact-container animate-fade-up grid-2-col" style="max-width: 1000px;">
                    <div class="contact-form-wrapper glass-card">
                        <form id="contact-form" class="contact-form">
                            <div class="form-group">
                                <label for="contact-name">Name</label>
                                <input type="text" id="contact-name" name="name" required placeholder="Your Name">
                            </div>
                            <div class="form-group">
                                <label for="contact-email">Email</label>
                                <input type="email" id="contact-email" name="email" required placeholder="Your Email">
                            </div>
                            <div class="form-group">
                                <label for="contact-message">Message</label>
                                <textarea id="contact-message" name="message" required rows="4" placeholder="Your Message"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-3" id="submit-btn" style="width: 100%;">
                                <span class="btn-text">Send Message <i class="fa-solid fa-paper-plane"></i></span>
                            </button>
                            <div id="form-messages" class="mt-3"></div>
                        </form>
                    </div>

                    <div class="contact-info glass-card">
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fa-solid fa-envelope"></i></div>
                            <div class="contact-details">
                                <h4>Email</h4>
                                <a href="mailto:ammadyounas.tech@gmail.com">ammadyounas.tech@gmail.com</a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fa-solid fa-phone"></i></div>
                            <div class="contact-details">
                                <h4>Phone</h4>
                                <a href="tel:+923017047024">+92 301 7047024</a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fa-solid fa-location-dot"></i></div>
                            <div class="contact-details">
                                <h4>Location</h4>
                                <p>Sargodha, Punjab, Pakistan</p>
                            </div>
                        </div>
                        <div class="social-links-lg mt-4">
                            <a href="https://github.com/Ammad-Younas" target="_blank" class="social-btn"><i class="fa-brands fa-github"></i></a>
                            <a href="https://www.linkedin.com/in/ammad-younas" target="_blank" class="social-btn"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

	</main>

<?php
get_footer();

