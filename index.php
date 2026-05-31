<?php
get_header();
?>

	<main id="primary" class="site-main">

        <!-- HERO SECTION -->
        <section id="hero" class="hero-section">
            <div class="hero-background-effects">
                <div class="glow-orb red-orb"></div>
                <div class="glow-orb orange-orb"></div>
            </div>
            <div class="container hero-content">
                <div class="hero-text animate-fade-up">
                    <p class="hero-greeting">Assalam-o-Alaikum! I'm</p>
                    <h1 class="hero-title">Muhammad <span class="highlight-red">Ammad</span> Younas</h1>
                    <h2 class="hero-subtitle type-effect">Android Developer & Python Enthusiast</h2>
                    <p class="hero-description">
                        I specialize in building native Android applications and automating workflows with Python. Turning ideas into functional, clean, and user-friendly digital experiences.
                    </p>
                    <div class="hero-actions">
                        <a href="#projects" class="btn btn-primary">View My Work <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="#contact" class="btn btn-secondary">Get in Touch</a>
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
                        <p>I am actively developing my skills across the software development lifecycle, including UI design, feature implementation, backend integration, performance optimization, and testing.</p>
                        <p>Alongside Android development, I have hands-on experience in web scraping, automation, and desktop application development, which strengthens my technical foundation.</p>
                        
                        <div class="education-box mt-4">
                            <h4><i class="fa-solid fa-graduation-cap highlight-red"></i> Education</h4>
                            <p><strong>The University of Lahore</strong><br>
                            Bachelor of Science in Computer Science (BSCS)<br>
                            <em>Nov 2022 - Aug 2026</em></p>
                        </div>
                        <div class="certification-box mt-3">
                            <h4><i class="fa-solid fa-certificate highlight-orange"></i> Certifications & Experience</h4>
                            <ul>
                                <li>Defronix Certified Junior Security Practitioner (DCjSP)</li>
                                <li>Internship at CodSoft</li>
                            </ul>
                        </div>
                    </div>
                    <div class="about-image-container animate-fade-up" style="animation-delay: 0.2s;">
                        <div class="about-image-wrapper">
                            <div class="image-placeholder">
                                <i class="fa-solid fa-code"></i>
                            </div>
                            <div class="image-accent-border"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SKILLS SECTION -->
        <section id="skills" class="skills-section section-padding dark-bg">
            <div class="container">
                <div class="section-heading text-center animate-fade-up">
                    <h2 class="section-title">Technical <span class="highlight-red">Skills</span></h2>
                    <div class="section-line mx-auto"></div>
                </div>
                
                <div class="skills-grid">
                    <!-- Skill Card 1 -->
                    <div class="skill-card glass-card animate-fade-up" style="animation-delay: 0.1s;">
                        <div class="skill-icon"><i class="fa-brands fa-android"></i></div>
                        <h3 class="skill-name">Android Development</h3>
                        <p>Native App Development, Kotlin, Java, UI/UX Design, REST APIs integration.</p>
                    </div>
                    
                    <!-- Skill Card 2 -->
                    <div class="skill-card glass-card animate-fade-up" style="animation-delay: 0.2s;">
                        <div class="skill-icon"><i class="fa-brands fa-python"></i></div>
                        <h3 class="skill-name">Python Programming</h3>
                        <p>Automation, Scripting, Web Scraping, Desktop Applications (Tkinter).</p>
                    </div>

                    <!-- Skill Card 3 -->
                    <div class="skill-card glass-card animate-fade-up" style="animation-delay: 0.3s;">
                        <div class="skill-icon"><i class="fa-solid fa-terminal"></i></div>
                        <h3 class="skill-name">Core CS Skills</h3>
                        <p>Data Structures, Algorithms (e.g., DFS), Problem Solving, Version Control (Git).</p>
                    </div>
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

                <div class="projects-grid">
                    <!-- Project 1 -->
                    <div class="project-card glass-card animate-fade-up" style="animation-delay: 0.1s;">
                        <div class="project-content">
                            <h3 class="project-title">QR Generator</h3>
                            <p class="project-desc">QR Generator and Decoder software built using Python and the GUI library Tkinter.</p>
                            <div class="project-tags">
                                <span>Python</span>
                                <span>Tkinter</span>
                                <span>GUI</span>
                            </div>
                            <a href="https://github.com/Ammad-Younas/QR_Generator" target="_blank" class="project-link"><i class="fa-brands fa-github"></i> View Repository</a>
                        </div>
                    </div>

                    <!-- Project 2 -->
                    <div class="project-card glass-card animate-fade-up" style="animation-delay: 0.2s;">
                        <div class="project-content">
                            <h3 class="project-title">Maze Generator & Solver</h3>
                            <p class="project-desc">An algorithmic project focused on generating random mazes and solving them using Depth-First Search (DFS).</p>
                            <div class="project-tags">
                                <span>Algorithms</span>
                                <span>DFS</span>
                                <span>Data Structures</span>
                            </div>
                            <a href="https://github.com/Ammad-Younas/Maze_Generator_and_Solver_Using_DFS" target="_blank" class="project-link"><i class="fa-brands fa-github"></i> View Repository</a>
                        </div>
                    </div>

                    <!-- Project 3 -->
                    <div class="project-card glass-card animate-fade-up" style="animation-delay: 0.3s;">
                        <div class="project-content">
                            <h3 class="project-title">Password Generator</h3>
                            <p class="project-desc">GUI-based software for creating strong, random, and secure passwords effortlessly.</p>
                            <div class="project-tags">
                                <span>Python</span>
                                <span>Security</span>
                                <span>Tool</span>
                            </div>
                            <a href="https://github.com/Ammad-Younas/Password_Generator" target="_blank" class="project-link"><i class="fa-brands fa-github"></i> View Repository</a>
                        </div>
                    </div>
                    
                    <!-- Project 4 -->
                    <div class="project-card glass-card animate-fade-up" style="animation-delay: 0.4s;">
                        <div class="project-content">
                            <h3 class="project-title">Cursor Coordinates Capturer</h3>
                            <p class="project-desc">Real-time GUI software that captures and displays exact cursor coordinates on the screen.</p>
                            <div class="project-tags">
                                <span>Python</span>
                                <span>Automation</span>
                            </div>
                            <a href="https://github.com/Ammad-Younas/Cursor_Coordinates_Captcher" target="_blank" class="project-link"><i class="fa-brands fa-github"></i> View Repository</a>
                        </div>
                    </div>
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

                <div class="contact-container animate-fade-up">
                    <div class="contact-info glass-card">
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fa-solid fa-envelope"></i></div>
                            <div class="contact-details">
                                <h4>Email</h4>
                                <a href="mailto:ammadyounas837@gmail.com">ammadyounas837@gmail.com</a>
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
