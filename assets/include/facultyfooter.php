</div>

<div class="footer">
    <footer>
        <p class="footer-text">&copy; <span id="currentYear"></span> Document Management System by Kukil phukan. All rights reserved.</p>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let currentYear = new Date().getFullYear();
                let currentYearSpan = document.querySelector("#currentYear");
                currentYearSpan.innerHTML = currentYear;
            });
        </script>
    </footer>
</div>

</body>

<script>
    function toggleNav(icon) {
        var navItems = document.getElementById('navitems');
        navItems.classList.toggle('showtoggle');
        if (navItems.classList.contains('showtoggle')) {
            icon.classList.replace('fa-bars', 'fa-xmark');
        } else {
            icon.classList.replace('fa-xmark', 'fa-bars');
        }
    }
</script>

</html>