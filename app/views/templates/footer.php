</div> <!-- End of main-content -->

<footer>
    <div class="container footer-content">
        <?php $brand = $data['home']['brand'] ?? (require '../app/config/home_data.php')['brand']; ?>
        <p>&copy; <?= date('Y'); ?> <?= $brand['name']; ?> - Aplikasi Mentorship PWL. Desain premium dengan HTML & CSS Murni.</p>
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
