<!--plugins-->
<link href="/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
<link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
<link href="/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
<link href="/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<!-- Bootstrap CSS -->
<link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="/assets/css/bootstrap-extended.css" rel="stylesheet" />
<link href="/assets/css/style.css" rel="stylesheet" />
<link href="/assets/css/icons.css" rel="stylesheet">
<link href="/assets/fonts/googleapis.com/css276c7.css?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/fonts/bootstrap-icons-1.13.1/bootstrap-icons.css">

<!-- loader-->
<link href="/assets/css/pace.min.css" rel="stylesheet" />


<!--Theme Styles-->
<link href="/assets/css/dark-theme.css" rel="stylesheet" />
<link href="/assets/css/light-theme.css" rel="stylesheet" />
<link href="/assets/css/semi-dark.css" rel="stylesheet" />
<link href="/assets/css/header-colors.css" rel="stylesheet" />

<style>
    /* Wrapper utama */
    .nav-breadcrumb-dot {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
    }

    /* Link */
    .nav-breadcrumb-dot a {
        color: #0d6efd;
        text-decoration: none;
    }

    /* Hover link */
    .nav-breadcrumb-dot a:hover {
        text-decoration: underline;
    }

    /* Dot sebagai separator */
    .nav-breadcrumb-dot .dot {
        width: 5px;
        height: 5px;
        background-color: #6c757d;
        border-radius: 50%;
        display: inline-block;
    }

    /* Hilangkan dot terakhir (yang paling kanan) */
    .nav-breadcrumb-dot a:last-of-type+.dot {
        display: none;
    }
</style>

@stack('styles')
