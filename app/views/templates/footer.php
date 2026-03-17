</div> <!-- End of main-content -->

<footer>
    <div class="container footer-content">
        <?php $brand = $data['home']['brand'] ?? (require '../app/config/home_data.php')['brand']; ?>
        <p>&copy; <?= date('Y'); ?> <?= $brand['name']; ?> SMK Immanuel Pontianak</p>
    </div>
</footer>

<script>
    // Simple script to dismiss flash messages or animations
    document.addEventListener('DOMContentLoaded', () => {
        const flashes = document.querySelectorAll('.alert-dismissible .btn-close');
        flashes.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.target.parentElement.style.display = 'none';
            });
        });

        // Navbar toggle
        const navToggle = document.getElementById('navToggle');
        const navLinks = document.getElementById('navLinks');

        if (navToggle && navLinks) {
            navToggle.addEventListener('click', () => {
                navLinks.classList.toggle('active');
                const icon = navToggle.querySelector('i');
                if (navLinks.classList.contains('active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-xmark');
                } else {
                    icon.classList.remove('fa-xmark');
                    icon.classList.add('fa-bars');
                }
            });
        }

        // Add scrolled class to navbar
        window.addEventListener('scroll', () => {
            if(window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('scrolled');
            } else {
                document.querySelector('.navbar').classList.remove('scrolled');
            }
        });
    });
</script>
</body>
</html>
