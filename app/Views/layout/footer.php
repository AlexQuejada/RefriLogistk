</main>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <small>
                <i class="fas fa-snowflake"></i> &copy; <?= date('Y') ?> RefriLogistik - 
                Sistema de Gestión de Servicios Técnicos
            </small>
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <script src="/RefriLogistk/public/js/app.js"></script>
    <script src="/RefriLogistk/public/js/dashboard.js"></script>
    <script src="/RefriLogistk/public/js/reporte.js"></script>

    <?php if ($activePage === 'calendario'): ?>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js"></script>
    <script src="/RefriLogistk/public/js/calendario.js"></script>
    <?php endif; ?>
</body>
</html>