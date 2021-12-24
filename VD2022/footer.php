<!-- Start Contact -->
<section class="contact" data-scroll-index="7">
        <div class="left-bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="title">
                        <h2>Get in Touch</h2>
                        <h3>Contact Us</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-6  mt-40">
                            <div class="contact-item">
                                <p><a href="/"><img data-lazy="<?php bloginfo('template_directory');?>/assets/img/vector-defector-logo.svg" class="lazy" width="150" height="55" alt="VectorDefector"></a></p>
                                <div class="social mt-10">
                                        <ul>
                                            <li><a href="https://facebook.com/vectordefector" aria-label="Visit on Facebook" rel="noopener" target="_blank"><i class="fab fa-facebook" aria-hidden="true"></i> </a></li>
                                            <li><a href="https://behance.net/vectordefector" aria-label="Visit on Behance" rel="noopener" target="_blank"><i class="fab fa-behance" aria-hidden="true"></i></a></li>
                                            <li><a href="https://wordpress.org" rel="noopener" aria-label="Wordpress Developer" target="_blank"><i class="fab fa-wordpress" aria-hidden="true"></i></a></li>
                                            <li><a href="https://github.com/tomwc4/share" aria-label="Visit on Github" rel="noopener" target="_blank"><i class="fab fa-github" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                            </div>
                        </div>

                        <div class="col-lg-6  mt-40">
                            <div class="contact-item">
                                <div>
                                    <h3>Say <span>Hello</span></h3>
                                    <div>
                                        <a class="mail" href="mailto:info@vectordefector.com?subject=Contact VectorDefector">info@vectordefector.com</a>
                                    </div>
                                    <div class="mt-10">
                                        <a class="phone" href="tel:3035194563">+303-519-4563</a>
                                    </div>
                                    <div class="mt-10">
                                        Denver, Colorado
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-30">
                    <div class="img-contact line-img">
                        <img class="img-fluid lazy" data-lazy="<?php bloginfo('template_directory');?>/assets/img/contact-footer.webp" width="540" height="338" alt="Made in Denver, Colorado">
                    </div>

                </div>
            </div>

        </div>

    </section>
    <!-- End Contact -->

    <section class="copyrights">
        <div class="copyright">
            &copy <?php echo date('Y');?> VectorDefector, LLC. All rights reserved.
        </div>
    </section>

    <!-- Decoration -->
    <?php if(!is_single() && !is_home()): ?>
    <div class="line-thumb">
        <div class="line-col first"></div>
        <div class="line-col second"></div>
        <div class="line-col third"></div>
        <div class="line-col fourth"></div>
        <div class="line-col fifth"></div>
    </div>
    <?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>