<script setup>
const year = new Date().getFullYear()
</script>

<template>
    <footer class="footer">
        <div class="footer__container">
            <div class="footer__socials">
                <a
                    href="https://github.com/abdurohman-karim"
                    target="_blank"
                    rel="noopener"
                    aria-label="GitHub"
                    class="footer__icon"
                >
                    <i class="fab fa-github"></i>
                </a>
                <a
                    href="https://www.linkedin.com/in/abdurohman-karim"
                    target="_blank"
                    rel="noopener"
                    aria-label="LinkedIn"
                    class="footer__icon"
                >
                    <i class="fab fa-linkedin"></i>
                </a>
                <a
                    href="https://t.me/abdurohman_karimov"
                    target="_blank"
                    rel="noopener"
                    aria-label="Telegram"
                    class="footer__icon"
                >
                    <i class="fab fa-telegram"></i>
                </a>
                <a
                    href="mailto:ghostmagic766@gmail.com"
                    aria-label="Email"
                    class="footer__icon"
                >
                    <i class="fas fa-envelope"></i>
                </a>
            </div>

            <p class="footer__text">
                © {{ year }} <span class="footer__name">Abdurohman</span>. All rights reserved.
            </p>
        </div>
    </footer>
</template>
